<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Activity;
use App\Interest;
use App\EmptyMuch;
use App\Files;
use App\ActivityTag;
use App\Step;
use App\Equipment;
use Validator;

class ActivityController extends Controller
{
    private $messages = [
        'title.required'=>'Please enter a title for the activity.',
        'title.unique'=>'This title has already been taken! Please try a different title.',
        'details.required'=>'Please enter a few details for the activity.',
        'tags.required'=>'Please choose a few tags that relate to the activity.',
        'equipment.required'=>'Please enter the needed equipment for the activity.',
        'step.required'=>'Please add a few steps on how to do the activity.',
    ];
    
    public function getActivities(){

    }

    public function chosenActivities(Request $request){
        
    }
//--------------------------------------
    public function dashboard(){
        $list = Activity::paginate(3);
        return view('dashboard')->with(["list"=>$list]);
    }

    public function addAct(){
        $mode = 'add';
        $tags = Interest::get();
        return view('addActivity')->with(["mode"=>$mode, "tags"=>$tags]);
    }

    public function saveAct(Request $req){
        // dd($req);
        $act = new Activity;

        $rules = [
            'title'=>'required|unique:activities,title',
            'tags'=>'required',
            'details'=>'required',
            'equipment'=>'required',
            'step'=>'required'
        ];

        $validation = Validator::make($req->all(), $rules, $this->messages);

        if($validation->passes()){
            if(Activity::get() == EmptyMuch::get()){
                $act->actID = "A00001";
            }
            else{
                $row = Activity::orderby('actID', 'desc')->first();
                $temp = substr($row['actID'], 1);
                $temp =(int)$temp + 1;
                $newActID = "A".(string)str_pad($temp, 5, "0", STR_PAD_LEFT);
                
                $act->actID = $newActID;
            }
            $act->title = $req->title;
            $act->details = $req->details;
            $act->participants = $req->participants;
            if($req->time == "none")
                $act->time = "None";
            else
                $act->time = (string)$req->time.(string)$req->timeDeno;
            $act->gender = $req->gender;
            $activityTemp = $act->actID;

            $act->save();

        //-----STEPS
        if(!is_null($req->step[0])){
                foreach ($req->step as $step) {
                    if(!is_null($step)){
                        $newStep = new Step;
                        if(Step::get() == EmptyMuch::get()){
                            $newStep->stepID = "S00001";
                        }
                        else{
                            $row = Step::orderby('stepID', 'desc')->first();
                            $temp = substr($row['stepID'], 1);
                            $temp =(int)$temp + 1;
                            $id = "S".(string)str_pad($temp, 5, "0", STR_PAD_LEFT);
                            $newStep->stepID = $id;
                        }
                        $newStep->stepDesc = $step;
                        $newStep->actID = $activityTemp;
                        $newStep->save();
                    }
                }
            }

        //-----EQUIPMENT
        if(!is_null($req->equipment[0])){
            for ($i=0; $i < count($req->equipment); $i++) { 
                if(!is_null($req->equipment[$i])){
                    $newEquipment = new Equipment;
                    if(Equipment::get() == EmptyMuch::get()){
                        $newEquipment->equipmentID = "E00001";
                    }
                    else{
                        $row = Equipment::orderby('equipmentID', 'desc')->first();
                        $temp = substr($row['equipmentID'], 1);
                        $temp =(int)$temp + 1;
                        $id = "E".(string)str_pad($temp, 5, "0", STR_PAD_LEFT);
                        $newEquipment->equipmentID = $id;
                    }
                    $newEquipment->equipmentName = $req->equipment[$i];
                    $newEquipment->quantity = $req->quantity[$i];
                    $newEquipment->actID = $activityTemp;
                    $newEquipment->save();
                }
            }
        }

        //-----FILES
        if(!is_null($req->media[0])){
            foreach ($req->media as $file) {
                $fileName = $req->title."/uploads"."/".$file->getClientOriginalName();
                $fileType = $file->getClientOriginalExtension();
                Storage::disk('public')->put($fileName, File::get($file));
                $url = Storage::url($fileName);

                $newFile = new Files;
                if(Files::get() == EmptyMuch::get()){
                    $newFile->fileID = "F00001";
                }
                else{
                    $row = Files::orderby('fileID', 'desc')->first();
                    $temp = substr($row['fileID'], 1);
                    $temp =(int)$temp + 1;
                    $id = "F".(string)str_pad($temp, 5, "0", STR_PAD_LEFT);
                    $newFile->fileID = $id;
                }
                $newFile->fileContent = $url;
                $newFile->fileExt = $fileType;
                $newFile->actID = $activityTemp;
                $newFile->save();
            }
        }

        //-----INTERESTS
            foreach ($req->tags as $index) {
                $tag = Interest::where("interestName", $index)->get();
                $activityTag = new ActivityTag;
                $activityTag->tagID = $tag[0]->interestID;
                $activityTag->actID = $activityTemp;
                $activityTag->save();
            }

            return redirect(url('/home'));
        }
        else{
            return redirect()->back()->withInput()->withErrors($validation);
        }
    }

