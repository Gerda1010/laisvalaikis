<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use App\Models\user_team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class teamsController extends Controller
{
   /** public function index()
    {
        return view('teams');
    }**/
    public function index()
    {
        $allTeams = Team::all();
        $allTeams = Team::paginate(10);
        return view('teams', compact('allTeams'));
    }
    public function insertTeam(Request $request)
    {
        $validator = Validator::make(
            [   'Name' =>$request->input('Name'),

            ],
            [
                'Name' =>'unique:Team|required|max:50',
            ]
        );
        $validator2 = Validator::make(
            [   'fk_Userid_User1' => $request->input('fk_Userid_User1') ],
            [   'fk_Userid_User1' => 'required' ]
        );

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        if ($validator2->fails())
        {
            return Redirect::back()->withErrors('Turite pasirinkti bent vieną komandos narį');
        }
        else
        {
           $tmm=user_team::where('fk_Userid_User', '=',Auth::user()->id)->where('fk_Userid_User','=', $request->input('fk_Teamid_Team1'))->count();
//
//            if ($tmm>0)
//            {
//                return Redirect::back()->withErrors('Pasirinkta komanda jau dalyvauja turnyre');
//            }
//            else{
//                $newTournamentTeam = new tournament_team();
//
//                $newTournamentTeam->fk_Teamid_Team = $request->input('fk_Teamid_Team');
//                $newTournamentTeam->fk_Tournamentid_Tournament = $id;
//                $newTournamentTeam->save();
//            }




            $newTeam = new Team();
            $newTeam->Name = $request->input('Name');
         //   $tmp=$newTeam->Name;

            $newTeam->save();

            $newUserTeam = new user_team();
            $newUserTeam->fk_Userid_User  = Auth::user()->id;
            $newUserTeam->fk_Teamid_Team  = $newTeam->id_team;
            $newUserTeam->save();

            $newUserTeam1 = new user_team();
            $newUserTeam1->fk_Userid_User  = $request->input('fk_Userid_User1');
            $newUserTeam1->fk_Teamid_Team  = $newTeam->id_team;
            $newUserTeam1->save();

            if($request->input('fk_Userid_User2')!=null){
                $newUserTeam2 = new user_team();
                $newUserTeam2->fk_Userid_User  = $request->input('fk_Userid_User2');
                $newUserTeam2->fk_Teamid_Team  = $newTeam->id_team;
                $newUserTeam2->save();
            }





        }
        return Redirect::to('/teams')->with('success', 'Komanda sukurta!');
    }
    public function teamsRegistration()
    {
        $allUsers = User::all();

        return view('teamsRegistration', compact('allUsers'));
    }
}
