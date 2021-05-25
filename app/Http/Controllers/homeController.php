<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Objects;
use App\Models\Reservation;
use App\Models\State;
use App\Models\Tournament;
use Illuminate\Http\Request;
use App\Models\DateTime;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class homeController extends Controller
{
    public function index()
    {
        $mytime = Carbon::now()->format('Y-m-d');
//        $mytime->toFormattedDateString();
//        $range = $this->hoursRange(28800,64800,60*30,'h:i a');
        $allObjects = Objects::all();
        $times = $this->get_hours_range();
        $allReservations = Reservation::where('reservation_Date','=',$mytime)->get();


        $allTourn = Tournament::where('State','=',6)->orWhere('State','=', 5)->get();
        $allGames = Game::all();
        $allStates = State::all();

        return view('dashboard', compact('times', 'allObjects','mytime', 'allReservations', 'allTourn', 'allGames', 'allStates'));
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
    public function guest(){

        $mytime = Carbon::now()->format('Y-m-d');
//        $mytime->toFormattedDateString();
//        $range = $this->hoursRange(28800,64800,60*30,'h:i a');
        $allObjects = Objects::all();
        $times = $this->get_hours_range();
        $allReservations = Reservation::where('reservation_Date','=',$mytime)->get();


        $allTourn = Tournament::where('State','=',3)
            ->orWhere('State','=', 5)
            ->get();

        $allGames = Game::all();
        $allStates = State::all();

        return view('welcome', compact('allTourn', 'allGames', 'allStates','times', 'allObjects','mytime', 'allReservations'));
    }
}
