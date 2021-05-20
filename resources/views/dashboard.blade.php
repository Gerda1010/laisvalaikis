@extends('layouts.test2')

@section('content')
    <br>
    <div class="grid-container" style="font-size: 16px">
        <div class="itemT">
       <br>
        <label>
            <h3>Turnyrai</h3>
        </label>

            <table id="table" class="table table-hover table-condensed" >
                <thead>
                <tr>
                    <th style="width:20%;border-bottom: 10px;">Pavadinimas</th>
                    <th style="width:20%;border-bottom: 10px;">Žaidimas</th>

                    <th style="width:30%;border-bottom: 10px;">Būsena</th>
                </tr>
                </thead>
                <tbody>
                @foreach($allTourn as $asTr)
                    <tr>
                        <td><a style="color: #1a202c" href="{{ action('tournamentsController@openTournament', $asTr->id_Tournament)}}">{{ $asTr->Name }}</a></td>

                        @foreach($allGames as $gme)
                            @if($gme->id_Game === $asTr->fk_Gameid_Game)
                                <td>{{ $gme->Name }}</td>
                            @endif
                        @endforeach



                        @foreach($allStates as $stt)
                            @if($stt->id_State === $asTr->State)
                                <td>{{ $stt->name }}</td>

                            @endif
                        @endforeach

                    </tr></a>
                @endforeach
                </tbody>
            </table>
            {{--            {{$allTourn->appends(request()->input())->links()}}--}}

    </div>
        <div class="itemT" style="background-color: ghostwhite;border-radius: 20px; margin:0 auto; height: 500px;overflow: auto;">

            <h5 style="text-align: center; ">{{$mytime}}</h5>
            <br>
            <table class="table" style="width: 95%; margin:0 auto;">
                <colgroup>
                    <col span="1" style="width: 20%;">
                    <col span="1" style="width: 20%;">
                    <col span="1" style="width: 20%;">
                    <col span="1" style="width: 20%;">
                </colgroup>

                <thead>
                <th class="col" style="width: 20%; text-align: center"; > Laikas</th>
                @foreach($allObjects as $obj)
                    <th class="col" style=" text-align: center;width: 20%;">{{$obj->Name}}</th>

                @endforeach
                </thead>

                <tbody>
                @foreach($times as $time)
                    <tr>
                        <td style="width: 20%">
                            <p>{{$time}}</p>
                        </td>
                        @foreach($allObjects as $obj)
                            @if(count($allReservations)===0)
                                <td style="background-color: seagreen; color: white">Laisva</td>
                            @else
                                @foreach($allReservations as $res)

                                    @if(($res->time===$time)&&($res->fk_Objectid_Object===$obj->id_Object))
                                        <td style="background-color: darkred; color: white">Užimta</td>
                                    @else
                                        <td style="background-color: seagreen; color: white">Laisva</td>

                                    @endif
                                    @break

                                @endforeach
                            @endif

                        @endforeach

                    </tr>
                @endforeach


                </tbody>
            </table>
        </div>


    </div>
    </div>
@endsection
