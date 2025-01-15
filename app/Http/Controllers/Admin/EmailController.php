<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreDoorRequest;
use App\Http\Controllers\Controller;
use App\Models\ComposeEmailModel; 
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use App\Models\User;

use Illuminate\Validation\Rule;

use Illuminate\Validation\Rules\Can;


class EmailController extends Controller
{
    public function Index(){
        return view ('admin.email.compose');
    }

    public function email_compose(){
       // $data['getEmail'] = User::where('role', '=', array['admin', 'editor', 'cluster', 'distributor', 'gamer', 'free', 'agent'])->get();
      // $data['getEmail'] = User::whereIn('role', ['admin', 'editor', 'cluster', 'distributor', 'gamer', 'free', 'agent'])->get();
      // return view ('admin.email.compose', $data);
      return view ('admin.email.compose');
     
    }

        public function email_compose_post(Request $request){
         return view ('admin.email.compose_post');
         $save = new ComposeEmailModel;
         $save->user_id = $request->user_id;
         $save->cc_email = trim($request->cc_email);
         $save->subject = trim($request->subject);
         $save->descriptions = trim($request->descriptions);
         $save->save();
         return redirect('admin/email/compose')->with('success', 'Email Successfully send!!');
    }
}