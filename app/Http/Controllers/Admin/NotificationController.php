<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NotificationModel;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;

class NotificationController extends Controller
{
   public function notification_index(Request $request){
    $users = User::all();
    $data['getRecord'] = User::get();
        return view('admin.notification.update', $data);
   }

   public function notification_send(Request $request){

      $saveDb = new NotificationModel;
      $saveDb->user_id = trim($request->user_id);
      $saveDb->title = trim($request->user_id);
      $saveDb->message = trim($request->user_id);
      $saveDb->save();

      $users = User::all();
      $user = User::get()->first();
      if(!empty($user->token)){
         try{
            $serverKey = 'Please set your Firebase server key';
            $token = $user->token;
            $body['title'] = $request->title;
            $body['message'] = $request->message;
            $body['body'] = $request->body;
            $url = "https://fcm.googleapis.com/fcm/send";

            $notification = array('title' => $request->title, 'body' => $request->message);

            $arrayToSend = array('to' => $token, 'data'=> $body, '
            priority' => 'high');
            $json1 = json_encode($arrayToSend);
            $headers = array();
            $headers[] = 'Content-Type: application/json';
            $headers[] = 'Authorization: key=' . $serverKey;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $reaponse = curl_exec($ch);
            curl_close($ch);

         } catch (Exception $e){
               echo $e;
         }
      }

      return redirect('admin/notification')->with('success', 'Notification send successfully.');
   }
}
