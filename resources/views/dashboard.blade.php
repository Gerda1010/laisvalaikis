@extends('layouts.test2')

@section('content')
    <br>
    <div class="grid-container3" style="font-size: 16px">
        <div class="itemT"  style="background-color: ghostwhite;border-radius: 20px; margin:0 auto;width: 80%;height: 700px;overflow: auto;text-align:center">
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
        <div class="itemT" style="background-color: ghostwhite;border-radius: 20px; margin:0 auto;width: 80%;height: 700px;overflow: auto;text-align:center">
            <br>

            <form method="post" action="{{action('scheduleController@byDate')}}">
                @csrf
                <input style="margin: auto;" name="somedate" type="date" value="{{$mytime}}" onchange="this.form.submit()"  min="{{now()->format('Y-m-d')}}" max="{{ now()->addDays(15)->format('Y-m-d') }}" >

            </form>

            <br>
            <table class="table" style="width: 95%; margin:0 auto;">
                <colgroup>
                    <col span="1" style="width: 10%;">
                    <col span="1" style="width: 30%;">
                    <col span="1" style="width: 30%;">
                    <col span="1" style="width: 30%;">
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
                        <td style="width: 10%">
                            <p>{{\Carbon\Carbon::parse($time)->format('G:i')}}</p>
                        </td>

                        @foreach($allObjects as $obj)
                            @php
                                $val = 0
                            @endphp
                            @foreach($allReservations as $res)
                                @if(($res->time===$time)&&($res->fk_Objectid_Object===$obj->id_Object))
                                    @if($res->fk_Tournament == null)
                                        <td style="background-color: darkred; color: white;width: 30%">Užimta</td>
                                    @else
                                        @foreach($tourn as $tr)
                                            @if($res->fk_Tournament==$tr->id_Tournament)
                                                <td style="background-color: rebeccapurple; color: white;width: 30%">{{$tr->Name}}</td>
                                            @endif
                                        @endforeach
                                    @endif
                                    @php
                                        $val = 1
                                    @endphp
                                    @break
                                @else

                                    @continue

                                @endif
                            @endforeach
                            @if($val != 1)
                                <td style="background-color: seagreen; color: white;width: 30%">

                                    <a style="height: 50px;padding: 0" onclick="return confirm('Patvirtinkite rezervaciją')" href="{{action('scheduleController@makeReservation',['time'=> $time, 'obj'=>$obj->id_Object, 'mytime'=>$mytime ])}}">
                                        Laisva
                                    </a>
                                </td>
                            @endif
                        @endforeach


                    </tr>
                @endforeach


                </tbody>
            </table>
        </div>
    </div>
@endsection
