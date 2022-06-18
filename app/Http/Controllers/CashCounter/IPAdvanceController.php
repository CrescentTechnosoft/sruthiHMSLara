<?php

namespace App\Http\Controllers\CashCounter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IPAdmission;
use App\Models\PaymentType;
use App\Models\CardType;
use App\Models\Advance;
use App\Models\IPDischarge;
use App\Models\IPTreatmentDetails;
use App\Http\Resources\CashCounter\IpAdvances\PatientResource;
use App\Http\Resources\CashCounter\IpAdvances\AdvanceResourceCollection;

class IPAdvanceController extends Controller
{
    public function index(): array
    {
        $years = IPAdmission::select('year')->distinct()
                ->pluck('year')
                ->sortDesc()
                ->values();

        $ip_nos = $years->isEmpty() ? [] : $this->getIPNos($years->first());
        $pay_types = PaymentType::pluck('name')->unique()->sort()->values();
        $card_types = CardType::pluck('name')->unique()->sort()->values();

        return [
            'years' => $years,
            'ipNos' => $ip_nos,
            'payTypes' => $pay_types,
            'cardTypes' => $card_types
        ];
    }

    public function getIPNos(string $year): \Illuminate\Support\Collection
    {
        return IPAdmission::where('year', '=', $year)
                        ->get(['id', 'ip_no as ipNo'])
                        ->sortByDesc('id')
                        ->values();
    }

    public function getAdvanceDetails(int $ip_id)
    {
        PatientResource::withoutWrapping();
        $data = IPAdmission::find($ip_id);

        $advances = Advance::where('ip_id', '=', $ip_id)->get();

        return [
            'data' => PatientResource::make($data),
            'advances' => AdvanceResourceCollection::make($advances)
        ];
    }

    public function store(Request $request): array
    {
        $data = \json_decode($request->getContent());
        $ip_id = $data->ipNo;

        if (IPDischarge::where('ip_id', $ip_id)->count() > 0) {
            return [
                'status' => false,
                'message' => 'This Patient is already Discharged'
            ];
        }

        $treatment_cost = IPTreatmentDetails::where('ip_id', $ip_id)->sum('total');
        $previous_advance = Advance::where('ip_id', $ip_id)->sum('amount');
        $current_advance = (float) $data->advance;
        $total_advance = $previous_advance + $current_advance;

        if ($treatment_cost < $total_advance) {
            return [
                'status' => false,
                'message' => 'Advance is higher than Treatment Cost'
            ];
        }
        $advance_no = Advance::where('ip_id', $ip_id)->max('advance_no') ?? 0;

        Advance::create([
            'ip_id' => $ip_id,
            'pt_id' => $data->ptId,
            'advance_no' => $advance_no + 1,
            'amount' => $current_advance,
            'pay_type' => $data->payType,
            'other_pay_type' => $data->otherPayType,
            'card_no' => $data->cardNo,
            'card_type' => $data->cardType,
            'card_expiry' => $data->cardExpiry,
            'user_id' => $request->session()->get('user_id')
        ]);

        return [
            'status' => true,
            'message' => 'Advance amount added...',
            'id'=> Advance::max('id')
        ];
    }

    public function update(Request $request, int $id)
    {
        $data = \json_decode($request->getContent());
        $ip_id = $data->ipNo;

        $treatment_cost = IPTreatmentDetails::where('ip_id', $ip_id)->sum('total');

        $other_advances = Advance::where('ip_id', $ip_id)
                ->where('id', '!=', $id)
                ->sum('amount');

        $current_advance = (float) $data->advance;
        $total_advance = $other_advances + $current_advance;

        if ($treatment_cost < $total_advance) {
            return [
                'status' => false,
                'message' => 'Advance is higher than Treatment Cost'
            ];
        }

        Advance::where('id', '=', $id)
                ->update([
                    'amount' => $current_advance,
                    'pay_type' => $data->payType,
                    'other_pay_type' => $data->otherPayType,
                    'card_no' => $data->cardNo,
                    'card_type' => $data->cardType,
                    'card_expiry' => $data->cardExpiry,
        ]);

        return [
            'status' => true,
            'message' => 'Advance Details Updated!!!'
        ];
    }

    public function destroy(int $id): \Illuminate\Http\Response
    {
        Advance::where('id', '=', $id)->delete();

        return response('Advance Details Deleted');
    }
}
