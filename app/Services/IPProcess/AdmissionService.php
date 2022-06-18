<?php

namespace App\Services\IPProcess;

use App\Http\Resources\IPProcess\AdmissionDetailResource;
use App\Models\Advance;
use App\Models\Doctor;
use App\Models\InsuranceCategory;
use App\Models\IPAdmission;
use App\Models\IPTreatment;
use App\Models\IPTreatmentDetails;
use App\Models\Registration;
use App\Models\Specialization;
use App\Models\Ward;
use App\Models\IPLabResult;
use App\Models\IPDischarge;

class AdmissionService
{
    public function getAll()
    {
        return [
            'id' => $this->getPID(),
            'cons' => Doctor::where('status', '=', 'Active')->orderBy('name')->get(['id', 'name']),
            'specs' => Specialization::select('name')->pluck('name'),
            'rooms' => $this->getWards(),
            'insCat' => InsuranceCategory::pluck('name'),
        ];
    }

    //    public function searchPatients(string $value): array {
    //        $builder = $this->db->table('tblRegistration');
    //        $builder->select('PID,PName,Mobile')
    //                ->distinct()
    //                ->like('PID', $value, 'after')
    //                ->orLike('PName', $value, 'after')
    //                ->orLike('Mobile', $value, 'after')
    //                ->orderBy('PID', 'desc');
    //        return array_map('array_values', $builder->get()->getResultArray());
    //    }

    public function searchPatients(string $search)
    {
        return Registration::where('name', 'like', $search . '%')
            ->orWhere('contact_no', 'like', $search . '%')
            ->when(intval($search) > 0, function ($query) use ($search) {
                $query->orWhere('id', '=', $search);
            })
            ->get(['id', 'name', 'contact_no as contact']);
    }

    public function getPID(): object
    {
        return Registration::select('id')->orderBy('id', 'desc')
            ->whereNotIn('id', Ward::select('pt_id')->whereNotNull('pt_id'))
            ->limit(250)
            ->pluck('id');
    }

    public function getWards(): \Illuminate\Database\Eloquent\Collection
    {
        return Ward::where('status', '=', 0)
            ->get(['id', 'floor', 'ward', 'room', 'bed', 'rent']);
    }

    public function getPatientDetails(int $id): array
    {
        $row = Registration::find($id);

        return [
            'name' => $row->salutation . '.' . $row->name,
            'age' => $row->age,
            'gender' => $row->gender,
            'contact' => $row->contact_no,
            'address' => $row->address,
        ];
    }

    public function generateYear(): string
    {
        $lastYear = idate('Y') - 1;
        $currentYear = date('Y');
        $nextYear = idate('Y') + 1;

        return idate('m') < 4 ? ($lastYear . '-' . $currentYear) : ($currentYear . '-' . $nextYear);
    }

    public function generateIPNo(string $year): int
    {
        return (IPAdmission::where('year', $year)->max('ip_no') ?? 0) + 1;
    }

    public function checkRoomStatus(int $id): bool
    {
        return Ward::where([
            'id' => $id,
            'status' => 1,
        ])->count() > 0;
    }

    public function saveIPAdmission(object $data, string $year, int $ipNo): int
    {
        $user_id = session('user_id');

        $admission = IPAdmission::create([
            'year' => $year,
            'ip_no' => $ipNo,
            'pt_id' => \preg_replace('/\D/', '', $data->ddlID),
            'name' => $data->name,
            'age' => $data->age,
            'gender' => $data->gender,
            'address' => $data->address,
            'contact_no' => $data->contact,
            'type' => $data->admType,
            'diagnosis' => $data->diagnosis,
            'department' => $data->department,
            'consultant' => $data->cons,
            'referrer' => $data->ref,
            'fees' => floatval($data->fees),
            'rel_name' => $data->rName,
            'rel_contact_no' => $data->rContact,
            'rel_type' => $data->rType,
            'rel_address' => $data->rAddress,
            'int_cat' => $data->insCat,
            'ins_id' => $data->insID,
            'ins_name' => $data->insName,
            'user_id' => $user_id,
        ]);

        Ward::find($data->room)->update([
            'ip_id' => $admission->id,
            'pt_id' => $data->ddlID,
            'name' => $data->name,
            'status' => 1,
        ]);

        IPTreatment::create([
            'ip_id' => $admission->id,
            'pt_id' => $data->ddlID,
            'ref_no' => 0,
            'user_id' => $user_id,
        ]);

        $treatmentID = IPTreatment::where([
            'ip_id' => $admission->id,
        ])->first()->id;

        IPTreatmentDetails::insert([
            'treatment_id' => $treatmentID,
            'ip_id' => $admission->id,
            'pt_id' => $data->ddlID,
            'fees_id' => 0,
            'department' => 'IPAdmission Fees',
            'category' => 'Admission Fees',
            'fees_type' => 'Admission Fees',
            'test_type' => '',
            'qty' => 1,
            'cost' => floatval($data->fees),
            'total' => floatval($data->fees),
            's_no' => 1,
        ]);

        return $admission->id;
    }

    public function getAdmissionYear(): \Illuminate\Support\Collection
    {
        return IPAdmission::select('year')->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');
    }

    public function getIPNo(string $year): \Illuminate\Support\Collection
    {
        return IPAdmission::select(['id', 'ip_no as ipNo'])->where('year', $year)
            ->orderBy('id', 'desc')
            ->get();
    }

    public function getIPDetails(int $id): AdmissionDetailResource
    {
        $ip = IPAdmission::findOrFail($id);

        return AdmissionDetailResource::make($ip);
    }

    public function updateIPAdmission(object $data, $id): void
    {
        IPAdmission::find($id)->update([
            'type' => $data->admType,
            'diagnosis' => $data->diagnosis,
            'department' => $data->department,
            'consultant' => $data->cons,
            'referrer' => $data->ref,
            'fees' => floatval($data->fees),
            'rel_name' => $data->rName,
            'rel_contact_no' => $data->rContact,
            'rel_type' => $data->rType,
            'rel_address' => $data->rAddress,
            'ins_cat' => $data->insCat,
            'ins_id' => $data->insID,
            'ins_name' => $data->insName,
        ]);

        $treatmentID = IPTreatment::select(['id'])->where([
            'ip_id' => $data->ipNo,
            'ref_no' => 0,
        ])->first()->id;

        IPTreatmentDetails::where('treatment_id', $treatmentID)
            ->update([
                'cost' => floatval($data->fees),
                'total' => floatval($data->fees),
            ]);
    }

    public function deleteIPAdmission(int $id): void
    {
        IPAdmission::where([
            'id' => $id,
        ])->delete();

        IPLabResult::where('ip_id', $id)->delete();
        IPDischarge::where('ip_id', $id)->delete();

        IPTreatment::where('ip_id', $id)->delete();
        Advance::where('ip_id', $id)->delete();

        Ward::where('ip_id', $id)->update([
            'ip_id' => 0,
            'pt_id' => 0,
            'name' => '',
            'status' => 0,
        ]);
    }

    public function addInsCategory(string $cat): string
    {
        $this->db->table('tblInsuranceCategory')
            ->set([
                'InsCat' => $cat,
                'HosID' => $this->hosID,
            ])
            ->insert();

        return 'Category Added';
    }

    public function removeInsCategory(string $cat): string
    {
        $this->db->table('tblInsuranceCategory')
            ->where([
                'InsCat' => $cat,
                'HosID' => $this->hosID,
            ])
            ->delete();

        return 'Category Deleted';
    }
}
