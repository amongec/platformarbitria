<?php

//use App\Http\Controllers\Api\TimeController;
//use App\Http\Controllers\Api\TypeController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CookieConsentController;
use App\Http\Controllers\ClusterController;
use App\Http\Controllers\ClusterLikeController;
use App\Http\Controllers\EnviarSmsController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaypalController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostCommentsController;
//use App\Http\Controllers\PostsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
//use App\Http\Controllers\ScheduledatesController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\TeapotController;

use App\Http\Controllers\UserController;
use App\Http\Controllers\ServiceController;
use App\Livewire\Shoppingcart;
use App\Mail\ContactUsMailable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Model\Role;

//Route::get('/', function (){
//    return view('welcome');
//})
//Route::get('schedule-timing', [JobController::class, 'scheduleTimingIndex'])->name('schedule/timing');
 

//landing and welcome
Route::get("user-details", function () {
    return view("user-details");
})->name("user-details");

Route::get("/", [PostController::class, "index"])->name("posts");

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
   // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Admin
    Route::resource('permissions', PermissionController::class);
    Route::resource('roles', RoleController::class);
   Route::resource('users', UserController::class);

    Route::get("posts/{post}", [PostController::class, "show"
    ])->name("posts.show");

    Route::post("posts/{post:slug}/comments", [
        PostCommentsController::class,"store"]);

        Route::get("contact",[ContactController::class, 'index'])->name("contact");

        //Admin
    //Route::get('admin', [HomeController::class, 'index'])->name('admin.home');
    
   Route::resource('categories', CategoryController::class)->except('show')->names('categories');    
    Route::get("category/{category}", [PostController::class, "category"])->name(
    "posts.category"
    );
  
    Route::get("tag/{tag}", [PostController::class, "tag"])->name("posts.tag");


    //Route::get('admin/types/{type}/nets', [TypeController::class, 'nets']);


    //Route::get('admin/types/{type}/nets', [TypeController::class, 'nets']);
    
    // Route::get('scheduledates', [ScheduledatesController::class, 'index']);
    // Route::get('scheduledates/create', [ScheduledatesController::class, 'create']);
    // Route::post('scheduledates', [ScheduledatesController::class, 'store'])->name('scheduledates.store');
   //  Route::post('mydates', [ScheduledatesController::class, 'index']);

////Route::get('mydates/create', [ScheduledatesController::class, 'create']);
 // Route::post('mydates', [ScheduledatesController::class, 'store']);
//Route::get('mydates', [ScheduledatesController::class, 'index']);

 //Route::get('mydates/{scheduledate}', [ScheduledatesController::class, 'show']);

//Route::post('mydates/{scheduledate}/cancel', [ScheduledatesController::class, 'cancel']);
////Route::post('mydates/{scheduledate}/confirm', [ScheduledatesController::class, 'confirm']);

//Route::get('mydates{scheduledates}/cancel', [ScheduledatesController::class, 'formcancel']);

//Route::get('types/{types}/nets', [TypeController::class, 'nets']);

//Route::get('/hour', [TimeController::class, 'edit']);
//Route::get('/time/hours', [TimeController::class, 'hours']);

Route::get('/sms', [EnviarSmsController::class, 'enviarSms'])->name('enviar-sms.index');

Route::get("appointments", [AppointmentController::class, "index"]);
Route::get("appointments/create", [AppointmentController::class, "create"]);
Route::post("appointments", [AppointmentController::class, "store"])->name(
    "appointments.store"
);

Route::resource("teapots",TeapotController::class)->except('show')->names('admin.teapots');
// Select branding-teapot
  // Route::get("teapots", [TeapotController::class, "index"])->name("teapots.index");

//Route::get("teapots", [TeapotController::class, "index"
//])->name("teapots");

//Route::get('teapots/{teapot}', [TeapotController::class, 'show'])->name("teapots.show");
// Route::get("teapots/{cluster:slug}", [TeapotController::class, "show"]);




   // Select branding-cluster
    Route::get("clusters", [ClusterController::class, "index"])->name(
        "clusters.index"
    );

  //Route::get("clusters", [ClusterController::class, "index"
  //])->name("clean-points");

    Route::get('clusters/{cluster}', [ClusterController::class, 'show'])->name(
        "cluster.show"
    );
   // Route::get("clusters/{cluster:slug}", [ClusterController::class, "show"]);
    

    Route::post("clusters/{cluster}/like", [
        ClusterLikeController::class,
        "like",
    ])->name("clusters.like");
    Route::post("clusters/{cluster}/unlike", [
        ClusterLikeController::class,
        "unlike",
    ])->name("clusters.unlike");

    Route::post("clusters/{cluster}/follow", [
        FollowerController::class,
        "follow",
    ])->name("clusters.follow");
    Route::post("cluster/{cluster}/unfollow", [
        FollowerController::class,
        "unfollow",
    ])->name("clusters.unfollow");


   // Route::get('/hour', [TimeController::class, 'edit']);
   // Route::get('/time/hours', [TimeController::class, 'hours']);  

   
    Route::get("payment-cancel", [PaypalController::class, "cancel"])->name(
        "payment.cancel"
    );

    Route::get("payment-success", [PaypalController::class, "success"])->name(
        "payment.success"
    );

   //Chats
   Route::get("chat", function () {
    return view("chat");
})->name("chat");

