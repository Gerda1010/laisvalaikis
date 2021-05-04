<?php

namespace App\Http\Controllers;
use App\Models\Objects;
use App\Models\Reservation;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\user_team;
use Illuminate\Support\Facades\Redirect;


class profileController extends Controller
{
    public function index(){
        $id = Auth::user()->id;
        $allTeams = Team::all();
        $userTeams = user_team::where('fk_Userid_User','=',$id)->get();
        $userReservations = Reservation::where('fk_Userid_User', '=', $id)->get();
        $allObjects = Objects::all();
     //   $allTournTeams = tournament_team::where('fk_Tournamentid_Tournament','=', $id)->get();
        return view('profile',compact('userTeams','allTeams', 'userReservations', 'allObjects'));
    }
    public function cancelReservation($id){
        Reservation::where('id_Reservation','=',$id)->delete();
        return Redirect::to('/profile')->with('Rezervacija atšaukta');
    }
}
