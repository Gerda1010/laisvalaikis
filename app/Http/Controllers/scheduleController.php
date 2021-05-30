<?php

namespace App\Http\Controllers;

use App\Models\Matches;
use App\Models\Objects;
use App\Models\Reservation;
use App\Models\Tournament;
use App\Models\UserMatch;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use App\Models\DateTime;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class scheduleController extends Controller
{
    public function index()
    {
        $mytime = Carbon::now()->format('Y-m-d');
//        $mytime = $request->input('somedate');
//        $datepicker = Carbon::now()->subDays(7)->format('Y-m-d')->first();
//        $mytime->toFormattedDateString();
//        $range = $this->hoursRange(28800,64800,60*30,'h:i a');
        $allObjects = Objects::all();
        $times = $this->get_hours_range();
        $tourn = Tournament::all();
        $allReservations = Reservation::where('reservation_Date','=',$mytime)->get();
        return view('schedule', compact('times', 'allObjects','mytime', 'tourn','allReservations'));
    }
    public function byDate(Request $request){

        $mytime = $request->input('somedate');

        $allObjects = Objects::all();
        $times = $this->get_hours_range();
        $allReservations = Reservation::where('reservation_Date','=',$mytime)->get();
        $tourn = Tournament::all();
        return view('schedule', compact('times', 'allObjects','mytime','tourn', 'allReservations'));
    }
    public function byDateGuest(Request $request){
        $mytime = $request->input('somedate');

        $allObjects = Objects::all();
        $times = $this->get_hours_range();
        $tourn = Tournament::all();
        $allReservations = Reservation::where('reservation_Date','=',$mytime)->get();
        return view('welcome', compact('times', 'allObjects','mytime','tourn', 'allReservations'));

    }

    public function get_hours_range( $start = 28800, $end = 64800, $step = 1200, $format = '' ) {
        $times = array();
        foreach ( range( $start, $end, $step ) as $timestamp ) {
            $hour_mins = gmdate( 'H:i:s', $timestamp );
            if ( ! empty( $format ) )
                $times[$hour_mins] = gmdate( $format, $timestamp );
            else $times[$hour_mins] = $hour_mins;
        }
        return $times;
    }
    public function makeReservation(Request $request, $time, $obj, $mytime){

            $newReservation = new Reservation();

            $newReservation->fk_Userid_User = Auth::user()->id;
            $newReservation->fk_Objectid_Object = $obj;
            $newReservation->time = $time;
            $newReservation->reservation_Date = $mytime;
            $newReservation->save();

        return Redirect::back()->with('success', 'Laisvalaikio zona užrezervuota!');

    }
    public function tournamentReservation(Request $request, $id){

        $allTourn = Tournament::join('game','tournament.fk_Gameid_Game','=','game.id_Game')
            ->select('*')
            ->where('id_Tournament','=', $id)
            ->first();

        $mtCount = Matches::where('fk_Tournamentid_Tournament','=',$id)->count();
        $usCount = UserMatch::where('fk_Tournamentid_Tournament','=',$id)->count();

        $validator = Validator::make(
            [
                'time' =>$request->input('time'),
            ],
            [
                'time' =>'required',
            ]
        );
        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        else
        {
            $time = $request->input('time');
            $tmp =0;
            if($allTourn->NumberOfMembers == 1){

                for($i=0;$i < $usCount;$i++){

                    $res = Reservation::where('time','=', $time)
                        ->where('fk_Objectid_Object','=',$allTourn->fk_Objectid_Object)
                        ->where('reservation_Date','=',$allTourn->StartDate)
                        ->first();
                    if($res != null){

                        $time = Carbon::parse($time)
                            ->addSeconds(1200)
                            ->format('G:i:s');
                        $tmp++;
                        $usCount++;
                    }
                    else{
                        $newReservation = new Reservation();
                        $newReservation->reservation_Date = $allTourn->StartDate;
                        $newReservation->fk_Objectid_Object = $allTourn->fk_Objectid_Object;
                        $newReservation->time = $time;
                        $newReservation->fk_Tournament = $allTourn->id_Tournament;
                        $newReservation->save();
                        $time = Carbon::parse($time)
                            ->addSeconds(1200)
                            ->format('G:i:s');
                    }
                }
            }
                else {
                    for($i=0;$i < $mtCount;$i++){
                        $res = Reservation::where('time','=', $time)
                            ->where('fk_Objectid_Object','=',$allTourn->fk_Objectid_Object)
                            ->where('reservation_Date','=',$allTourn->StartDate)
                            ->first();
                        if($res != null) {

                            $time = Carbon::parse($time)
                                ->addSeconds(1200)
                                ->format('G:i:s');
                            $tmp++;
                            $mtCount++;
                        }
                        else{
                            $newReservation = new Reservation();
                            $newReservation->reservation_Date = $allTourn->StartDate;
                            $newReservation->fk_Objectid_Object = $allTourn->fk_Objectid_Object;
                            $newReservation->time = $time;
                            $newReservation->fk_Tournament = $allTourn->id_Tournament;
                            $newReservation->save();
                            $time = Carbon::parse($time)
                                ->addSeconds(1200)
                                ->format('G:i:s');

                        }
                    }
                }
            }
        if($tmp != 0){
            return Redirect::back()->with('success', 'Laisvalaikio zonos užrezervuotos. Kai kurie laikai buvo užrezervuoti anksčiau, tikslesnį tvarkaraštį peržiūrėkite tvarkaraščio puslapyje.');
        }
        else
             return Redirect::back()->with('success', 'Laisvalaikio zonos užrezervuotos!');


    }
    public function tournamentReservationTest(Request $request, $id){

        $turnyras = Tournament::join('game','tournament.fk_Gameid_Game','=','game.id_Game')
            ->select('*')
            ->where('id_Tournament','=', $id)
            ->first();

        $validator = Validator::make(
            [
                'time' => strtotime($request->input('time')),
                'endtime' => strtotime($request->input('endtime'))
            ],
            [
                'time' =>'required',
                'endtime' => 'required|gt:time'
            ]
        );
        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        else{

//            $starttime = strtotime($request->input('time'));
//            $endtime = strtotime($request->input('endtime'));

            $starttime = $request->input('time');
            $endtime = $request->input('endtime');
            $tmp = 0;

            while($starttime <= $endtime){
                $res = Reservation::where('time','=', $starttime)
                    ->where('fk_Objectid_Object','=',$turnyras->fk_Objectid_Object)
                    ->where('reservation_Date','=',$turnyras->StartDate)
                    ->first();
                if($res == null){

                    $newReservation = new Reservation();
                    $newReservation->reservation_Date = $turnyras->StartDate;
                    $newReservation->fk_Objectid_Object = $turnyras->fk_Objectid_Object;
                    $newReservation->time = Carbon::parse($starttime)->format('G:i:s');
                    $newReservation->fk_Tournament = $turnyras->id_Tournament;
                    $newReservation->save();
                    $starttime = Carbon::parse($starttime)
                        ->addSeconds(1200)
                        ->format('G:i');
                }
                else {
//                    $array[] = date ("G:i",$starttime);
                    $starttime = Carbon::parse($starttime)
                        ->addSeconds(1200)
                        ->format('G:i');
                    $tmp++;
                    $endtime =Carbon::parse($endtime)
                        ->addSeconds(1200)
                        ->format('G:i');

                }
            }
            }
        if($tmp == 0)
        return Redirect::back()->with('success', 'Laisvalaikio zonos užrezervuotos!');
        else
            return Redirect::back()->with('success', 'Laisvalaikio zonos užrezervuotos. Kai kurie laikai buvo užrezervuoti anksčiau, tikslesnį tvarkaraštį peržiūrėkite tvarkaraščio puslapyje.');
    }
    public function cancelTournamentReservation($id){
        $trRes = Reservation::where('fk_Tournament','=',$id)->get();

        foreach ($trRes as $rr){
            Reservation::where('fk_Tournament','=',$rr->fk_Tournament)->delete();
        }
        return Redirect::back()->with('success', 'Rezervacijos pašalintos');
    }

}