Route::get("chat-km0", function () {
    return view("chat-km0");
})->name("chat-km0");

});//end group function auth

require __DIR__.'/auth.php';

//Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


//Mail
Route::post("newsletter", NewsletterController::class);

//Route::get("contact-us", function () {
 //   Mail::to("gruproscat@gmail.com")->send(new ContactUsMailable());
 //   return "Message sent";
//})->name("contact-us");

Route::get("contact", [ContactController::class, "index"
])->name( "contact.index");

Route::post("contact", [ContactController::class, "store"
])->name("contact.store");

//landing and welcome
Route::get("about", function () {
    return view("about");
})->name("about");

//landing and welcome
Route::get("services", function () {
    return view("services");
})->name("services");

Route::get("unsubscribe", function () {
    return view("unsubscribe");
})->name("unsubscribe");

Route::get("questions", function () {
    return view("questions");
})->name("questions");

Route::get("google-maps", function () {
    return view("google-maps");
})->name("google-maps");

Route::get("plans", function () {
    return view("plans");
})->name("plans");

//Shop, shoppind and cart
        Route::prefix('shop')->name('shop.')->group(function(){
        Route::get('/', [ShopController::class, 'index'])->name('index');
        Route::post('/add-to-cart', [ShopController::class, 'addToCart'])->name('addToCart');
        Route::post('/increment', [ShopController::class, 'increment'])->name('increment');
        Route::post('/decrement', [ShopController::class, 'decrement'])->name('decrement');
        Route::post('/remove', [ShopController::class, 'remove'])->name('remove');
    });

    Route::prefix('cart')->name('cart.')->group(function(){
        Route::get('/index', [CartController::class, 'index'])->name('index');
        Route::post('/increment', [CartController::class, 'increment'])->name('increment');
        Route::post('/decrement', [CartController::class, 'decrement'])->name('decrement');
        Route::post('/remove', [CartController::class, 'remove'])->name('remove');
        Route::post('/clear', [CartController::class, 'clear'])->name('clear');
    });

Route::get('/shoppingcart', Shoppingcart::class)->name('shoppingcart');

    //Add cart
    Route::get("products", [ProductController::class, "index"]);
    Route::get("products/{products:slug}", [ProductController::class, "show"]);


//recycle pages
Route::get("recycle.batteries-recycle", function () {
    return view("recycle.batteries-recycle");
})->name("batteries-recycle");
Route::get("recycle.electronics-recycle", function () {
    return view("recycle.electronics-recycle");
})->name("electronics-recycle");
Route::get("recycle.glass-recycle", function () {
    return view("recycle.glass-recycle");
})->name("glass-recycle");
Route::get("recycle.non-recycable", function () {
    return view("recycle.non-recycable");
})->name("non-recycable");
Route::get("recycle.clean-points", function () {
    return view("recycle.clean-points");
})->name("clean-points");
Route::get("recycle.recycling-place", function () {
    return view("recycle.recycling-place");
})->name("recycling-place");
Route::get("recycle.paper-card-recycle", function () {
    return view("recycle.paper-card-recycle");
})->name("paper-card-recycle");
Route::get("recycle.plastics-recycle", function () {
    return view("recycle.plastics-recycle");
})->name("plastics-recycle");
Route::get("recycle.metals-residuals", function () {
    return view("recycle.metals-residuals");
})->name("metals-residuals");
Route::get("recycle.toxics-waste", function () {
    return view("recycle.toxics-waste");
})->name("toxics-waste");
Route::get("recycle.waste-oils", function () {
    return view("recycle.waste-oils");
})->name("waste-oils");

Route::get("notifications", function () {
    return view("notifications");
})->name("notifications");


Route::get("cookie-notice", function () {
    return view("cookie-notice");
})->name("cookie-notice");

Route::post("/cookie-consent", [
    CookieConsentController::class,
    "consent",
])->name("cookie-consent");

    Route::get("policy.show", function () {
    return view("policy.show");
    })->name("policy.show");

        Route::get("terms.show", function () {
    return view("terms.show");
    })->name("terms.show");



    require __DIR__ . "/admin.php";