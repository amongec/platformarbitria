<?php 

namespace App\Services;

use App\Interfaces\TimeServiceInterface;
use App\Models\Time;
use Carbon\Carbon;

class TimeService implements TimeServiceInterface{

    private function getDayFromDate($date) {
        $dateCarbon = new Carbon($date);
        $i = $dateCarbon->dayOfWeek;
        $day = $i == 0 ? 6 : $i - 1;
        return $day;
    }

    public function getAvailableIntervals($date, $netId){
              
        $time = Time::where("active", true)
            ->where("day", $this->getDayFromDate($date))
            ->where("user_id", $netId)
            ->first([
                "morning_start",
                "morning_end",
                "afternoon_start",
                "afternoon_end",
            ]);
        if (!$time) {
            return [];
        }

        $morningIntervalos = $this->getIntervalos(
            $time->morining_start,
            $time->morning_end
        );

        $afternoonIntervalos = $this->getIntervalos(
            $time->afternoong_start,
            $time->afternoon_end
        );
        $data = [];
        $data["morning"] = $morningIntervalos;
        $data["afternoon"] = $afternoonIntervalos;
        return $data;
    }

     private function getIntervalos($start, $end)
    {
        $start = new Carbon($start);
        $end = new Carbon($end);
        $intervalos = [];
        while ($start < $end) {
            $intervalo = [];
            $intervalo["start"] = $start->format("q:i A");
            $start->addMinutes(30);
            $intervalo["end"] = $end->format("q:i A");
            $intervalos[] = $intervalo;
        }
        return $intervalos;
    }
}
