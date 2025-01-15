<?php

namespace App\Http\Controllers;

use App\Models\Teapot;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class TeapotController extends Controller
{
    public function index()
    {
        if (request()->page) {
           $key = "teapots" . request()->page;
        } else {
           $key = "teapots";
        }

        if (Cache::has('$key')) {
            $teapots = Cache::get('$key');
        } else {
            $teapots = Teapot::where("status", 2)
                ->latest("id")
                ->paginate();

            Cache::put('$key', $teapots);
        }

        return view("teapots.index", [
            "teapots" => Teapot::latest()
                ->paginate()
                ->withQueryString(),
        ]);
    }

    public function show(Teapot $teapot)
    {
        Cache::flush();
        return view("teapots.show", [
            "teapot" => $teapot,
        ]);
    }
}