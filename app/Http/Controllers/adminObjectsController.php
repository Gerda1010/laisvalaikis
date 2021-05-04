<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\event_log;
use App\Models\Matches;
use App\Models\Obtained;
use App\Models\Tournament;
use App\Models\tournament_team;
use App\Models\user_team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\Objects;
use App\Models\Game;

class adminObjectsController extends Controller
{
    public function index()
    {
        $allObjects = Objects::all();
        $allObjects = Objects::paginate(10);
        $allGames = Game::all();
        $allGames = Game::paginate(10);
        $allObtained = Obtained::all();

        return view('objectList', compact('allObjects','allGames','allObtained'));
    }
    //Object management
    public function confirmEditedObject(Request $request, $id)
    {
        $validator = Validator::make(
            [
                'Name'=> $request->input('Name'),
                'Obtain'=> $request->input('Obtain')
            ],
            [
                'Name'=> 'required|max:50',
                'Obtain'=> 'required'
            ]
        );

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator, 'error message');
        }
        else
        {
            $data = Objects::where('id_Object', '=', $id)->update(
                [
                    'Name'=> $request->input('Name'),
                    'Obtain'=> $request->input('Obtain')
                ]
            );
        }
        return Redirect::to('/objectList')->with('success', 'Objektas redaguotas');
    }
 public function editObject($id)
    {
        //$Obtained = Obtained::all();
        $selectedObject = Objects::where('id_Object','=',$id)
            ->select('Objects.*')
            ->first();
        $Obtained = Obtained::all();

        return view('editObject', compact('selectedObject', 'Obtained'));
    }

    public function deleteObject($id)
    {
        $games=Game::where('fk_Objectid_Object','=',$id)->get(); //objekto zaidimai
        $comments = Comment::all();
        $tourn_teams = tournament_team::all();
        $logai = event_log::all();
        $tournaments = Tournament::all();
        $matchai = Matches::all();
//        $tournaments = Tournament::where('fk_Gameid_Game','=',)
//        $games=Game::where('fk_Objectid_Object','=',$id)->get();

//        foreach ($tournaments as $tourn) {

        //pasalina komentarus
         foreach ($games as $gme){
           $turnyrai=  Tournament::where('fk_Gameid_Game','=',$gme->id_Game)->get();
           foreach ($turnyrai as $tr){
               foreach ($comments as $cmt){
                   Comment::where('fk_Tournamentid_Tournament', '=', $tr->id_Tournament)->delete();
               }
           }
         }
         //pasalina turnyro komandas
        foreach ($games as $gme){
            $turnyrai = Tournament::where('fk_Gameid_Game','=',$gme->id_Game)->get();
            foreach ($turnyrai as $tr){
                foreach ($tourn_teams as $usTm){
                    tournament_team::where('fk_Tournamentid_Tournament', '=', $tr->id_Tournament)->delete();
                }
            }
        }
        //pasalina logus
        foreach ($games as $gme){
            $turnyrai = Tournament::where('fk_Gameid_Game','=',$gme->id_Game)->get();
            foreach ($turnyrai as $tr){
                foreach ($logai as $logg){
                    event_log::where('fk_Tournament', '=', $tr->id_Tournament)->delete();
                }
            }
        }


        //pasalinti matchus
        foreach ($games as $gme){
            $turnyrai = Tournament::where('fk_Gameid_Game','=',$gme->id_Game)->get();
            foreach ($turnyrai as $tr){
                foreach ($matchai as $mt){
                    Matches::where('fk_Tournamentid_Tournament', '=', $tr->id_Tournament)->delete();
                }
            }
        }

        //Pasalina turnyrus
        foreach ($games as $gme){
            foreach ($tournaments as $trn){
                Tournament::where('fk_Gameid_Game','=',$gme->id_Game)->delete();
            }
        }
        //pasalina zaidimus
        foreach ($games as $game) {
            Game::where('id_Game','=',$game->id_Game)->delete();
        }
        //pasalina objekta
        Objects::where('id_Object','=',$id)->delete();
        return Redirect::to('/objectList')->with('Objektas pašalintas');
    }
    public function insertObject(Request $request)
    {
        $validator = Validator::make(
            [   'Name' =>$request->input('Name'),
                'Obtain' =>$request->input('Obtain')
            ],
            [
                'Name' =>'required|max:50',
                'Obtain' =>'required'
            ]
        );

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        else
        {
            $newObject = new Objects();
            $newObject->Name = $request->input('Name');
            $newObject->Obtain = $request->input('Obtain');

            $newObject->save();

        }
        return Redirect::to('/objectList')->with('success', 'Objektas pridėtas');
    }
    public function addObject()
    {
        $Obtained = Obtained::all();
        return view('addObject', compact('Obtained'));
    }


    public function deleteGame($id)
    {
        $turnyrai = Tournament::where('fk_Gameid_game', '=', $id)->get();

        //pasalina komentarus
        foreach ($turnyrai as $tr){
            $comments=  Comment::where('fk_Tournamentid_Tournament','=',$tr->id_Tournament)->get();
                foreach ($comments as $cmt){
                    Comment::where('fk_Tournamentid_Tournament', '=', $tr->id_Tournament)->delete();
                }
            }

        //pasalina turnyro komandas

            foreach ($turnyrai as $tr){
                $tourn_teams = tournament_team::where('fk_Tournamentid_Tournament','=', $tr->id_Tournament);
                foreach ($tourn_teams as $usTm){
                    tournament_team::where('fk_Tournamentid_Tournament', '=', $tr->id_Tournament)->delete();
                }
            }

        //pasalina logus


            foreach ($turnyrai as $tr){
                $logai=  event_log::where('fk_Tournament','=',$tr->id_Tournament)->get();
                foreach ($logai as $logg){
                    event_log::where('fk_Tournament', '=', $tr->id_Tournament)->delete();
                }
            }


        //pasalinti matchus

            foreach ($turnyrai as $tr){
                $matchai=  Matches::where('fk_Tournamentid_Tournament','=',$tr->id_Tournament)->get();
                foreach ($matchai as $mt){
                    Matches::where('fk_Tournamentid_Tournament', '=', $tr->id_Tournament)->delete();
                }
            }

        //Pasalina turnyrus
        foreach ($turnyrai as $tr){
                Tournament::where('fk_Gameid_Game','=',$id)->delete();
            }

        Game::where('id_Game','=',$id)->delete();
        return Redirect::to('/objectList')->with('Žaidimas pašalintas');
    }
    public function insertGame(Request $request)
    {
        $validator = Validator::make(
            [   'Name' =>$request->input('Name'),
                'NumberOfMembers' =>$request->input('NumberOfMembers'),
                'fk_Objectid_Object' => $request->input('fk_Objectid_Object')
            ],
            [
                'Name' =>'required|max:50',
                'NumberOfMembers' =>'required',
                'fk_Objectid_Object' => 'required'
            ]
        );

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        else
        {
            $newGame = new Game();
            $newGame->Name = $request->input('Name');
            $newGame->NumberOfMembers = $request->input('NumberOfMembers');
            $newGame->fk_Objectid_Object = $request->input('fk_Objectid_Object');

            $newGame->save();

        }
        return Redirect::to('/objectList')->with('success', 'Žaidimas pridėtas');
    }
    public function addGame()
    {
        $allObjects = Objects::all();
        return view('addGame', compact('allObjects'));
    }

}
