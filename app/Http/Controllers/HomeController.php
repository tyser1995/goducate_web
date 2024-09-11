<?php

namespace App\Http\Controllers;
use App\Models\ActivityHeader;
use App\Models\ActivityList;
use Vinkla\Hashids\Facades\Hashids;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {

        return view('pages.home',[
            'headers' => ActivityHeader::getActivityHeader(),
            'lists' => ActivityList::getActivityList()
        ]);
    }

    public function booking()
    {

        return view('pages.booking');
    }
}
