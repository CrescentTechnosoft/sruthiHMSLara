<?php

namespace App\Http\Controllers;

use App\Models\CardType;
use App\Models\Complaint;
use App\Models\Department;
use App\Models\Fee;
use App\Models\PaymentType;
use App\Models\Specialization;
use App\Models\Treatment;
use App\Models\TestCategory;
use Illuminate\Http\Request;
use App\Models\InsuranceCategory;

class ExtrasController extends Controller
{
    public function addTestCategory(Request $request): \Illuminate\Http\Response
    {
        TestCategory::insert([
            'category' => $request->category,
        ]);

        return response('Test Category Added')->header('Content-Type', 'text/plain');
    }

    public function removeTestCategory(string $test_category): \Illuminate\Http\Response
    {
        TestCategory::where('category', rawurldecode($test_category))
                ->delete();

        return response('Test Category')->header('Content-Type', 'text/plain');
    }

    public function addSpecialization(Request $request): \Illuminate\Http\Response
    {
        Specialization::insert([
            'name' => $request->specialization,
        ]);

        return response('Specialization Added')->header('Content-Type', 'text/plain');
    }

    public function removeSpecialization(string $specialization): \Illuminate\Http\Response
    {
        Specialization::where('name', rawurldecode($specialization))
                ->delete();

        return response('Specialization Removed')->header('Content-Type', 'text/plain');
    }

    public function addDepartment(Request $request): \Illuminate\Http\Response
    {
        Department::insert([
            'name' => $request->department,
        ]);

        return response('Department Added')->header('Content-Type', 'text/plain');
    }

    public function removeDepartment(string $department): \Illuminate\Http\Response
    {
        Department::where('name', rawurldecode($department))
                ->delete();
        Fee::where('department', rawurldecode($department))
                ->delete();

        return response('Department Removed')->header('Content-Type', 'text/plain');
    }

    public function addComplaint(Request $request): \Illuminate\Http\Response
    {
        Complaint::insert([
            'name' => $request->complaint,
        ]);

        return response('Complaint Added')->header('Content-Type', 'text/plain');
    }

    public function removeComplaint(string $complaint): \illuminate\Http\Response
    {
        Complaint::where('name', \rawurldecode($complaint))->delete();

        return \response('Complaint Removed')->header('Content-Type', 'text/plain');
    }

    public function addTreatment(Request $request): \Illuminate\Http\Response
    {
        Treatment::insert([
            'name' => $request->treatment,
        ]);

        return response('Treatment Added')->header('Content-Type', 'text/plain');
    }

    public function removeTreatment(string $treatment): \illuminate\Http\Response
    {
        Treatment::where('name', \rawurldecode($treatment))->delete();

        return \response('Treatment Removed')->header('Content-Type', 'text/plain');
    }

    public function addPayType(Request $request): \illuminate\Http\Response
    {
        PaymentType::insert([
            'name' => $request->input('pay-type'),
        ]);

        return \response('Paying Type Added')->header('Content-Type', 'text/plain');
    }

    public function removePayType(string $pay_type): \illuminate\Http\Response
    {
        PaymentType::where('name', '=', \rawurldecode($pay_type));

        return \response('Pay Type Deleted')->header('Content-Type', 'text/plain');
    }

    public function addCardType(Request $request): \illuminate\Http\Response
    {
        CardType::insert([
            'name' => $request->input('card-type'),
        ]);

        return \response('Card Type Added')->header('Content-Type', 'text/plain');
    }

    public function removeCardType(string $card_type): \illuminate\Http\Response
    {
        CardType::where('name', '=', \rawurldecode($card_type))->delete();

        return \response('Card Type Deleted')->header('Content-Type', 'text/plain');
    }
    
    public function addInsuranceCategory(Request $request): \illuminate\Http\Response
    {
        InsuranceCategory::insert([
            'name' => $request->input('category'),
        ]);

        return \response('Insurance Category Added')->header('Content-Type', 'text/plain');
    }
    
    public function removeInsuranceCategory(string $category): \illuminate\Http\Response
    {
        InsuranceCategory::where('name', '=', \rawurldecode($category))->delete();

        return \response('Insurance Category Deleted')->header('Content-Type', 'text/plain');
    }
}
