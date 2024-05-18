<?php

namespace App\Traits;

use Carbon\Carbon;
use DateTime;

trait DateFormatter {
    public function calcDuration($start_date, $end_date) {
        $start_date = Carbon::parse($start_date);
        $end_date = Carbon::parse($end_date);
        $duration = $end_date->floatDiffInYears($start_date);
        return $duration; 
    }

    public function calcDurationForReservatio($start_date, $end_date) {
        $start_date = Carbon::parse($start_date);
        $end_date = Carbon::parse($end_date);
        $start_hour = Carbon::parse($start_date->format('H:m:s'));
        $end_hour = Carbon::parse($end_date->format('H:m:s'));
        $duration = $end_hour->diffInHours($start_hour);
        return [
            'start_date' => $start_date->format('Y-m-d'),
            'end_date' => $end_date->format('Y-m-d'),
            'duration' => $duration
        ];
    }
}