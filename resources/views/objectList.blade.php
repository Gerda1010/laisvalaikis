@extends('layouts.test2')
@section('content')

    @if(Auth::user()->is_admin)

<div>
    <br>
</div>
<div class="container" style="margin-left: 100px;margin-right: 70px">
        <div class="row" >
            <div class="col-md-5" style="background-color: ghostwhite;border-radius: 20px">
                <br>
                <a href="{{action('adminObjectsController@addObject')}}" id="button1" class="btn btn-dark" style="width: 135px; margin-left: 5px">
                    Pridėti objektą </a>
                <br>
                <table id="list1" class="table table-hover table-condensed" style="margin-right: 5px" >
                    <thead>
                    <tr>
                        <th style="width:5%;border-bottom: 10px;">ID</th>
                        <th style="width:35%;border-bottom: 10px;">Pavadinimas</th>
                        <th style="width:35%;border-bottom: 10px;">Įsigijimas</th>
                        <th style="width:5%"></th>
                        <th style="width:5%"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($allObjects as $asObject)
                        <tr>
                            <td>{{ $asObject->id_Object }}</td>
                            <td>{{ $asObject->Name }}</td>

                            @foreach($allObtained as $obt)
                                @if($obt->id_Obtained === $asObject->Obtain)
                                    <td>{{ $obt->name }}</td>

                                @endif
                            @endforeach

                           <td><a href="{{ route('editObject', $asObject->id_Object)}}">  <i class="fa fa-pencil" style="font-size:20px; color:darkslategrey"  aria-hidden="true"></i></a></td>

                            <td><a onclick="return confirm('Ar tikrai norite pašalinti?')" href="{{ route('deleteObject', $asObject->id_Object)}}">  <i class="fa fa-trash-o" style="font-size:20px; color:darkslategrey"  aria-hidden="true"></i></a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{$allObjects->appends(request()->input())->links()}}
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-5 .offset-md-7" style="background-color: ghostwhite;border-radius: 20px ">  <br>
                <a href="{{action('adminObjectsController@addGame')}}" id="button1" class="btn btn-primary" style="width: 135px; margin-left: 5px">
                    Pridėti žaidimą </a>
                <br>
                <table id="list1" class="table table-hover table-condensed" >
                    <thead>
                    <tr>
                        <th style="width:5%;border-bottom: 10px;">ID</th>
                        <th style="width:35%;border-bottom: 10px;">Pavadinimas</th>
                        <th style="width:30%;border-bottom: 10px;">Objektas</th>
                        <th style="width:35%">Narių skaičius</th>
                        <th style="width:5%"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($allGames as $asGame)
                        <tr>
                            <td>{{ $asGame->id_Game }}</td>
                            <td>{{ $asGame->Name }}</td>


                            @foreach($allObjects as $asObject)
                                @if($asObject->id_Object === $asGame->fk_Objectid_Object)
                                    <td>{{ $asObject->Name }}</td>
                                @endif
                            @endforeach

                            <td>{{ $asGame->NumberOfMembers }}</td>
{{--                            <td>{{ $asGame->fk_Objectid_Object }}</td>--}}

{{--                            <td width="50"><a onclick="return confirm('Do you really want to delete this user?')" href="{{route('deleteObject', $asObject->id_Object)}}"><button class="button" type="delete"><svg class="bi bi-x-square-fill" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">--}}
{{--                                            <path fill-rule="evenodd" d="M2 0a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V2a2 2 0 00-2-2H2zm9.854 4.854a.5.5 0 00-.708-.708L8 7.293 4.854 4.146a.5.5 0 10-.708.708L7.293 8l-3.147 3.146a.5.5 0 00.708.708L8 8.707l3.146 3.147a.5.5 0 00.708-.708L8.707 8l3.147-3.146z" clip-rule="evenodd"/>--}}
{{--                                        </svg></button></a></td>--}}
                            <td><a onclick="return confirm('Do you really want to delete this game?')" href="{{route('deleteGame', $asGame->id_Game)}}">  <i class="fa fa-trash-o" style="font-size:20px; color:darkslategrey"  aria-hidden="true"></i></a></td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{$allObjects->appends(request()->input())->links()}}
            </div>
        </div>
</div>
    @else <h1>you dont have access</h1>
    @endif
@endsection

