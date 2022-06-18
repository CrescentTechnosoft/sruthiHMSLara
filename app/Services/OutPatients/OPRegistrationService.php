<?php

namespace App\Services\OutPatients;

class OPRegistrationService
{
    /**
     * Returns Year using month.
     */
    public function generateYear(): string
    {
        return idate('m') < 4 ?
        (date('Y', strtotime('-1 Year')).'-'.date('Y')) :
        (date('Y').'-'.date('Y', strtotime('+1 Year')));
    }
}
