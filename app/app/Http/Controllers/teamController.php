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
use App\Notifications\JoinTeamNotif;
use Illuminate\Support\Facades\Notification;


class teamController extends Controller
{
    function insertTeam(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'team' => 'required|string|unique:teams,name'
        ]);
        if ($validator->fails()) {
            $errors = $validator->messages();

            $field = 'team';
            if ($errors->has($field)) {
                Session::flash($field . '_error', $errors->first($field));
            }

            return redirect()->back()->withInput();
        } else {
            $team = new Team;
            $team->name = $request->input('team');
            $team->save();

            $userId = Auth::user();

            $userId->teams()->syncWithoutDetaching([$team->id]);

            //Modifier model team en team sans s

            Session::flash('success', 'Team créée avec succès');
            return redirect()->route('dashboard')->with('success', 'Team créée avec succès');
        }
    }
    //  TODO: Faire affichage des teams et fonctionnalité pour les rejoindre en prevision de l'envoie de mail ! 
    public function joinTeam($id)
    {
        // Récupérer l'équipe par ID
        $team = Team::find($id);

        // Vérifier si l'équipe existe
        if (!$team) {
            return redirect()->route('liste-mdp')->with('success_team', 'Équipe non trouvée');
        }
        $userId = Auth::user();
        $userId->teams()->syncWithoutDetaching([$team->id]);
        $usersTeams = $this->getUsersTeams();  
        //TODO Faire en sorte de pouvoir ajouter un user via qqun d'autre !!!
        //TODO Associer des mdp a des teams 
        //TODO Afficher les mdp que seul l'utilisateur peut voir et pas TOUT !!!
        //TDO Exercice 4 !
        //Envoi EMAIL
        $team->users->each(function ($user) use ($team) {
            $user->notify(new JoinTeamNotif($team));
        });

        session()->flash('success_team', 'Vous avez rejoint l\'équipe avec succès!');
        session()->flash('team_id', $id);
        return view('liste-mdp', ['usersTeams' => $usersTeams]);
    }

    public function leaveTeam($id)
{
    $team = Team::find($id);
    if (!$team) {
        return redirect()->route('liste-mdp')->with('error_team', 'Équipe non trouvée');
    }
    $userId = Auth::user();

    $userId->teams()->detach($team->id);
    
    $usersTeams = $this->getUsersTeams();
    // Rediriger avec un message de succès
    session()->flash('success_team', 'Vous avez quitté l\'équipe avec succès!');
    session()->flash('team_id', $id);
    return view('liste-mdp', ['usersTeams' => $usersTeams]);
}

    public function getUsersTeams()
    {
        return Auth::user()->teams->pluck('id')->toArray();
    }

    function listeTeam()
    {
    }
}
