<?php

namespace App\Http\Controllers\Other;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class routesController extends Controller
{

    public function insertionMDP () {
        return view('insertion-mdp');
    }

    public function listeMDP () {
        return view('liste-mdp');
    }

    public function formModifMdp () {
        return view('modif-mdp');
    }

    public function verifMdp () {
        return view('page-verif');
    }

    public function listeTeam () {
        return view('liste-team');
    }

    public function insertionTeam () {
        return view('insertion-team');
    }

    public function manageTeam () {
        return view('team-manager');
    }
}
