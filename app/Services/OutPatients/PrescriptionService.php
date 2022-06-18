<?php

namespace App\Services\OutPatients;

use App\Models\Complaint;
use App\Models\Medicine;
use App\Models\Test;
use App\Models\Treatment;

class PrescriptionService
{
    public function getMedicines(): \Illuminate\Support\Collection
    {
        return Medicine::select(['MedicineName'])->pluck('MedicineName')->unique()->sort()->values();
    }

    public function getTests(): \Illuminate\Support\Collection
    {
        return Test::select(['name'])->pluck('name')->unique()->sort()->values();
    }

    public function getTreatments(): \Illuminate\Support\Collection
    {
        return Treatment::select(['name'])->pluck('name')->unique()->sort()->values();
    }

    public function getComplaints(): \Illuminate\Support\Collection
    {
        return Complaint::select(['name'])->pluck('name')->unique()->sort()->values();
    }
}
