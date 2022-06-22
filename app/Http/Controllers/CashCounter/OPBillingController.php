<?php

namespace App\Http\Controllers\CashCounter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\CashCounter\OPBills\BillDetailsResourceCollection;
use App\Http\Resources\CashCounter\OPBills\BilledPatientResource;
use App\Http\Resources\CashCounter\OPBills\PatientResourceCollection;
use App\Models\CardType;
use App\Models\Doctor;
use App\Models\Fee;
use App\Models\OPBill;
use App\Models\OPBillDetail;
use App\Models\PaymentType;
use App\Models\Registration;
use App\Models\Test;
use App\Models\GroupTest;
use App\Models\Profile;
use App\Models\OpLabResult;
use Illuminate\Support\Facades\DB;

class OPBillingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): array
    {
        return [
            'pid' => Registration::orderBy('id', 'desc')->limit(250)->get(['id','uhid']),
            'cons' => DB::table('doctors')
                ->where('status', 'Active')
                ->orderBy('name')
                ->get(['id', 'name']),
            'lab' => DB::table('tests')->get(['id', 'name']),
            'groupTests' => DB::table('group_tests')->get(['id', 'name']),
            'profiles' => DB::table('profiles')->get(['id', 'name']),
            'payType' => PaymentType::distinct()->pluck('name')->sort()->values(),
            'cardType' => CardType::distinct()->pluck('name')->sort()->values(),
            'fees' => DB::table('fees')->get(['id', 'department', 'name']),
        ];
    }

    public function getPatientDetails(int $id): array
    {
        $row = Registration::find($id, ['salutation', 'name', 'age', 'gender', 'contact_no', 'doctor_id']);

        return [
            'name' => $row->salutation . '.' . $row->name,
            'age' => $row->age,
            'gender' => $row->gender,
            'contact' => $row->contact_no,
            'consultant' => $row->doctor_id,
        ];
    }

    public function getFeesCost(int $id): \App\Models\Fee
    {
        return Fee::find($id, ['category', 'op_cost as cost']);
    }

    public function getTestCost(int $id): \App\Models\Test
    {
        return Test::find($id, ['category', 'fees as cost']);
    }

    public function getGroupTestCost(int $id): \App\Models\GroupTest
    {
        return GroupTest::find($id, ['category', 'fees as cost']);
    }

    public function getProfileCost(int $id): array
    {
        $profile_cost = Profile::find($id, ['fees'])->fees;
        return ['category' => 'Profile', 'cost' => $profile_cost];
    }

    public function getIds(): \Illuminate\Support\Collection
    {
        return Registration::select(['id','uhid'])->orderBy('id', 'desc')
            ->limit(250)
            ->get(['id','uhid']);
    }

    public function searchPatients(Request $request): PatientResourceCollection
    {
        $search = $request->input('search');

        $data = Registration::distinct()
            ->when(intval($search) > 0, function ($query) use ($search) {
                $query->where('id', '=', $search);
            })
            ->orWhere('name', 'like', $search . '%')
            ->orwhere('contact_no', 'like', $search . '%')
            ->orderBy('id', 'desc')
            ->get(['id', 'salutation', 'name', 'contact_no']);

        PatientResourceCollection::$wrap = 'patients';
        return PatientResourceCollection::make($data);
    }

    private function generateBillNo(string $year): int
    {
        return (OPBill::where('year', '=', $year)->max('bill_no') ?? 0) + 1;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): array
    {
        $data = \json_decode($request->getContent());

        $year = generateYear();
        $bill_no = $this->generateBillNo($year);

        $opBill = OPBill::create([
            'year' => $year,
            'bill_no' => $bill_no,
            'pt_id' => $data->ptId,
            'doctor_id' => $data->consultant,
            'total' => $data->total,
            'discount' => $data->discount,
            'sub_total' => $data->subTotal,
            'paid' => $data->paying,
            'due' => $data->due,
            'refund' => $data->refund,
            'payment_method' => $data->payType,
            'other_payment' => $data->otherType,
            'card_no' => $data->cardNo,
            'card_type' => $data->cardType,
            'card_expiry' => $data->cardExpiry,
            'user_id' => session('user_id'),
        ]);

        $insertData = [];
        foreach ($data->addedFees as $detail) {
            $insertData[] = [
                'bill_id' => $opBill->id,
                'pt_id' => $data->ptId,
                'department' => $detail->dept,
                'category' => $detail->category,
                'fees_id' => $detail->feesId,
                'fees_type' => $detail->feesType,
                'test_type' => $detail->testType,
                'fees' => $detail->cost,
                'discount' => $detail->discount,
            ];
        }
        OPBillDetail::insert($insertData);

        return [
            'status' => true,
            'message' => 'Bill Saved',
            'id' => $opBill->id,
            'bill_no' => $bill_no,
        ];
    }

    public function getYears(): array
    {
        $years = OPBill::select('year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        $bill_nos = $years->isEmpty() ? [] : $this->getBillNos($years->first());

        return compact('years', 'bill_nos');
    }

    public function getBillNos(string $year): \Illuminate\Support\Collection
    {
        return OPBill::where('year', $year)->get(['id', 'bill_no as billNo'])->sortByDesc('id')->values();
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $id): array
    {
        $opData = OPBill::findOrFail($id);

        return [
            'data' => new BilledPatientResource($opData),
            'fees_data' => new BillDetailsResourceCollection($opData->billDetails),
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $data = json_decode($request->getContent());

        $opBill = OPBill::find($id);

        $opBill->doctor_id = $data->consultant;
        $opBill->total = $data->total;
        $opBill->discount = $data->discount;
        $opBill->sub_total = $data->subTotal;
        $opBill->paid = $data->paying;
        $opBill->due = $data->due;
        $opBill->refund = $data->refund;
        $opBill->payment_method = $data->payType;
        $opBill->other_payment = $data->otherType;
        $opBill->card_no = $data->cardNo;
        $opBill->card_type = $data->cardType;
        $opBill->card_expiry = $data->cardExpiry;

        $opBill->save();

        OPBillDetail::where('bill_id', '=', $id)->delete();

        foreach ($data->addedFees as $detail) {
            $insertData[] = [
                'bill_id' => $id,
                'pt_id' => $data->oldPtId,
                'department' => $detail->dept,
                'category' => $detail->category,
                'fees_id' => $detail->feesId,
                'fees_type' => $detail->feesType,
                'test_type' => $detail->testType,
                'fees' => $detail->cost,
                'discount' => $detail->discount,
            ];
        }
        OPBillDetail::insert($insertData);

        return response('Bill Details Updated', 200, [
            'Content-Type' => 'text/plain',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        OPBill::where('id', '=', $id)->delete();
        OpLabResult::where('bill_id', '=', $id)->delete();

        return response('Bill Details Deleted')->header('Content-Type', 'text/plain');
    }
}
