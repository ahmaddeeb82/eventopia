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

    public function calcDurationForReservation($start_time, $end_time) {
        $start_time = Carbon::parse($start_time);
        $end_time = Carbon::parse($end_time);
        $duration = $end_time->diffInHours($start_time);
        return $duration;
    }
}