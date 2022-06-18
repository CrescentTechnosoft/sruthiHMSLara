<?php

namespace App\Http\Controllers\Reception;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\Request;

class PatientsListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $search = $request->input('search');
        $count = $request->input('count');

        return Registration::select([
            'id',
            'uuid',
            'salutation',
            'name',
            'age',
            'gender',
            'contact_no as contact',
        ])->when($search !== '', function ($query) use ($search) {
            $query->where('id', $search)
                ->orWhere('name', 'like', $search . '%')
                ->orWhere('contact_no', 'like', $search . '%');
        })
            ->orderBy('id', 'desc')
            ->paginate($count);
    }

    public function show(int $id): array
    {
        $patient = Registration::find($id);
        return [
            'id' => $id,
            'name' => $patient->salutation . '.' . $patient->name,
            'age' => $patient->age,
            'gender' => $patient->gender,
            'dob' => $patient->dob,
            'contact' => $patient->contact_no,
            'email' => $patient->email_address,
            'address' => $patient->address
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): \Illuminate\Http\Response
    {
        Registration::where('id', $id)->delete();

        return \response('Patient Details Deleted')->header('Content-Type', 'text/plain');
    }
}
