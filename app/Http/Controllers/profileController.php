<?php

namespace App\Http\Controllers;
use App\Models\Objects;
use App\Models\Reservation;
use App\Models\Team;
use App\Models\Tournament;
use App\Models\tournament_team;
use App\Models\User;
use App\Rules\MatchOldPassword;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\user_team;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;


class profileController extends Controller
{
    public function index(){
        $id = Auth::user()->id;
        $allTeams = Team::all();
        $userTeams = user_team::where('fk_Userid_User','=',$id)->get();
        $userReservations = Reservation::where('fk_Userid_User', '=', $id)->where('reservation_Date','>=',Carbon::today())->orderby('reservation_Date')->get();
        $allObjects = Objects::all();



        return view('profile',compact('userTeams','allTeams', 'userReservations', 'allObjects'));
    }
    public function cancelReservation($id){
        Reservation::where('id_Reservation','=',$id)->delete();
        return Redirect::to('/profile')->with('Rezervacija atšaukta');
    }
    public function __construct()

    {
        $this->middleware('auth');
    }

    /**

     * Show the application dashboard.

     *

     * @return \Illuminate\Contracts\Support\Renderable

     */

    public function changePassword()
    {

        return view('changePassword');

    }

    /**

     * Show the application dashboard.

     *

     * @return \Illuminate\Contracts\Support\Renderable

     */

    public function store(Request $request)
    {

        $request->validate([

            'current_password' => ['required', new MatchOldPassword],

            'new_password' => ['required'],

            'new_confirm_password' => ['same:new_password'],

        ]);

        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
        $id = Auth::user()->id;
        $allTeams = Team::all();
        $userTeams = user_team::where('fk_Userid_User','=',$id)->get();
        $userReservations = Reservation::where('fk_Userid_User', '=', $id)->get();
        $allObjects = Objects::all();

//        dd('Password change successfully.');
        return back()->with('success', 'Slaptažodis pakeistas');
//        return view('profile',compact('userTeams','allTeams', 'userReservations', 'allObjects'))->with('success', 'Slaptažodis pakeistas');

    }


}
