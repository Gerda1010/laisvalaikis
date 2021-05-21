<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\event_log;
use App\Models\Game;
use App\Models\Matches;
use App\Models\State;
use App\Models\StartEvent;
use App\Models\Team;
use App\Models\Tournament;
use App\Models\tournament_team;
use App\Models\tournament_user;
use App\Models\User;
use App\Models\user_team;
use App\Models\UserMatch;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class tournamentsController extends Controller
{
    public function index ()
    {
        $allTourn = Tournament::orderby('state','desc')->get();

        $allStates = State::all();
        $allGames = Game::all();

        foreach ($allTourn as $tr){

            $teamCount = DB::table('tournament_team')
                ->select(DB::raw('count(*) as teamsCount'))
                ->where('fk_Tournamentid_Tournament','=', $tr->id_Tournament)
                ->groupBy('fk_Tournamentid_Tournament');

        }
        return view('tournaments', compact('allTourn', 'allStates', 'allGames'));
    }
    public function openTournament($id){

        $Tournament = Tournament::where('id_Tournament', '=', $id)->first();
        $maxTeams = Tournament::join('game','tournament.fk_Gameid_Game','=','game.id_Game')
            ->select('game.NumberOfMembers')
            ->where('tournament.id_Tournament','=',$id)
            ->first();
        $maxxx = $maxTeams->NumberOfMembers;

        $allTeams = Team::where('members','=',$maxxx)->get();
        $logs = event_log::where('fk_Tournament', '=', $id)->get();

        $allUserTeams = user_team::where('fk_Userid_User','=', Auth::user()->id)->get();


        $allUsers = User::all();
        $allStates = State::all();
        $allGames = Game::all();
        $allComments = Comment::all();
        $allTournTeams = tournament_team::where('fk_Tournamentid_Tournament','=', $id)->orderBy('victories', 'desc')->get();
        $allTournUsers = tournament_user::where('fk_Tournamentid_Tournament','=', $id)->orderBy('victories', 'desc')->get();

        $allMatches = Matches::where('fk_Tournamentid_Tournament','=', $id)->get();
        $allMatchesUser = UserMatch::where('fk_Tournamentid_Tournament','=', $id)->get();

      //  $tournTeams = Team::where('fk_Tournamentid_Tournament','=', $id)->get();

       $tournTeams1 = Matches::join('Team','Matches.fk_Team1','=','Team.id_Team')
           ->select('Team.Name as pavad1','Team.id_Team as komid','Matches.*')
           ->distinct(['komid'])
           ->get();
        $tournTeams2 = Matches::join('Team','Matches.fk_Team2','=','Team.id_Team')
            ->select('Team.Name as pavad2','Team.id_Team as komid2','Matches.*')
            ->distinct()
            ->get(['komid2']);
        $tournUsers1 = UserMatch::join('Users', 'UserMatch.fk_Participantid_User','=','Users.id')
            ->select('Users.name as vardas1','Users.id as userid','UserMatch.*')
            ->distinct(['userid'])
            ->get();
        $tournUsers2 = UserMatch::join('Users', 'UserMatch.fk_Participantid_User1','=','Users.id')
            ->select('Users.name as vardas2','Users.id as userid2','UserMatch.*')
            ->distinct(['userid2'])
            ->get();






        $komandos = tournament_team::where('fk_Tournamentid_Tournament','=',36)->orderby('victories','desc')->first();
//        $test = DB::table('matches') DISTINCT




        return view('tournament', compact('Tournament','komandos','tournUsers1','tournUsers2','maxTeams','allTeams','allMatchesUser', 'allUserTeams','logs','allUsers', 'allGames', 'allStates', 'allTournTeams', 'allTournUsers','allComments','allMatches','tournTeams1','tournTeams2'));
    }
    public function insertTournament(Request $request)
    {
        $validator = Validator::make(
            [   'Name' =>$request->input('Name'),
                'StartDate' =>$request->input('StartDate'),
                'MaximumTeams' => $request->input('MaximumTeams'),
                'StartEvent' => $request->input('StartEvent'),
                'fk_Gameid_Game' =>$request->input('fk_Gameid_Game'),

            ],
            [
                'Name' =>'required|max:50',
                'MaximumTeams'=>'nullable|numeric',
                'StartDate'=> 'required',
                'StartEvent' =>'required',
                'fk_Gameid_Game' => 'required'
            ]
        );

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        else
        {
            $allStates = State::all();
            $newTourn = new Tournament();

            $newTourn->Name = $request->input('Name');

            $newTourn->StartDate = $request->input('StartDate');
            $newTourn->MaximumTeams = $request->input('MaximumTeams');
            $newTourn->StartEvent = $request->input('StartEvent');
            $newTourn->fk_Gameid_Game = $request->input('fk_Gameid_Game');

            $newTourn->fk_Organizerid_User = Auth::user()->id;
            $newTourn->State = '6';

            $newTourn->save();

        }
        return Redirect::to('/tournaments')->with('success', 'Turnyras sukurtas');
    }
    public function createTournament()
    {
       $StartEvents = StartEvent::all();
       $allGames = Game::all();
        return view('createTournament', compact('StartEvents', 'allGames'));
    }

    public function createTournamentTeam(Request $request, $id){
//
        $tmm=tournament_team::where('fk_Tournamentid_Tournament', '=',$id)->where('fk_Teamid_Team','=', $request->input('fk_Teamid_Team'))->count();


        if ($tmm>0)
        {
            return Redirect::back()->withErrors('Pasirinkta komanda jau dalyvauja turnyre');
        }
        else{
            $newTournamentTeam = new tournament_team();

            $newTournamentTeam->fk_Teamid_Team = $request->input('fk_Teamid_Team');
            $newTournamentTeam->fk_Tournamentid_Tournament = $id;
            $newTournamentTeam->save();
        }
        $newLog = new event_log();
        $newLog->log_date = Carbon::now();
        $newLog->log_text = "Užregistravo komandą";
        $newLog->fk_Tournament = $id;
        $newLog->fk_Userid_User =  Auth::user()->id;
        $newLog->save();


        $teamsCount = tournament_team::where('fk_Tournamentid_Tournament', '=',$id)->count();
        $turnyras = Tournament::where('id_Tournament','=',$id)->first();
        if($teamsCount==$turnyras->MaximumTeams){
            return $this->startTournament($id);
        }
        else
         return back()->with('success', 'Jūs užsiregistravote!');
    }
    public function createTournamentUser($id)
    {
        $tmm=tournament_user::where('fk_Tournamentid_Tournament', '=',$id)->where('fk_Userid_User','=', Auth::user()->id)->count();
        if ($tmm>0)
        {
            return Redirect::back()->withErrors('Jūs jau dalyvaujate turnyre');
        }
        else{
            $newTournamentUser = new tournament_user();

            $newTournamentUser->fk_Userid_User = Auth::user()->id;
            $newTournamentUser->fk_Tournamentid_Tournament = $id;
            $newTournamentUser->save();
        }
        $newLog = new event_log();
        $newLog->log_date = Carbon::now();
        $newLog->log_text = "Užregistravo naudotojas";
        $newLog->fk_Tournament = $id;
        $newLog->fk_Userid_User =  Auth::user()->id;
        $newLog->save();


        $usersCount = tournament_user::where('fk_Tournamentid_Tournament', '=',$id)->count();
        $turnyras = Tournament::where('id_Tournament','=',$id)->first();
        if($usersCount==$turnyras->MaximumTeams){
            return $this->startTournamentUsers($id);
        }
        else
            return back()->with('success', 'Jūs užsiregistravote!');

    }
    public function insertComment(Request $request, $id)
    {
        $validator = Validator::make(
            [
                'com_Text' =>$request->input('com_Text'),
            ],
            [
                'com_Text' => 'required|max:100',
            ]
        );
        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator);
        }
        else
        {
            $Comment= new Comment();
            $Comment->fk_Userid_User  = Auth::user()->id;
            $Comment->com_Text  = $request->input('com_Text');
            $Comment->Com_Date  = Carbon::now();
            $Comment->fk_Tournamentid_Tournament = $id;

            $Comment->save();
        }
        return Redirect::back()->with('success', 'Komentaras pridėtas');
    }
    public function startTournament($id){

         Tournament::where('id_Tournament', '=', $id)->update(
            [
                'State'=> '5',
            ]
        );
        $teamCount=tournament_team::where('fk_Tournamentid_Tournament', '=',$id)->count();
        $matchCount=Matches::where('fk_Tournamentid_Tournament', '=',$id)->count();
//        $x=0;

//            foreach ($allTeams as $tm1){
//                foreach ($allTeams as $tm2){
////                $allTeams->values()->get($x);
//                $newMatch= new Matches();
//                $newMatch->fk_Tournamentid_Tournament= $id;
//                $newMatch->fk_Team1=$tm1->fk_Teamid_Team;
//                $newMatch->fk_Team2=$tm2->fk_Teamid_Team;
//
//                $newMatch->save();
////                $x=$x+1;
//            }}
//        $allTeams = tournament_team::where('fk_Tournamentid_Tournament', '=', $id)->get();
//        $allTeams->toArray();

        $allteams2 = DB::table('tournament_team')
            ->select(DB::raw('fk_Teamid_Team'))
            ->where('fk_Tournamentid_Tournament', '=', $id)
            ->get();
        $allteams2->toArray();
            for($i=0;$i<count($allteams2)-1;$i++){
                for($y=$i+1;$y<count($allteams2);$y++){
// cia tikrinti ar komandose nezaidzia tas pats asmuo

                    $newMatch= new Matches();
                    $newMatch->fk_Tournamentid_Tournament= $id;
                    $newMatch->fk_Team1=$allteams2[$i]->fk_Teamid_Team;
                    $newMatch->fk_Team2=$allteams2[$y]->fk_Teamid_Team;

                    $newMatch->save();
                }
            }
        $newLog = new event_log();
        $newLog->log_date = Carbon::now();
        $newLog->log_text = "Pradėjo turnyrą";
        $newLog->fk_Tournament = $id;
        $newLog->fk_Userid_User = Auth::user()->id;
        $newLog->save();
        return back()->with('success', 'Turnyras pradėtas!');
    }
    public function startTournamentUsers($id){

        $newMatch= new UserMatch();
        $newMatch->fk_Tournamentid_Tournament= $id;
        $newMatch->fk_Participantid_User=5;
        $newMatch->fk_Participantid_User1=2;
        $newMatch->result1=2;
        $newMatch->result2 = 3;
        $newMatch->winner = 2;
        $newMatch->save();

        $allusers = DB::table('tournament_user')
            ->select(DB::raw('fk_Userid_User'))
            ->where('fk_Tournamentid_Tournament', '=', $id)
            ->get();
        $allusers->toArray();

        for($i=0;$i<count($allusers)-1;$i++){
            for($y=$i+1;$y<count($allusers);$y++){

                $newMatch1= new UserMatch();
                $newMatch1->fk_Tournamentid_Tournament= $id;
                $newMatch1->fk_Participantid_User=$allusers[$i]->fk_Userid_User;
                $newMatch1->fk_Participantid_User1=$allusers[$y]->fk_Userid_User;
                $newMatch1->save();
            }
        }
        Tournament::where('id_Tournament', '=', $id)->update(
            [
                'State'=> '5',
            ]
        );
        $newLog = new event_log();
        $newLog->log_date = Carbon::now();
        $newLog->log_text = "Pradėjo turnyrą";
        $newLog->fk_Tournament = $id;
        $newLog->fk_Userid_User = Auth::user()->id;
        $newLog->save();
        return back()->with('success', 'Turnyras pradėtas!');

    }

    public function insertResult(Request $request,$id){
        $turnyroId = Matches::where('id_team_match', '=', $id)->first();
        $validator = Validator::make(
            [
                'result1'=> $request->input('result1'),
                'result2'=> $request->input('result2')
            ],
            [
                'result1'=> 'required',
                'result2'=> 'required|different:result1'
            ]
        );

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator, 'error message');
        }
        else
        {
                Matches::where('id_team_match', '=', $id)->update(
                [
                    'result1'=> $request->input('result1'),
                    'result2'=> $request->input('result2'),
                ]
                    );
            $newLog = new event_log();
            $newLog->log_date = Carbon::now();
            $newLog->log_text = "Įvedė rezultatus";
            $newLog->fk_Tournament = $turnyroId->fk_Tournamentid_Tournament;
            $newLog->fk_Userid_User =  Auth::user()->id;
            $newLog->save();

        }
        // cia ne back o i kita funkcija kazkaip turetu
         return $this->findMatchWinner($id);
