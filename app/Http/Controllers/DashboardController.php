<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\WebPush;

use App\Models\PushSubscription;
use App\Models\User;
use App\Models\Role;
use App\Models\Announcement;

use App\Events\MyEvent;

use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display all the static pages when authenticated
     *
     * @param string $page
     * @return \Illuminate\View\View
     */
    public function index()
    {

        $totals = [
        'usercount' => User::count()
        ];


        $announcement = Announcement::where('when','<=',Carbon::now()->format('Y-m-d H:m'))
        ->get();

        foreach($announcement as $announcements){
            $announcement_ = Announcement::find($announcements->id);
            $announcement_->delete();
        }

        if (view()->exists("pages.dashboard")) {
            return view("pages.dashboard", [
                'totals' => $totals,
                'subscriptions' => PushSubscription::all(),
                'announcement' => Announcement::orderBy('created_at','DESC')->get()
            ]);
        }

        return abort(404);
    }
}
