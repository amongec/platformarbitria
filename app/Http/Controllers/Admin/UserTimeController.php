<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserTimeModel;
use App\Models\WeekModel;
use App\Models\WeekTimeModel;
use Auth;
use Illuminate\Http\Request;

class UserTimeController extends Controller
{
    public function week_list(Request $request){
        $data['getRecord'] = WeekModel::get();
        return view('admin.week.list', $data);
    }

    public function week_add(Request $request){
        return view('admin.week.add');
    }

    public function week_store(Request $request){
        $save = new WeekModel;
        $save->name = trim($request->name);
        $save->save();
        return redirect('week')->with('success', 'Week has been created successfully.');
    }

    public function week_edit($id){
        $data['getRecord'] = WeekModel::find($id);
        return view('admin.week.edit', $data);
    }

    public function week_update(Request $request, $id){
        $save = WeekModel::find($id);
        $save->name = trim($request->name);
        $save->save();
        return redirect('week')->with('success', 'Week has been updated successfully.');
    }

    public function week_delete(Request $request, $id){
        $save = WeekModel::find($id);
        $save->delete();
        return redirect('week')->with('success', 'Week has been deleted successfully.');
    }

    public function week_time_list(Request $request){
        $data['getRecord'] = WeekTimeModel::get();
        return view('admin.week_time.list', $data);
    }

    public function week_time_add(Request $request){
        return view('admin.week_time.add');
    }

    public function week_time_add_store(Request $request){
        $save = new WeekTimeModel;
        $save->name = trim($request->name);
        $save->save();
        return redirect('week_time')->with('success', 'Week Time has been created successfully.');
    }

    public function week_time_edit($id){
        $data['getRecord'] = WeekTimeModel::find($id);
        return view('admin.week_time.edit', $data);
    }
    public function week_time_edit_update(Request $request, $id){
        $save = WeekTimeModel::find($id);
        $save->name = trim($request->name);
        $save->save();
        return redirect('week_time')->with('success', 'Week Time has been updated successfully.');
    }

    public function week_time_delete(Request $request, $id){
        $save = WeekTimeModel::find($id);
        $save->delete();
        return redirect('week_time')->with('success', 'Week Time has been deleted successfully.');
    }

    public function admin_schedule(Request $request){
        $data['week'] = WeekModel::get();
        $data['week_time_row'] = WeekTimeModel::get();
        $data['$getrecord'] = UserTimeModel::get();
        return view('admin.schedule.list', $data);
    }

    public function admin_schedule_update(Request $request){
       
       UserTimeModel::where('user_id', '=', Auth::user()->id)->delete();
        if(!empty($request->week )){
            foreach($request->week as $value){
                if(!empty($value['status'])){
                    $record = new UserTimeModel;
                    $record->week_id = trim($value['week_id']);
                    $record->user_id = Auth::user()->id;
                    $record->status = '1';
                    $record->start_time = trim($value['start_time']);
                    $record->end_time = trim($value['end_time']);
                    $record->save();
                }
            }
        }
        return redirect('schedule')->with('success', 'Schedule has been updated successfully.');
    }
}