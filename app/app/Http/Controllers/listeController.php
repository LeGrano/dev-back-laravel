<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Models\Team;
use App\Models\Password;

use function Laravel\Prompts\password;

class listeController extends Controller
{
    public function getInfos()
    {
        // Récupérer les mots de passe de l'utilisateur connecté
        $infos_mdp = Password::where('user_id', auth()->id())->get();
        $infos_teams = Team::withCount('users')->get();
        $usersTeams = $this->getUsersTeams();
        $pwdPerTeams = $this->getTeamsPasswords();
        $allData = [
            $infos_mdp,
            $infos_teams,
            $pwdPerTeams,
        ];
        // dd(['infos' => $allData]);
        session(['infos' => $allData]);
        return view('liste-mdp', ['usersTeams' => $usersTeams]);
    }

    public function getUsersTeams()
    {
        return Auth::user()->teams->pluck('id')->toArray();
    }
    public function getTeamsPasswords()
    {
        $teams = Auth::user()->teams; // Récupère toutes les équipes de l'utilisateur
    
        $allData = [];
    
        foreach ($teams as $team) {
            $passwords = $team->passwords;

            foreach ($passwords as $password) {
                $pivotData = $password->pivot; // Accède aux données de la table intermédiaire

                $id_password = $pivotData->password_id;
                $id_team = $pivotData->team_id;
                
                $allData[] = ['id_password' => $id_password, 'id_team' => $id_team];
            }
                $allDataWithDetails = [];

                foreach ($allData as $data) {
                    $id_password = $data['id_password'];
                    $id_team = $data['id_team'];

                    $team = Team::find($id_team);
                    $password = Password::find($id_password);

                    $allDataWithDetails[] = [
                        'team' => $team,
                        'password' => $password,
                    ];
                }
            } 
            return $allDataWithDetails;
    }
}
