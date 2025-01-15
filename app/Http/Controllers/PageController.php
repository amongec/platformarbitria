<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use App\Traits\CartActions;
use App\Repositories\Shop\ShopRepositoryInterface;
use App\Services\Cart;
use Illuminate\View\View;

class PageController extends Controller
{

    public function conditionsKm0()
    {
        return view("pages.conditions-km0");
    }

    public function conditionsNet()
    {
        return view("pages.conditions-net");
    }

    public function upgrade()
    {
        return view("pages.upgrade");
    }

    public function userAlert()
    {
        return view("pages.user-alert");
    }

    public function userDataBase()
    {
        return view("pages.user-database");
    }


}
