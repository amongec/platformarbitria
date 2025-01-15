<?php

namespace App\Http\Controllers;

use Auth;
use Authy\AuthyApi;
use App\Http\Requests\AppointmentRequest;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Type;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Twilio\Rest\Client;

class AppointmentController extends Controller
{
    protected $appointment;
    protected $authyApi;
    protected $client;

    public function __construct()
    {
        //$this->middleware("can:appointments_create_update_delete")->only(
        //    "create",
        //    "store",
        //    "cancel"
        //);
       // $this->middleware("can:appointments_read")->only("index");
        
       // $this->authyApi = new AuthyApi(env('AUTHY_API_KEY'));
        // $this->client = new Client(env('TWILIO_SID'), env('TWILIO_TOKEN'));
    }

    public function index()
    {
        $types = Type::all();
        $users = User::all();
        $appointments = Appointment::all();
        $perPage = 15;

        if (!empty($keyword)) {
            $appointments = Role::where(
                "zipcode_select_service",
                "LIKE",
                '%$keyword%'
            )
                ->where("mobile_select_service", "LIKE", '%$keyword%')
                ->where("city_select_service", "LIKE", '%$keyword%')
                ->links("vendor.pagination.tailwind")
                ->latest()
                ->paginate($perPage);
        } else {
            $appointments = Appointment::latest()->paginate($perPage);
        }

        return view(
            "appointments.index",
            compact("appointments", "users", "types")
        );
    }

    public function create()
    {
        $types = Type::all();
        $users = User::all();
        $appointments = Appointment::all();
        return view(
            "appointments.create",
            compact("appointments", "types", "users")
        );
    }

    public function store(AppointmentRequest $request)
    {
        Appointment::create($request->validated());

        return redirect("mydates")->with(
            "success",
            "Appointment has been updated successfully"
        );
    }

    public function show(Appointment $appointment)
    {
        // $role = auth()->user()->role;
        return view("appointments.show", compact("appointment"));
    }

    public function edit(Appointment $appointment)
    {
        // return view('appointments.edit', compact('appointment'));
    }

    public function update(
        AppointmentRequest $request,
        Appointment $appointment
    ) {
        $appointment = Appointment::create($request->all());

        return redirect("appointments.index")->with(
            "success",
            "Appointment has been updated successfully"
        );
    }

    // public function cancel(
    //    AppointmentRequest $request,
    //    Appointment $appointment
    //) {
    //    if ($request->has("justification")) {
    //   // $cancellation = new CancelledAppointment();
    //    //  $cancellation->justification = $request->input('justification');
    //    //  $cancellation->canceled_by_id = auth();

    //   //   $appointment->cancellation()->save($cancellation);
    //}
    //$appointment->status = "Cancel";
    // $appointment->save();
    // $notification = "Appointment has been canceled successfully";

    //  return redirect("mydates")->with(compact("notification"));
    //}

    //public function confirm(Appointment $appointment)
    //{
    //   $appointment->status = "Confirmed";
    //  $appointment->save();
    //  $notification = "Appointment has been confirmed successfully";
    //  return redirect("mydates")->with(compact("notification"));
    //}

    // public function destroy(Appointment $cita)
    // {
    // $cita->delete();
    //return redirect("appointments")->with(
    //  "success",
    //      "Schedule Date has been deleted successfully"
    // );
    //}

    //public function formCancel(Appointment $appointment)
    //{
    //   if ($appointment->status == "Confirmed" || "Reserved") {
    //     // $role = auth()->user()->role;
    //  return view("appointments.cancel", compact("appointment", "role"));
    // }
    // return redirect("mydates");
    //}

    //   public function destroy(Request $request): RedirectResponse
    //   {
    //      $request->validateWithBag('appointmentDeletion', [
    //       ]);

    //      $appointment->delete();

    //        return Redirect::to('/appointment');
    //    }

    public function requestSms()
    {
        $user = Auth::user();
        if ($user->verified) {
            return redirect("/appointment/sms");
        }

        $authyUser = $this->authyApi->registerUser(
            $user->email,
            $user->phone_number,
            $user->country_code
        );
        if ($authyUser->ok()) {
            $user->authy_id = $authyUser->id();
            $user->save();

            $this->authyApi->requestSms($user->authy_id);
            return redirect("appointment/sms")->with(
                "notification",
                "We have sent you an SMS with a verification code."
            );
        } else {
            $errors = $this->getAuthyErrors($authyUser->errors());
            return redirect("/profile/phone")->withErrors(
                new MessageBag($errors)
            );
        }
    }

    public function getConfirmAppointment()
    {
        $user = Auth::user();
        if ($user->verified) {
            return redirect("/appointment/sms");
        }
        return view("dashboard");
    }

    public function postConfirmAppointment(Request $request)
    {
        $token = $request->input("token");
        $user = Auth::user();
        $verification = $this->authyApi->verifyToken($user->authy_id, $token);

        if ($verification->ok()) {
            $user->verify = true;
            $user->save();
            $this->sendSmsNotification($this->client, $user);

            return redirect("/appointment/sms")->with(
                "notification",
                "The scheduled appointment has been successfully verified"
            );
        }
    }

    public function CanceledSms()
    {
        $user = Auth::user();
        if ($user->verified) {
            return redirect("/appointment/sms");
        }

        $authyUser = $this->authyApi->registerUser(
            $user->email,
            $user->phone_number,
            $user->country_code
        );
        if ($authyUser->ok()) {
            $user->authy_id = $authyUser->id();
            $user->delete();

            $this->authyApi->canceledSms($user->authy_id);
            return redirect("appointment")->with(
                "notification",
                "The appointment has been canceled successfully."
            );
        }
    }

    public function getCancelAppointment()
    {
        $user = Auth::user();
        if ($user->verified) {
            return redirect("/appointment/sms");
        }

        return view("dashboard");
    }

    public function postCancelAppointment(Request $request)
    {
        $token = $request->input("token");
        $user = Auth::user();
        $verification = $this->authyApi->verifyToken($user->authy_id, $token);

        if ($verification->ok()) {
            $user->verify = true;
            $user->save();
            $this->sendSmsNotification($this->client, $user);

            return redirect("/appointment/sms")->with(
                "notification",
                "The scheduled appointment has been successfully canceled"
            );
        }
    }
}