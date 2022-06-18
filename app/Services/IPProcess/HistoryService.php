<?php
namespace App\Services\IPProcess;



class HistoryService
{

    public function getStart(): array
    {
        
    }

    /**
     *
     * @param string $year
     * @return \Illuminate\Support\Collection
     */
    public function getIPNos(string $year): \Illuminate\Support\Collection
    {
        return IPAdmission::select('ip_no')->where('year', $year)->pluck('ip_no');
    }

    public function getTreatmentDetails(string $year, int $ipNo): array
    {
        
    }
}
