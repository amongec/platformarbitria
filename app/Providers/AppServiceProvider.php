<?php

namespace App\Providers;

use App\Observers\PostObserver;
use App\Models\User;
use App\Models\Post;
use App\Interfaces\TimeServiceInterface;
use App\Services\TimeService;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Spatie\Export\Exporter;

class AppServiceProvider extends ServiceProvider
{

    
    /**
     * Register any application services.
     */
    public function register(): void
    {
     Paginator::useTailwind();
       app()->bind(Newsletter::class, function (){

            $client = (new ApiClient)->setConfig([
            'apiKey' => config('services.mailchimp.key'),
            'server' => 'us22'
            ]);

            return new MailchimpNewsletter($client);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(Exporter $exporter)
    {
        Paginator::defaultView('vendor.pagination.tailwind');
       // Paginator::defaultView('posts.index');
       // Paginator::defaultView('vendor.pagination-bootstrap-4');
        Model::unguard();
        Model::preventLazyLoading(!$this->app->isProduction());
        Model::handleLazyLoadingViolationUsing(
            fn($model, $relation) => logger("Lazy Loading Violation: Attempt to load '$relation' on class " . $model::class)
        );

        Gate::define('admin', function(User $user){
            return $user->username ==='AnneMonge';
        });

        Blade::if('admin', function(){
            return request()->user()?->can('admin');
        });

        if($this->app->environment() == 'production') {
            $this->app->bind(TimeServiceInterface::class, TimeService::class);
        }


    //  $this->app['router']->middleware([
    //other middleware
    //  \\Illuminate\Compression\Middleware\CompressResponse::class
    //  ]);
    }


}
