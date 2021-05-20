<?php

namespace App\Http\Controllers;

use App\Models\Objects;
use App\Models\Reservation;
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
//    public function hoursRange( $lower = 0, $upper = 86400, $step = 3600, $format = '' ) {
//        $times = array();
//
//        if ( empty( $format ) ) {
//            $format = 'g:i a';
//        }
//
//        foreach ( range( $lower, $upper, $step ) as $increment ) {
//            $increment = gmdate( 'H:i', $increment );
//
//            list( $hour, $minutes ) = explode( ':', $increment );
//
//            $date = new DateTime( $hour . ':' . $minutes );
//
//            $times[(string) $increment] = $date->format( $format );
//        }
//
//        return $times;
//    }
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
    public function makeReservation(Request $request, $time, $obj,$mytime){

//        $validator = Validator::make(
//            [
//                'fk_Objectid_Object' =>$request->input('fk_Objectid_Object'),
//                'time'=>$request->input('time'),
//                'date'=>$request->input('date')
//
//            ],
//            [
//                'fk_Objectid_Object' => 'required',
//                'time' => 'required',
//            ]
//        );
//        if ($validator->fails())
//        {
//            return Redirect::back()->withErrors($validator);
//        }
//        else
//        {
//            $newReservation = new Reservation();
//            $newReservation->reservation_Date = Carbon::now()->format('Y-m-d');
//            $newReservation->fk_Userid_User = Auth::user()->id;
//
//            $newReservation->fk_Objectid_Object = $request->input('fk_Objectid_Object');
//            $newReservation->time = $request->input('time');
//            $newReservation->reservation_Date = $request->input('date');;
//            $newReservation->save();
//        }

        $newReservation = new Reservation();
            $newReservation->reservation_Date = $mytime;
            $newReservation->fk_Userid_User = Auth::user()->id;

            $newReservation->fk_Objectid_Object = $obj;
            $newReservation->time = $time;

            $newReservation->save();


        return Redirect::back()->with('success', 'Laisvalaikio zona užrezervuota!');




    }
}
