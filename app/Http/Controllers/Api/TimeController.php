<?php

namespace App\Http\Controllers\Api;

use App\Interfaces\TimeServiceInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
//use Illuminate\Contracts\Validation\Validator;
use Illuminate\Contracts\Validation\Rule;
use Carbon\Carbon;
use App\Http\Requests\StoreTimeRequest;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Time;


class TimeController extends Controller
{
    public function hours(StoreTimeRequest $request, TimeServiceInterface $timeServiceInterface)
    {
      $rules = [
        'date' => 'required|date_format:"Y-m-d"',
        'net_id' => 'required|exists:users,id'
      ];
      //  $this->validate($request, $rules);

        $date = $request->input("date");
        $netId = $request->input('net_id');

      return $timeServiceInterface->getAvailableIntervals($date, $netId);
   }
   
}