    public function editAct($id){
        $mode = 'edit';
        $act = Activity::findOrFail($id);
        $tags = Interest::get();
        return view('addActivity')->with(["mode"=>$mode, "act"=>$act, "tags"=>$tags]);
    }

    public function saveActEdit(Request $req){
        $act = Activity::findOrFail($req->secretID);

        $rules = [
            'title'=>'required',
            'tags'=>'required',
            'details'=>'required',
            'equipment'=>'required',
            'step'=>'required'
        ];
        $validation = Validator::make($req->all(), $rules, $this->messages);

        if($validation->passes()){
            $act->title = $req->title;
            $act->details = $req->details;
            $act->participants = $req->participants;

            $origStep = Step::where("actID", $act->actID)->get();
            foreach ($origStep as $row) {
                $row->delete();
            }
            if(!is_null($req->step[0])){
                foreach ($req->step as $step) {
                    if(!is_null($step)){
                        $newStep = new Step;
                        if(Step::get() == EmptyMuch::get()){
                            $newStep->stepID = "S00001";
                        }
                        else{
                            $row = Step::orderby('stepID', 'desc')->first();
                            $temp = substr($row['stepID'], 1);
                            $temp =(int)$temp + 1;
                            $id = "S".(string)str_pad($temp, 5, "0", STR_PAD_LEFT);
                            $newStep->stepID = $id;
                        }
                        $newStep->stepDesc = $step;
                        $newStep->actID = $act->actID;
                        $newStep->save();
                    }
                }
            }


            $origEquip = Equipment::where("actID", $act->actID)->get();
            foreach ($origEquip as $row) {
                $row->delete();
            }
            if(!is_null($req->equipment[0])){
                for ($i=0; $i < count($req->equipment); $i++) { 
                    if(!is_null($req->equipment[$i])){
                        $newEquipment = new Equipment;
                        if(Equipment::get() == EmptyMuch::get()){
                            $newEquipment->equipmentID = "E00001";
                        }
                        else{
                            $row = Equipment::orderby('equipmentID', 'desc')->first();
                            $temp = substr($row['equipmentID'], 1);
                            $temp =(int)$temp + 1;
                            $id = "E".(string)str_pad($temp, 5, "0", STR_PAD_LEFT);
                            $newEquipment->equipmentID = $id;
                        }
                        $newEquipment->equipmentName = $req->equipment[$i];
                        $newEquipment->quantity = $req->quantity[$i];
                        $newEquipment->actID = $act->actID;
                        $newEquipment->save();
                    }
                }
            }

        $origTags = ActivityTag::where("actID", $act->actID)->get();
        foreach ($origTags as $row) {
            $row->delete();
        }
        foreach ($req->tags as $index) {
            $tag = Interest::where("interestName", $index)->get();
            $activityTag = new ActivityTag;
            $activityTag->tagID = $tag[0]->interestID;
            $activityTag->actID = $act->actID;
            $activityTag->save();
        }

        $origMedia = Files::where("actID", $act->actID)->get();
        foreach ($origMedia as $row) {
            $row->delete();
        }
        if(!is_null($req->media[0])){
            foreach ($req->media as $file) {
                // $fileHolder = $file->file('media');
                $fileName = $req->title."/uploads"."/".$file->getClientOriginalName();
                $fileType = $file->getClientOriginalExtension();
                Storage::disk('public')->put($fileName, File::get($file));
                $url = Storage::url($fileName);

                $newFile = new Files;
                if(Files::get() == EmptyMuch::get()){
                    $newFile->fileID = "F00001";
                }
                else{
                    $row = Files::orderby('fileID', 'desc')->first();
                    $temp = substr($row['fileID'], 1);
                    $temp =(int)$temp + 1;
                    $id = "F".(string)str_pad($temp, 5, "0", STR_PAD_LEFT);
                    $newFile->fileID = $id;
                }
                $newFile->fileContent = $url;
                $newFile->fileExt = $fileType;
                $newFile->actID = $act->actID;
                $newFile->save();
            }
        }

            if($req->time == "none")
                $act->time = "None";
            else
                $act->time = (string)$req->time.(string)$req->timeDeno;
            $act->gender = $req->gender;
            $act->save();

            return redirect(url('/home'));
        }
        else
            return back()->withInput($req->all())->withErrors($validation);
    }

    public function deleteAct($id){
        $act = Activity::findOrFail($id);
        $act->delete();
        return redirect(url('/home'));
    }

    public function viewAct($id){
        $act = Activity::findOrFail($id);
        return view('viewSingleActivity')->with(["act"=>$act]);
    }
}
