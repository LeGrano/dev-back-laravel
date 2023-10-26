<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;

class listeController extends Controller
{
    public function getInfos(){
        $infos = DB::select('select * from passwords');
       
        return view('liste-mdp',['infos'=>$infos]);
    }
}
