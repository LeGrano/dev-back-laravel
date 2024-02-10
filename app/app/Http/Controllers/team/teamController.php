<?php

namespace App\Http\Controllers\team;

use App\Http\Controllers\Controller;
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
use App\Http\Controllers\Other\listeController;
use App\Models\Password;


class teamController extends Controller
{
    function insertTeam(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'team' => 'required|string|unique:teams,name',
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


            Session::flash('success', 'Team créée avec succès');
            return redirect()->route('dashboard')->with('success', 'Team créée avec succès');
        }
    }

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

        //TODO Si pas de user gerer affichage
        //TODO Exercice 4 !
        //Envoi EMAIL

        $team->users->each(function ($user) use ($team) {
            $user->notify(new JoinTeamNotif('joinTeam', $team));
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
        $team->users->each(function ($user) use ($team) {
            $user->notify(new JoinTeamNotif('leaveTeam', $team));
        });
        // Rediriger avec un message de succès
        session()->flash('success_team', 'Vous avez quitté l\'équipe avec succès!');
        session()->flash('team_id', $id);
        return view('liste-mdp', ['usersTeams' => $usersTeams]);
    }

    public function goToManageTeam($id)
    {
        // Récupérer la liste des utilisateurs qui ne sont pas déjà dans l'équipe
        $team = Team::find($id);
        $passwords = Password::where('user_id', auth()->id())->get();

        $availableUsers = User::whereNotIn('id', $team->users->pluck('id'))->get();
        //dd($availableUsers);
        return view('team-manager', ['availableUsers' => $availableUsers, 'team' => $team])->with('passwords', $passwords);
        //todo : ajouter les mdp qui ne sont pas deja dans la team
    }


    public function addUsers(Request $request)
    {
         // Récupérer l'équipe par ID
         $teamId = $request->input('team_id');
         $team = Team::find($teamId);
         $userIds = $request->input('user_ids');
 
         // Si aucun sélectionnés
         if (!$userIds || empty($userIds)) {
            session()->flash('error', 'Aucun utilisateur sélectionné');
            return $this->goToManageTeam($teamId)->with('error', 'Aucun utilisateur sélectionné');
         }
 
         // Ajouter utilisateurs à l'équipe
         $team->users()->syncWithoutDetaching($userIds);
         session()->flash('success_team', 'Vous avez ajouter des utilisateurs à l\'équipe avec succès!');
         $usersTeams = $this->getUsersTeams();
         $listeController = app(listeController::class);
         $team->users->each(function ($user) use ($team) {
            $user->notify(new JoinTeamNotif('addUsers', $team));
        });
         return $listeController->getInfos();
         //return redirect()->route('liste-team')->with('success', 'Utilisateurs ajoutés avec succès');
     }

    public function addTeamPassword(Request $request)
    {

        $teamId = $request->input('team_id');
        $team = Team::find($teamId);
        $password = $request->input('password_ids');
        if (!$password || empty($password)) {
            session()->flash('error', 'Aucun mot de passe sélectionné');
            return $this->goToManageTeam($teamId)->with('error', 'Aucun mot de passe sélectionné');
        }

        $team->passwords()->syncWithoutDetaching($password);
        $usersTeams = $this->getUsersTeams();
        $listeController = app(listeController::class);
        $team->users->each(function ($user) use ($team) {
            $user->notify(new JoinTeamNotif('addTeamPassword', $team));
        });
        return $listeController->getInfos();
    }

    public function getUsersTeams()
    {
        return Auth::user()->teams->pluck('id')->toArray();
    }

    function listeTeam()
    {
    }
}

