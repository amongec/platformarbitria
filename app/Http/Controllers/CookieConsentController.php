<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CookieConsentController extends Controller
{
/**

     * User has accepted to place cookies, set the consent cookie to remove cookie notice banner.

     *

     * @return \Illuminate\Http\JsonResponse

     */

    public function consent()

    {

        return response()

            ->json(['cookie_consent' => true])

            ->cookie(config('cookie-consent.cookie_name'), 1, 2628000);

    }
}
