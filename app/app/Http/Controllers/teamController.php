<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Team;
use App\Models\User;


class teamController extends Controller
{
    function insertTeam(Request $request){

        $validator = Validator::make($request->all(), [
            'team' => 'required|string|unique:team,name'
        ]);
        if ($validator->fails()) {
            $errors = $validator->messages();

            $field = 'team';
            if ($errors->has($field)) 
            {
               Session::flash($field . '_error',$errors->first($field));   
            }
          
            return redirect()->back()->withInput();
            
           
        }else{
            $team = new Team;
            $team->name = $request->input('team');
            $team->save();
        
            $userId = Auth::user();
        
            $userId->team()->syncWithoutDetaching([$team->id]);
          
//Modifier model team en team sans s

            Session::flash('success','Team créée avec succès');   
            return redirect()->route('dashboard')->with('success', 'Team créée avec succès');
        }
    }

    function listeTeam(){

    }
}
