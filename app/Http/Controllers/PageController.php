<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Vinkla\Hashids\Facades\Hashids;
use Symfony\Component\Intl\Currencies;
use App\Helpers\GlobalHelper;

use DB;
use Route;

use App\Models\User;
use App\Models\RaffleEvent;
use App\Models\EventImage;
use App\Models\EventParticipant;


class PageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Display all the static pages when authenticated
     *
     * @param string $page
     * @return \Illuminate\View\View
     */
    public function index(string $page)
    {
        if (view()->exists("pages.dashboard")) {
            return view("pages.dashboard");
        }

        return abort(404);
    }


    public function register(){
        return view('auth.register');
    }
}
