<?php

namespace App\Http\Controllers;
use App\Models\ActivityHeader;
use App\Models\ActivityList;
use App\Models\AnnouncementModel;
use App\Models\Accomodation;
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
            'lists' => ActivityList::getActivityList(),
            'announcements' => AnnouncementModel::getAnnouncement()
        ]);
    }

    public function booking()
    {
        return view('pages.booking',[
            'accomodations' => Accomodation::getAccomodation()
        ]);
    }

    public function getRoomDetails($id)
    {
        $room = Accomodation::find($id);

        if ($room) {
            return response()->json([
                'id' => $room->id,
                'type' => $room->type,
                'description' => $room->description,
                'image' => $room->image ? asset('images/accomodation/' . $room->image) : asset('images/default-image.png'),
                'capacity' => $room->capacity,
                'amount' => $room->amount,
            ]);
        }

        return response()->json(['error' => 'Room not found'], 404);
    }

}
