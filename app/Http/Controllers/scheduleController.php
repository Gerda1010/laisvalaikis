<?php

namespace App\Http\Controllers;

use App\Models\Matches;
use App\Models\Objects;
use App\Models\Reservation;
use App\Models\Tournament;
use App\Models\UserMatch;
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
        $allReservations = Reservation::where('reservation_Date','=',$mytime)->get();
        return view('schedule', compact('times', 'allObjects','mytime', 'allReservations'));
    }
    public function byDate(Request $request){

        $mytime = $request->input('somedate');

        $allObjects = Objects::all();
        $times = $this->get_hours_range();
        $allReservations = Reservation::where('reservation_Date','=',$mytime)->get();
        return view('schedule', compact('times', 'allObjects','mytime', 'allReservations'));
    }
    public function byDateGuest(Request $request){
        $mytime = $request->input('somedate');

        $allObjects = Objects::all();
        $times = $this->get_hours_range();
        $allReservations = Reservation::where('reservation_Date','=',$mytime)->get();
        return view('welcome', compact('times', 'allObjects','mytime', 'allReservations'));

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

}
