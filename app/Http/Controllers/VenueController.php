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

        $venues = Venue::paginate(2);
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
        // return view('admin.venueDash')->with(['venues'=>$venues]);
        return redirect(url('/venueDash '));
    }

    public function deleteVenue($id){
        $venue = Venue::findOrFail($id);
        $venue->delete();
        return redirect(url('/venueDash'));
    }

    public function waveRecommendVenue($category){
        $allVenue = Venue::where('venueCategory', $category)->get();

        return response()->json([
            'venues' => $allVenue
        ]);
    }

    public function showCategories($id){
        $allCategories = VenueCategories::get();
        return view('showCategories')->with(['categories'=>$allCategories]);
    }

    public function showVenues($id, $category){
        $allVenues = Venue::where('venueCategory', $category)->get();
        $allMembers = GroupMember::where('groupID', $id)->get();

        // dd($allMembers);

        // **finding center for many points:
        // (((xsub1 + xsub2 + ... xsubn)/(n)), ((ysub1 + ysub2 + ... ysubn)/(n)))
            
            
        // **distance between 2 points
        // d = sqrt((x1 - x2)sqrd + (y1 - y2)sqrd)


        ////////////////////////////////////////////////// SOLVING FOR CENTER POINT AMONG USERS
        $tempLat = 0;
        $tempLong = 0;
        foreach ($allMembers as $member) {
            $tempLat += (double)$member->latitude;
            $tempLong += (double)$member->longitude;
        }

        $center = [
            'latitude' => '',
            'longitude' => '',
        ];

        $center['latitude'] = $tempLat/count($allMembers);
        $center['longitude'] = $tempLong/count($allMembers);
            

        ////////////////////////////////////////////////// SOLVING FOR MAX DISTANCE OF 'GEOFENCE'
        $maxDist = 0.005; // <--- default for max distance is 0.5 kilometers

        foreach ($allMembers as $member) {
            $distance = sqrt(pow($center['latitude'] - $member->latitude, 2) + pow($center['longitude'] - $member->longitude, 2));

            if($maxDist < $distance)
                $maxDist = $distance;
        }

        ////////////////////////////////////////////////// CHECKING ALL VENUES IF IT FITS INSIDE THE GEOFENCE
        $nearVenues = [];

        foreach ($allVenues as $venue) {
            $distance = sqrt(pow($center['latitude'] - $venue->latitude, 2) + pow($center['longitude'] - $venue->longitude, 2));

            if($distance <= $maxDist)
                array_push($nearVenues, $venue);
        }

        // dd($nearVenues);

        // return response()->json([
        //     'venues' => $nearVenues
        // ]);

        // dd($nearVenues);

        return view('user.chooseVenue')->with(['venues' => $nearVenues]);
    }


}
