<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SystemUser;
use App\QueueTalkCircle;
use App\EmptyMuch;
use App\UsersInterests;
use App\PostFeeling;
use App\Interest;
use App\QueueUsersProblem;
use App\SystemConfig;
use App\Problem;
use App\Specialization;
use App\FacilitatorSpec;
use App\SpecMatchProblem;
use App\Group;
use App\GroupActivities;
use App\GroupDetails;
use App\GroupDetailsInterests;
use App\GroupMember;
use App\Activity;
use App\VenueCategories;
use App\Venue;
use Auth;

class VenueController extends Controller
{
    public function showAll(){
        //loop for markers
        // var marker = new google.maps.Marker({
        //     map: map,
        //     position: myLatLng,
        //     title: 'Hello World!'
        //   });

        $venues = Venue::get();
        return view('admin.venueDash')->with(['venues'=>$venues]);
    }

    public function testgmap(){
        $venueCats = VenueCategories::get();
        return view('admin.addNewVenue')->with(['venueCats'=>$venueCats]);
    }

    public function saveVenue(Request $req){
        $newVenue = new Venue();
        $newVenue->venueName = $req->location;
        $newVenue->latitude = $req->latitude;
        $newVenue->longitude = $req->longitude;
        $newVenue->venueCategory = $req->venueCategory;

        $newVenue->save();

        $venues = Venue::get();
        return view('admin.venueDash')->with(['venues'=>$venues]);
    }

    public function deleteVenue($id){
        $venue = Venue::findOrFail($id);
        $venue->delete();
        return redirect(url('/venueDash'));
    }
}