//        return Redirect::back()->with('success', 'Rezultatas išsaugotas');
    }
    //tikrinti kuri komanda laimejo
    public function findMatchWinner($id)
    {
        $mt = Matches::where('id_team_match', '=', $id)->first();

        if ($mt->result1 > $mt->result2) {
            Matches::where('id_team_match', '=', $id)->update(
                [
                    'winner' => $mt->fk_Team1,
                ]);
//            $vct = tournament_team::where(('id_team_match', '=', $id)and('id_team_match', '=', $id))->first();

           $komanda1 = tournament_team::where([['fk_Tournamentid_Tournament','=',$mt->fk_Tournamentid_Tournament],['fk_Teamid_Team','=', $mt->fk_Team1]])->first();

           tournament_team::where([['fk_Tournamentid_Tournament','=',$mt->fk_Tournamentid_Tournament],['fk_Teamid_Team','=', $mt->fk_Team1]])->update(
               [
                   'victories' => ($komanda1->victories + 1),
               ]);


        } elseif ($mt->result1 < $mt->result2) {
            Matches::where('id_team_match', '=', $id)->update(
                [
                    'winner' => $mt->fk_Team2,
                ]);
            $komanda2 = tournament_team::where([['fk_Tournamentid_Tournament','=',$mt->fk_Tournamentid_Tournament],['fk_Teamid_Team','=', $mt->fk_Team2]])->first();

            tournament_team::where([['fk_Tournamentid_Tournament','=',$mt->fk_Tournamentid_Tournament],['fk_Teamid_Team','=', $mt->fk_Team2]])->update(
                [
                    'victories' => ($komanda2->victories + 1),
                ]);



        } else
            return Redirect::back()->with('warning','Rungtynės negali baigtis lygiosiomis');
        //check if matches have empty winners
        $id2 = $mt->fk_Tournamentid_Tournament;
        return $this->checkIfLast($id2);

    }
    //patikrinti ar yra paskutinis matchas
    public function checkIfLast($id2){
        $allMatches = Matches::where('fk_Tournamentid_Tournament','=',$id2)->get();

        $cn =0;
        foreach ($allMatches as $mat){
            if($mat->winner == null ){
                $cn=$cn+1;
            }
        }
        if($cn==0){
//            Tournament::where('id_Tournament', '=', $id2)->update(
//                [
//                    'state'=> 1,//finished
//                ]);
//
//            Team::where('id_Team', '=', $komandos->fk_Teamid_Team)->update(
//                [
//
//                    'WonTournaments' => ($komandos->WonTournaments + 1),
//                ]);
            return $this->checkIfTie($id2);

//            return Redirect::back()->with('success','Turnyras baigtas');
        }
        else
            return Redirect::back()->with('success','Rezultatas išsaugotas');
    }
    public function checkIfTie($id2){

            //patikrinti ar yra lygiosios tarp komandu
        $teams = tournament_team::where('fk_Tournamentid_Tournament','=', $id2)->orderBy('victories', 'desc')->take(3)->get();
        $winner= tournament_team::where('fk_Tournamentid_Tournament','=',$id2)->orderby('victories','desc')->first();
        $tmp=0;
        for($i=0;$i<3-1;$i++){
            for($y=$i+1;$y<3;$y++){
// cia tikrinti ar komandose nezaidzia tas pats asmuo


                if ($teams[$i]->victories==$teams[$y]->victories){
                    $newMatch= new Matches();
                    $newMatch->fk_Tournamentid_Tournament= $id2;
                    $newMatch->fk_Team1=$teams[$i]->fk_Teamid_Team;
                    $newMatch->fk_Team2=$teams[$y]->fk_Teamid_Team;

                    $newMatch->save();
                    $tmp++;
                }

            }
        }
        if($tmp==0){
            Tournament::where('id_Tournament', '=', $id2)->update(
                [
                    'state'=> 1,//finished
                ]);

            Team::where('id_Team', '=', $winner->fk_Teamid_Team)->update(
                [

                    'WonTournaments' => $winner->WonTournaments + 1,
                ]);

            return Redirect::back()->with('success','Turnyras baigtas');
        }
        else{
            return Redirect::back()->with('success','Sukurtos papildomos rungtynės');
        }


    }
}
