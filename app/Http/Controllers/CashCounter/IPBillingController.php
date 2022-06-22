<?php

namespace App\Http\Controllers\CashCounter;

use App\Models\IPBill;
use App\Models\CardType;
use App\Models\IPAdmission;
use App\Models\IPDischarge;
use App\Models\PaymentType;
use App\Models\IPBillDetail;
use App\Models\Registration;
use Illuminate\Http\Request;
use App\Models\IPTreatmentDetails;
use App\Http\Controllers\Controller;
use App\Http\Resources\CashCounter\IPBills\BillResource;
use App\Http\Resources\CashCounter\IPBills\PatientResource;
use App\Http\Resources\CashCounter\IPBills\TreatmentResourceCollection;

class IPBillingController extends Controller
{
    public function index()
    {
        $years = IPAdmission::distinct()->orderByDesc('year')->pluck('year');
        $ip_nos = $years->isEmpty() ? [] : $this->getIpNos($years->first());
        $pay_types = PaymentType::pluck('name');
        $card_types = CardType::pluck('name')->sort()->values();

        return [
            'years' => $years,
            'ipNos' => $ip_nos,
            'payTypes' => $pay_types,
            'cardTypes' => $card_types
        ];
    }

    public function getIpNos(string $year)
    {
        return IPAdmission::where('year', '=', $year)
                        ->has('discharge')
                        ->doesntHave('billing')
                        ->get(['id', 'ip_no as ipNo'])
                        ->sortByDesc('id')
                        ->values();
    }

    public function getTreatments(int $ip_id)
    {
        $treatments = IPTreatmentDetails::where('ip_id', '=', $ip_id)
                ->select(['department', 'category', 'fees_id', 'fees_type', 'qty', 'cost', 'total'])
                ->get();

        $patient_details = IPAdmission::find($ip_id);

        return [
            'data' => PatientResource::make($patient_details),
            'treatments' => TreatmentResourceCollection::make($treatments)
        ];
    }

    public function store(Request $request): array
    {
        $bill_year = \generateYear();
        $bill_no = IPBill::where('year', '=', $bill_year)->max('bill_no') ?? 0;

        $request_data = \json_decode($request->getContent());
        $data = $request_data->data;
        $treatments = $request_data->treatments;
        $ptId = explode('/',$data->ptId);
        // dd((int)$ptId[0]);
        IPBill::create([
            'year' => $bill_year,
            'bill_no' => $bill_no + 1,
            'ip_id' => $data->ipNo,
            'pt_id' => (int)$ptId[0],
            'total' => $data->total,
            'advance_paid' => $data->advance,
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
            'user_id' => $request->session()->get('user_id')
        ]);

        $bill_id = IPBill::max('id');

        $bill_details = [];

        foreach ($treatments as $treatment) {
            $bill_details[] = [
                'bill_id' => $bill_id,
                'ip_id' => $data->ipNo,
                'pt_id' => (int)$ptId[0],
                'department' => $treatment->dept,
                'category' => $treatment->category,
                'fees_id' => $treatment->feesId,
                'fees_type' => $treatment->service,
                'cost' => $treatment->cost,
                'discount' => $treatment->discount,
                'qty' => $treatment->qty,
                'total' => $treatment->total
            ];
        }

        IPBillDetail::insert($bill_details);

        return [
            'message' => 'Bill Saved!!!',
            'billId' => $bill_id
        ];
    }

    public function getBillNos(string $year): \Illuminate\Database\Eloquent\Collection
    {
        return IPBill::where('year', '=', $year)
                        ->get(['id', 'bill_no as billNo'])
                        ->sortByDesc('id')
                        ->values();
    }

    public function show(int $bill_id)
    {
        $ip_bill = IPBill::find($bill_id);
        return [
            'data' => BillResource::make($ip_bill),
            'treatments' => TreatmentResourceCollection::make($ip_bill->billDetails)
        ];
    }

    public function update(int $id, Request $request): \Illuminate\Http\Response
    {
        $request_data = \json_decode($request->getContent());
        $data = $request_data->data;
        $treatments = $request_data->treatments;

        $ip_bill = IPBill::find($id);

        $ip_bill->update([
            'total' => $data->total,
            'advance_paid' => $data->advance,
            'discount' => $data->discount,
            'sub_total' => $data->subTotal,
            'paid' => $data->paying,
            'due' => $data->due,
            'refund' => $data->refund,
            'payment_method' => $data->payType,
            'other_payment' => $data->otherType,
            'card_no' => $data->cardNo,
            'card_type' => $data->cardType,
            'card_expiry' => $data->cardExpiry
        ]);

        $bill_details = [];
        $ptId = explode('/',$data->ptId);
        foreach ($treatments as $treatment) {
            $bill_details[] = [
                'bill_id' => $id,
                'ip_id' => $data->tIP,
                'pt_id' => (int)$ptId[0],
                'department' => $treatment->dept,
                'category' => $treatment->category,
                'fees_id' => $treatment->feesId,
                'fees_type' => $treatment->service,
                'cost' => $treatment->cost,
                'discount' => $treatment->discount,
                'qty' => $treatment->qty,
                'total' => $treatment->total
            ];
        }

        IPBillDetail::where('bill_id', '=', $id)->delete();
        IPBillDetail::insert($bill_details);

        return \response('Bill Details Updated!!!')->header('Content-Type', 'text/plain');
    }

    public function destroy(int $id)
    {
        IPBill::where('id', '=', $id)->delete();

        return \response('Bill Details Deleted')->header('Content-Type', 'text/plain');
    }
}
