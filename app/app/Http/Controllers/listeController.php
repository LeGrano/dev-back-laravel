<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Models\Team;

class listeController extends Controller
{
    public function getInfos()
    {
        $infos_mdp = DB::select('select * from passwords');
        $infos_teams = Team::withCount('users')->get();
        $usersTeams = $this->getUsersTeams();    
        $allData = [
            $infos_mdp,
            $infos_teams,
            
        ];
        // dd(['infos' => $allData]);
        session(['infos' => $allData]);
        return view('liste-mdp', ['usersTeams' => $usersTeams]);
    }

    public function getUsersTeams()
    {
        return Auth::user()->teams->pluck('id')->toArray();
    }
}
