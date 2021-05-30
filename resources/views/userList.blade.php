@extends('layouts.test2')
@section('content')

@if(Auth::user()->is_admin)

    <div class="row justify-content-center" style="margin-top:35px;margin-right: 70px;  margin-left: 20px; alignment: center">
        <div class="col-lg-8 offset-lg-1" style="background-color: ghostwhite;border-radius: 20px;margin-left: 10px;">
            <br>
            <a href="{{action('adminUsersController@addUser')}}" id="button1" class="btn btn-dark" style="width: 150px; margin-left: 5px;margin-right: 5px">
                Pridėti naudotoją </a>
            <br>
            <table id="list1" class="table table-hover table-condensed" >
                <thead>
                <tr>
                    <th style="width:15%;border-bottom: 10px;">ID</th>
                    <th style="width:20%;border-bottom: 10px;">Vardas</th>
                    <th style="width:30%;border-bottom: 10px;">El. paštas</th>
                    <th style="width:5%"></th>
                    <th style="width:5%"></th>

                </tr>
                </thead>
                <tbody>
                @foreach($allUsers as $asUser)
                    <tr>
                        <td>{{ $asUser->id }}</td>
                        <td>{{ $asUser->name }}</td>
                        <td>{{ $asUser->email }}</td>

                        <td><a href="{{ route('editUser', $asUser->id)}}">  <i class="fa fa-pencil" style="font-size:20px; color:darkslategrey"  aria-hidden="true"></i></a></td>

                        <td><a onclick="return confirm('Do you really want to delete this user?')" href="{{ route('deleteUser', $asUser->id)}}">  <i class="fa fa-trash-o" style="font-size:20px; color:darkslategrey"  aria-hidden="true"></i></a></td>




                    </tr>
                @endforeach
                </tbody>
            </table>
            {{$allUsers->appends(request()->input())->links()}}
        </div>
    </div>
@else <h1>you dont have access</h1>
    @endif
@endsection
