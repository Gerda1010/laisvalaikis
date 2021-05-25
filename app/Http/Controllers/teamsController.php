<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use App\Models\user_team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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
                'Name' =>'unique:team|required|max:50',
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
            $newTeam = new Team();
            $newTeam->Name = $request->input('Name');
            $teamName = $request->input('Name');

            if($request->input('fk_Userid_User2')==null){

                $tm1 = user_team::join('Team','user_team.fk_Teamid_Team','=','Team.id_Team')
                    ->select('*')
                    ->where('fk_Userid_User', '=',Auth::user()->id)
                    ->first();

                $tm2 = user_team::join('Team','user_team.fk_Teamid_Team','=','Team.id_Team')
                    ->select('*')
                    ->where('fk_Userid_User', '=',$request->input('fk_Userid_User1'))
                    ->first();
                if(($tm1 != null )&&($tm2 != null )){
                if($tm1->fk_Teamid_Team==$tm2->fk_Teamid_Team) {
//                    , $tm1->fk_Teamid_Team
                    return Redirect::back()->withErrors('Tokia komanda jau egzistuoja ');
                }}
                else{
                    $newTeam->members = 2;
                    $newTeam->save();
                    $newUserTeam = new user_team();
                    $newUserTeam->fk_Userid_User  = Auth::user()->id;
                    $newUserTeam->fk_Teamid_Team  = $newTeam->id_team;
                    $newUserTeam->save();

                    $newUserTeam1 = new user_team();
                    $newUserTeam1->fk_Userid_User  = $request->input('fk_Userid_User1');
                    $newUserTeam1->fk_Teamid_Team  = $newTeam->id_team;
                    $newUserTeam1->save();
                    $user = User::where('id','=',$request->input('fk_Userid_User1'))->first();

                    Mail::send('email-template',['user' => $user,'team'=>$teamName], function ($m) use ($user){
                        $m->from('laisvalaikio.sistema1@gmail.com', 'Laisvalaikis');
                        $m->to($user->email, $user->name)->subject('Jūs buvote pridėtas į komandą!');
                    });
                }
            }
            else{

                $tm3 = user_team::join('Team','user_team.fk_Teamid_Team','=','Team.id_Team')
                    ->select('*')
                    ->where('fk_Userid_User', '=',Auth::user()->id)
                    ->first();

                $tm4 = user_team::join('Team','user_team.fk_Teamid_Team','=','Team.id_Team')
                    ->select('*')
                    ->where('fk_Userid_User', '=',$request->input('fk_Userid_User1'))
                    ->first();
                $tm5 = user_team::join('Team','user_team.fk_Teamid_Team','=','Team.id_Team')
                    ->select('*')
                    ->where('fk_Userid_User', '=',$request->input('fk_Userid_User2'))
                    ->first();
                if(($tm3 != null )&&($tm4 != null )&&($tm5 != null )){

                    if(($tm3->id_Team==$tm4->id_Team)&&($tm4->id_Team==$tm5->id_Team)) {
                        return Redirect::back()->withErrors('Tokia komanda jau egzistuoja: ');
                    }

                }
                else{
                    $newTeam->members = 3;
                    $newTeam->save();


                    $newUserTeam = new user_team();
                    $newUserTeam->fk_Userid_User  = Auth::user()->id;
                    $newUserTeam->fk_Teamid_Team  = $newTeam->id_team;
                    $newUserTeam->save();

                    $newUserTeam1 = new user_team();
                    $newUserTeam1->fk_Userid_User  = $request->input('fk_Userid_User1');
                    $newUserTeam1->fk_Teamid_Team  = $newTeam->id_team;
                    $newUserTeam1->save();


                        $newUserTeam2 = new user_team();
                        $newUserTeam2->fk_Userid_User  = $request->input('fk_Userid_User2');
                        $newUserTeam2->fk_Teamid_Team  = $newTeam->id_team;
                        $newUserTeam2->save();

                        $user1 = User::where('id','=',$request->input('fk_Userid_User1'))->first();
                        $user2 = User::where('id','=',$request->input('fk_Userid_User2'))->first();

                    Mail::send('email-template',['user' => $user1,'team'=>$teamName], function ($m) use ($user1){
                        $m->from('laisvalaikio.sistema1@gmail.com', 'Laisvalaikis');
                        $m->to($user1->email, $user1->name)->subject('Jūs buvote pridėtas į komandą!');
                    });
                    Mail::send('email-template',['user' => $user2,'team'=>$teamName], function ($m) use ($user2){
                        $m->from('laisvalaikio.sistema1@gmail.com', 'Laisvalaikis');
                        $m->to($user2->email, $user2->name)->subject('Jūs buvote pridėtas į komandą!');
                    });

                }
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
