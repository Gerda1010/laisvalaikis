<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\User;
use App\Models\user_team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class adminUsersController extends Controller
{
   /** public function index()
    {
        return view('userList');
    }*/

    public function index()
{
    $allUsers = User::all();
    $allUsers = User::paginate(10);
    return view('userList', compact('allUsers'));
}
    public function confirmEditedUser(Request $request, $id)
    {
        $validator = Validator::make(
            [
                'name'=> $request->input('name'),
                'email'=> $request->input('email')
            ],
            [
                'name'=> 'required|max:50',
                'email'=> 'required|unique:users'
            ]
        );

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator, 'error message');
        }
        else
        {
            $data = User::where('id', '=', $id)->update(
                [
                    'name'=> $request->input('name'),
                    'email'=> $request->input('email'),
                    'is_admin' => $request->input('is_admin')
                ]
            );
        }
        return Redirect::to('/userList')->with('success', 'Naudotojas redaguotas');
    }
    public function editUser($id)
    {
        //$Obtained = Obtained::all();
        $selectedUser = User::where('id','=',$id)
            ->select('users.*')
            ->first();

        return view('editUser', compact('selectedUser'));
    }

    public function deleteUser($id)
    {
       $userTeams=user_team::where('fk_Userid_User','=',$id)->get();

//        $userTeams=user_team::all();
        foreach ($userTeams as $usTm) {
            user_team::where('fk_Userid_User','=',$id)->delete();
        }
        $userReservations=Reservation::where('fk_Userid_User','=',$id)->get();
        foreach ($userReservations as $usRes) {
            Reservation::where('fk_Userid_User','=',$id)->delete();
        }

        User::where('id','=',$id)->delete();
        return Redirect::to('/userList')->with('Naudotojas pašalintas');
    }
    public function insertUser(Request $request)
    {
        $validator = Validator::make(
            [   'name' =>$request->input('name'),
                'email' =>$request->input('email'),



            ],
            [
                'name' =>'required|max:255',
                'email' =>'required|email',

            ]
        );

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        else
        {
            $newUser = new User();
            $newUser->name = $request->input('name');
            $newUser->email = $request->input('email');
            $newUser->password = 'default123';
            $newUser->save();

        }
        return Redirect::to('/userList')->with('success', 'Naudotojas pridėtas');
    }
    public function addUser()
    {
        $Users = User::all();
        return view('addUser');
    }


}
