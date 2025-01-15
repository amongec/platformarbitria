<?php

use App\Http\Controllers\Admin\AgentController;
use App\Http\Controllers\Admin\ClustersController;
use App\Http\Controllers\Admin\ChartController;

use App\Http\Controllers\Admin\EmailController;
use App\Http\Controllers\Admin\NetsController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\QRCodeController;
use App\Http\Controllers\Admin\PostsController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\TeapotsController;
use App\Http\Controllers\Admin\TimeController;
use App\Http\Controllers\Admin\TypeController;
use App\Http\Controllers\Admin\UserTimeController;

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::resource('post', PostsController::class)->except('show')->names('admin.post');
    
    Route::resource('teapot', TeapotsController::class)->except('show')->names('admin.teapot');

    Route::resource('cluster', ClustersController::class)->except('show')->names('admin.cluster');

    Route::resource('products', ProductsController::class)->except('show')->names('admin.products');


    //Route::resource('form-door', DoorsController::class)->names('admin.forms-door');

    //Route::resource('pages.index', EmployeeController::class)->names('pages.index');

    //Route::middleware(['auth', 'role:agent'])->group(function(){
    Route::get('agent_dashboard', [AgentController::class. 'AgentDashboard'])
        ->name('admin.agents.agent_dashboard');
     
    Route::resource('agents', AgentController::class)->except('show')->names('admin.agents');
    Route::resource('nets', NetsController::class)->except('show')->names('admin.nets');

     Route::get('/types', [TypeController::class, 'index']);

     Route::get('/types/create', [TypeController::class, 'create']);
     Route::get('/types/{type}/edit', [TypeController::class, 'edit']);
     Route::post('/types', [TypeController::class, 'sendData']);
     Route::put('/types/{type}', [TypeController::class, 'update']);
     Route::delete('/types/{type}', [TypeController::class, 'destroy']);

    //Route::get('types/{type}/nets', [TypeController::class, 'nets']);


    //Route::get('types/{type}/nets', [TypeController::class, 'nets']);

    //Route::get('reportes/appointments/line', ChartController::class, 'appointments');

   // Route::get('reportes/appointments/line', [ChartController::class, 'appointments']);
    
    //Route::get('reportes/citas/line', [ChartController::class, 'appointments']);
    //Route::get('admin/charts/dates/line', [ChartController::class, 'scheduledates']);
    Route::get('reportes/nets', [ChartController::class, 'nets']);
    Route::get('reportes/generic', [ChartController::class, 'generic']);

    Route::get('admin/charts/nets/column/data', [ChartController::class, 'netsJson']);

    Route::get('admin/email/compose', [EmailController::class, 'email_compose']);
    Route::post('admin/email/compose_post', [EmailController::class, 'email_compose_post']);
    
    Route::get('admin/notification', [NotificationController::class, 'notification_index']);
    Route::post('admin/notification_send', [NotificationController::class, 'notification_send']);

    Route::get('admin/qrcode/list', [QRCodeController::class, 'list']);
    Route::get('admin/qrcode/add', [QRCodeController::class, 'add_qrcode']);

    Route::post('admin/qrcode/add', [QRCodeController::class, 'store_qrcode']);

    Route::get('admin/qrcode/edit/{id}', [QRCodeController::class, 'qrcode_edit']);
    Route::post('admin/qrcode/edit/{id}', [QRCodeController::class, 'qrcode_update']);

    Route::get('admin/qrcode/delete/{id}', [QRCodeController::class, 'qrcode_delete']);

   // Route::get('time', [TimeController::class, 'edit']);
   // Route::post('time', [TimeController::class, 'store']);


//User week start
Route::get('week', [UserTimeController::class, 'week_list']);
    
Route::get('week/add', [UserTimeController::class, 'week_add']);
Route::post('week/add', [UserTimeController::class, 'week_store']);

Route::get('week/edit/({id}', [UserTimeController::class, 'week_edit'])->name('admin.week.edit');
Route::post('week/edit/{id}', [UserTimeController::class, 'week_update'])->name('admin.week.delete');

Route::get('week/delete/{id}', [UserTimeController::class, 'week_delete']);
//User week end

    //User week_time start
Route::get('week_time', [UserTimeController::class, 'week_time_list']);

Route::get('week_time/add', [UserTimeController::class, 'week_time_add']);
Route::post('week_time/add', [UserTimeController::class, 'week_time_add_store']);

Route::get('week_time/edit/{id}', [UserTimeController::class, 'week_time_edit']);
Route::post('week_time/edit/{id}', [UserTimeController::class, 'week_time_edit_update']);

Route::get('week_time/delete/{id}', [UserTimeController::class, 'week_time_delete']);
//User week_time end

//nets timer
Route::get('schedule/list', [UserTimeController::class, 'list']);
Route::get('schedule', [UserTimeController::class,'admin_schedule' ]);
Route::post('schedule', [UserTimeController::class,'admin_schedule_update' ]);
});
