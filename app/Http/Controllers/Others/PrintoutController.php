<?php

namespace App\Http\Controllers\Others;

use App\Models\IPBill;
use App\Models\OPBill;
use App\Models\Advance;
use App\Models\IPAdmission;
use App\Models\IPDischarge;
use App\Models\Prescription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Services\Printouts\OPLabResultPrintService;
use App\Services\Printouts\IPLabResultPrintService;
use Illuminate\Http\Response;

class PrintoutController extends Controller
{

    public function generateRegistrationSheet(int $id): Response
    {
        $regDetails = Registration::findOrFail($id);

        $view = view('printouts.registration', compact('regDetails'));

        return response(base64_encode($view))->header('Content-Type', 'text/plain');
    }

    public function generateOPBillReceipt(int $id,string $billType): Response
    {
        $data = OPBill::findOrFail($id);
        $data['type'] = $billType;
        return response(view('printouts.op_bill', compact('data')))->header('Content-Type', 'application/pdf');
    }

    public function generateIPBillReceipt(int $id,string $billType): Response
    {
        $data = IPBill::findOrFail($id);
        $data['type'] = $billType;

        return response(view('printouts.ip_bill', compact('data')))->header('Content-Type', 'application/pdf');
    }

    public function generatePrescription(int $id): Response
    {
        $data = Prescription::where('op_id', $id)->first();

        return \response(\view('printouts.prescription', compact('data')))->header('Content-Type', 'application/pdf');
    }

    public function generateOpLabResult(Request $request): Response
    {
        $request_values = \json_decode($request->getContent());

        $data = (new OPLabResultPrintService())->getResultDatas(
            $request_values->id,
            $request_values->isSelected,
            $request_values->selectedTests
        );
        $data['HeaderType'] = $request_values->header;
        $view = '';

        $view = base64_encode(view('printouts.lab_report', $data));

        return response($view)->header('Content-Type', 'text/plain');
    }

    public function generateIpLabResult(Request $request): Response
    {
        $request_values = \json_decode($request->getContent());

        $data = (new IPLabResultPrintService())->getResultDatas(
            $request_values->id,
            $request_values->isSelected,
            $request_values->selectedTests
        );
        $data['HeaderType'] = $request_values->header;

        $view = base64_encode(view('printouts.ip_lab_report', $data));

        return response($view)->header('Content-Type', 'text/plain');
    }

    public function generateIPCaseSheet(int $id): Response
    {
        $data = IPAdmission::findOrFail($id);

        $view = view('printouts.ip_case_sheet', compact('data'));

        return \response($view)->header('Content-Type', 'application/pdf');
    }

    public function generateDischargeSummary(int $id): Response
    {
        $data = IPDischarge::where('ip_id', $id)->first();

        $view = view('printouts.ip_discharge', compact('data'));

        return \response($view)->header('Content-Type', 'application/pdf');
    }

    public function generateAdvanceReceipt(int $id): Response
    {
        $data = Advance::find($id);

        $view = view('printouts.ip_advance', compact('data'));

        return \response($view)->header('Content-Type', 'application/pdf');
    }
}
