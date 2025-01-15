<?php
namespace App\Providers;

use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Cart\CartRepositoryInterface;
use App\Repositories\Category\EloquentCategoryRepository;
use App\Repositories\Cart\SessionCartRepository;
use App\Repositories\Shop\EloquentShopRepository;
use App\Repositories\Shop\ShopRepositoryInterface;
use App\Repositories\Teapot\EloquentTeapotRepository;
use App\Repositories\Teapot\TeapotRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider{

public function register(): void{

    $this->app->bind(
        abstract:CategoryRepositoryInterface::class,
        concrete:EloquentCategoryRepository::class,
    );

        $this->app->bind(
        abstract:TeapotRepositoryInterface::class,
        concrete:EloquentTeapotRepository::class,
    );

        $this->app->bind(
        abstract:CartRepositoryInterface::class,
        concrete:SessionCartRepository::class,
    );

        $this->app->bind(
        abstract:ShopRepositoryInterface::class,
        concrete:EloquentShopRepository::class,
    );
}
    public function boot():void{

    }
}