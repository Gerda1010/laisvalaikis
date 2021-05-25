@extends('layouts.test2')

@section('content')
    <br>
    <div class="grid-container" style="width: 100%">

            <div class="item11">
                <label>
                    <h3 class="title">Naudotojo informacija</h3>
                </label>
                <br>

                <div align="left" style="font-size: 1rem;font-weight: bolder">
                    <table class= "table table-hover " style="width: 100%" >
                        <colgroup>
                            <col span="1" style="width: 60%;">
                            <col span="1" style="width: 40%;">
                        </colgroup>

                        <tbody>
                        <tr>
                            <td style="width: 60%;">Vartotojo vardas</td>

                            <td style="width: 40%;" >{{Auth::user()->name}}</td>

                        </tr>
                        <tr>
                            <td style="width: 60%;">El. paštas</td>

                            <td style="width: 40%;" >{{Auth::user()->email}}</td>

                        </tr>
                        </tbody>

                    </table>
                </div>

                <a href="{{action('profileController@changePassword')}}" id="button1" class="btn btn-dark" style="width: 150px; margin-left: 5px;margin-right: 5px">
                    Keisti slaptažodį </a>

            </div>

            <div class="item22" >
                <label>
                    <h3 class="title">Komandos</h3>
                </label>

                <table class= "table table-hover " style="width: 100%" >
                    <tbody>

                    @foreach($userTeams as $usTm)
                        @foreach($allTeams as $team)
                            @if($usTm->fk_Teamid_Team ===$team->id_Team)
                               <tr>
                                   <td>
                                     {{$team->Name}}
                                   </td>
                               </tr>

                            @endif
                        @endforeach
                    @endforeach

                    </tbody>

                </table>

            </div>

                <div class="item33">
                    <label>
                        <h3 class="title">Rezervacijos</h3>
                    </label>
                <table class= "table table-hover " style="width: 100%" >
                    <colgroup>
                        <col span="1" style="width: 40%;">
                        <col span="1" style="width: 20%;">
                        <col span="1" style="width: 20%;">
                        <col span="1" style="width: 20%;">
                    </colgroup>
                    <thead>
                    <th style="width: 40%;">Objektas</th>
                    <th style="width: 30%;">Data</th>
                    <th style="width: 30%;">Laikas</th>
                    <td  style="width: 20%;"> </td>
                    </thead>
                    <tbody>
                    @foreach($userReservations as $usRe)

                        <tr>
                            @foreach($allObjects as $obj)
                                @if($usRe->fk_Objectid_Object === $obj->id_Object)
                                    <td style="width: 40%;">{{$obj->Name}}</td>
                                @endif

                            @endforeach
                            <td style="width: 30%;" >{{$usRe->reservation_Date}}</td>
                            <td style="width: 30%;" >{{$usRe->time}}</td>
{{--                            <td  style="width: 20%;"> Atsaukti</td>--}}
                                <td style="width: 20%;"><a onclick="return confirm('Ar tikrai norite atšaukti rezervaciją?')" href="{{ route('cancelReservation', $usRe->id_Reservation)}}">  <i class="fa fa-trash-o" style="font-size:20px; color:darkslategrey"  aria-hidden="true"></i></a></td>


                        </tr>

                    @endforeach
                    </tbody>

                </table>

                </div>
    </div>
@endsection
