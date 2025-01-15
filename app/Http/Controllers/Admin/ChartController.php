<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Appointment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ChartController extends Controller
{

    public function appointments(){
        $monthCounts = Appointment::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(1) as count'))
            ->groupBy('month')
            ->get()
            ->toArray();
            $counts = array_fill(0, 12, 0);
            foreach($monthCounts as $monthCount){
            $index = $monthCount['month']-1;
            $counts[$index] = $monthCount['count'];
        }

        return view('charts.appointments', compact('counts'));
    }

    public function nets(){
        $now = Carbon::now();
        $end_time = $now->format('Y-m-d');
        $start_time = $now->subYear()->format('Y-m-d');

        return view('charts.nets', compact('end_time', 'start_time'));
    }

    public function netsJson(Request $request){

        $start_time = $request->input('start_time');
        $end_time = $request->input('end_time');


        $nets = User::nets()
        ->select('name')
        ->withCount(['attendedScheduledates' => function($query) use ($start_time, $end_time){
            $query->whereBetween('schedule_date', [$start_time, $end_time]);
        }, 
        'cancellScheduledates'
        => function($query) use ($start_time, $end_time){
            $query->whereBetween('schedule_date', [$start_time, $end_time]);
        }
        ])
        ->orderBy('attended_scheduledates_count', 'desc')
        ->take(5)
        ->get();

        $data = [];
        $data['categories'] = $nets->pluck('name');

        $series = [];
        $series1['name']= 'Attended Schedules';
        $series1['data'] = $nets->pluck('attended_scheduledates_count');
        $series2['name'] = 'Cancell Schedules';
        $series2['data'] = $nets->pluck('cancell_shedules_count');


        $series[] = $series1;
        $series[] = $series2;
        $data['series']= $series;
        return $data;
}


}