@extends('layouts.test2')

@section('content')

<br>
<div class="row" style="margin-left: 7px">

@if($Tournament->State===6)

        @if($maxTeams->NumberOfMembers>1)
            <button id="myBtn" onclick="document.getElementById('myModal').style.display ='block'" style="background-color: darkslategray; color: white; margin-left: 20px;border-radius: 5px; ">Užsiregistruoti</button>
        @else
{{--        <button id="singleModalbtn" onclick="document.getElementById('singleModal').style.display ='block'" style="background-color: darkslategray; color: white; margin-left: 20px;border-radius: 5px;">Užsiregistruoti</button>--}}
{{--            <button onclick="return confirm('Ar tikrai norite užsiregistruoti į turnyrą?')" action="{{ url('createTournamentUser',$Tournament->id_Tournament)}}" style="background-color: darkslategray; color: white; margin-left: 20px;border-radius: 5px;">Užsiregistruoti</button>--}}
            <form onclick="return confirm('Ar tikrai norite užsiregistruoti į turnyrą?')" action="{{ url('createTournamentUser',$Tournament->id_Tournament)}}"  method="post">
                {{ csrf_field() }}
                <input type="submit" value="Užsiregistruoti" style="background-color: darkslategray;  color: white; margin-left: 20px;border-radius: 5px; border: none; height: 35px" />
            </form>
        @endif

        @if($Tournament->fk_Organizerid_User===Auth::user()->id)
            @if($maxTeams->NumberOfMembers>1)
            <form onclick="return confirm('Ar tikrai norite pradėti turnyrą?')" action="{{ route('startTournament',$Tournament->id_Tournament)}}"  method="post">
                {{ csrf_field() }}
                <input type="submit" value="Pradėti turnyrą" style="background-color: darkslategray;  color: white; margin-left: 20px;border-radius: 5px; border: none; height: 35px" />
            </form>
            @else
                <form onclick="return confirm('Ar tikrai norite pradėti turnyrą?')" action="{{ route('startTournamentUsers',$Tournament->id_Tournament)}}"  method="post">
                    {{ csrf_field() }}
                    <input type="submit" value="Pradėti turnyrą" style="background-color: darkslategray;  color: white; margin-left: 20px;border-radius: 5px; border: none; height: 35px" />
                </form>
                @endif
        @endif
@else

        @if($maxTeams->NumberOfMembers>1)
            <button id="myBtnDis" style="background-color: dimgray; color: white; margin-left: 20px;border-radius: 5px; " disabled>Užsiregistruoti</button>
        @else
            <button id="singleModalbtnDis" disabled style="background-color: dimgray; color: white; margin-left: 20px;border-radius: 5px;">Užsiregistruoti</button>
        @endif

        <form action="{{ route('startTournament',$Tournament->id_Tournament)}}"  method="post">
            {{ csrf_field() }}
            <input type="submit" disabled value="Pradėti turnyrą" style="background-color: dimgray; color: white; margin-left: 20px;border-radius: 5px; border: none; height: 35px" />
        </form>
@endif
    <button id="logBtn" onclick="document.getElementById('logModal').style.display ='block'" style="background-color: darkslategray; color: white; margin-left: 20px;border-radius: 5px; ">Turnyro istorija</button>
    @if(($Tournament->fk_Organizerid_User===Auth::user()->id)&&($Tournament->State===5))

{{--    @if($Tournament->State===5)--}}
    <button id="singleModalbtn" onclick="document.getElementById('singleModal').style.display ='block'" style="background-color: darkslategray; color: white;border-radius: 5px;">Rezervuoti laisvalaikio zoną turnyrui</button>
    @endif
</div>
    <br>
{{--Modalas--}}
    <!-- The Modal -->
    <div id="myModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header" style="alignment: left">

                <h2 >Pasirinkite komandą</h2>
                <span class="close" id="spanId">&times;</span>
            </div>
            <form class="form-horizontal" role="form" method="POST" action="{{ url('createTournamentTeam',$Tournament->id_Tournament)}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group row">
                    <br>
                    <label class="col-md-3 col-form-label text-md-right" style="margin-left: 30px;">Komandos</label>
                    <div class="col-md-6">
                        <select class="form-control" name="fk_Teamid_Team">
                            <option value="{{ old('fk_Teamid_Team') }}" ></option>
                            @foreach($allUserTeams as $usTeam)
                            @foreach($allTeams as $tt)
                                @if($usTeam->fk_Teamid_Team===$tt->id_Team)
                                <option value="{{$usTeam->fk_Teamid_Team}}">{{$tt->Name}}</option>
                                    @endif
                            @endforeach
                            @endforeach
                        </select>
                    </div>
                </div>
               <div>
                   <button type="submit" id="buttonForm" class="btn btn-primary" style="alignment:right;">
                       Pridėti
                   </button></div>
                <br>
            </form>
        </div>
    </div>
<div id="logModal" class="modal">

    <!-- Modal content -->
    <div class="modal-content">
        <div class="modal-header" style="alignment: left">

            <h2 >Turnyro istorija</h2>
            <span class="close" id="spanId2">&times;</span>
        </div>

            <div class="form-group row">
              <table class="table">
                  <colgroup>
                      <col span="1" style="width: 40%;">
                      <col span="1" style="width: 30%;">
                      <col span="1" style="width: 30%;">
                  </colgroup>
                  <thead>

                  <th>Data</th>
                  <th></th>
                  <th>Naudotojas</th>
                  </thead>
                  <tbody>

                  @foreach($logs as $log)
                      <tr>
                          <td>{{$log->log_date}}</td>
                          <td>{{$log->log_text}} </td>
                          @foreach($allUsers as $user)
                              @if($user->id == $log->fk_Userid_User)
                          <td>{{$user->name}}</td>
                              @endif
                          @endforeach
                      </tr>
                  @endforeach
                  </tbody>
              </table>

            </div>
    </div>
</div>
<div id="singleModal" class="modal">
    <div class="modal-content" >
        <div class="modal-header" style="alignment: left">
            <h3 >Pasirinkite laiką rezervacijai</h3>
            <span class="close" id="spanId3">&times;</span>
        </div>
        <br>
        <form class="form-horizontal" role="form" method="POST" action="{{ url('tournamentReservationTest',$Tournament->id_Tournament)}}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <br>
            <label>Pasirinkite pradžios laiką</label>
            <select class="form-control" name="time">
                <option value="Nepasirinkta" ></option>
                @foreach($times as $tm)
                    @php
                        $val = 0
                    @endphp
                    @foreach($reservations as $res)

                        @if($tm === $res->time)
                          @php
                                $val = 1
                            @endphp
                            @break
                        @else
                            @continue
                        @endif

                    @endforeach
                    @if($val==0)
                        <option value="{{$tm}}">{{\Carbon\Carbon::parse($tm)->format('G:i')}}</option>
                    @else
                        <option value="{{$tm}}" style="background-color: darkred;color:white;" disabled>{{\Carbon\Carbon::parse($tm)->format('G:i')}}</option>

                    @endif
                @endforeach
            </select>
            <label>Pasirinkite pabaigos laiką</label>
            <select class="form-control" name="endtime">
                <option value="Nepasirinkta" ></option>
                @foreach($times as $tm)
                    @php
                        $val = 0
                    @endphp
                    @foreach($reservations as $res)

                        @if($tm === $res->time)
                            @php
                                $val = 1
                            @endphp
                            @break
                        @else
                            @continue
                        @endif

                    @endforeach
                    @if($val==0)
                        <option value="{{$tm}}">{{\Carbon\Carbon::parse($tm)->format('G:i')}}</option>
                    @else
                        <option value="{{$tm}}" style="background-color: darkred;color:white;" disabled>{{\Carbon\Carbon::parse($tm)->format('G:i')}}</option>

                    @endif
                @endforeach
            </select>
            <br>
            <br>
{{--            @foreach($reservations as $ress)--}}
{{--                {{$ress->time}}--}}
{{--            @endforeach--}}
            <button type="submit" style="background-color: darkslategray; color: white; margin-top:15px;margin-bottom: 15px;border-radius: 10px; margin: auto;">
                Rezervuoti
            </button>
        </form>
        <br>
        <div >
        <form onclick="return confirm('Ar tikrai norite atšaukti rezervacijas?')" action="{{ route('cancelTournamentReservation',$Tournament->id_Tournament)}}"  method="post">
            {{ csrf_field() }}
            <input type="submit" value="Atšaukti turnyro rezervacijas" style="background-color: darkslategray;  color: white; margin-right: auto;margin-top:15px;margin-bottom: 15px;border-radius: 10px; margin: auto; border: none; height: 35px" />
        </form></div>
    </div>
</div>


<div class="grid-container" style="width: 100%">
        <div class="item1">
    <label>
        <h3 class="title">{{$Tournament->Name}}</h3>
    </label>

            <div align="left" style="font-size: 1rem;font-weight: bolder">
                <table class= "table" style="width: 100%" >
                    <colgroup>
                        <col span="1" style="width: 60%;">
                        <col span="1" style="width: 40%;">
                    </colgroup>

                    <tbody>
                    <tr>
                        <td style="width: 60%;">Žaidimas</td>

                        @foreach($allGames as $gme)
                            @if($gme->id_Game === $Tournament->fk_Gameid_Game)
                                <td style="width: 40%;" >{{$gme->Name}}</td>
                            @endif
                        @endforeach
                    </tr>

                    <tr>

                        <td style="width: 60%;">Komandų skaičius</td>
                        <td style="width: 40%;">{{$Tournament->MaximumTeams}}</td>

                    </tr>
                    <tr style="border-bottom: 1px solid #000;">
                    <tr>

                        <td style="width: 60%;">Turnyro pradžia</td>
                        <td style="width: 40%;">{{$Tournament->StartDate}}</td>
                    </tr>
                    <tr style="border-bottom: 1px solid #000;">
                    @if($tournReserv != null)
                    <tr>

                        <td style="width: 60%;">Rezervuotas laikas nuo</td>

                        <td style="width: 40%;">{{\Carbon\Carbon::parse($tournReserv->time)->format('G:i')}}</td>


                    </tr>
                    @endif
                    <tr style="border-bottom: 1px solid #000;">
                    <tr>
                        <td style="width: 60%;">Organizatorius</td>
                        @foreach($allUsers as $uss)
                            @if($uss->id === $Tournament->fk_Organizerid_User)
                                <td style="width: 40%;">{{$uss->name}}</td>
                            @endif
                        @endforeach
                    </tr>
                    <tr style="border-bottom: 1px solid #000;">
                    <tr>
                        <td style="width: 60%;">Būsena</td>
                        @foreach($allStates as $stt)
                            @if($stt->id_State=== $Tournament->State)
                                <td style="width: 40%;">{{$stt->name}}</td>
                            @endif
                        @endforeach
                    </tr>
{{--                    <tr style="border-bottom: 1px solid #000;">--}}
{{--                    <tr>--}}
{{--                        <td style="width: 60%;">Laimėtojas</td>--}}
{{--                        @foreach($allTeams as $tm)--}}
{{--                            @if($tm->id_Team=== $Tournament->tournWinner)--}}
{{--                                <td style="width: 40%;">{{$tm->Name}}</td>--}}
{{--                            @endif--}}
{{--                        @endforeach--}}
{{--                    </tr>--}}
                    </tbody>

                </table>
            </div>
        </div>



{{--            <div class="item2" style="background-color: ghostwhite;border-radius: 20px;margin-right: 10px">--}}
{{--                <label>--}}
{{--                    <h3 class="title">Komandos</h3>--}}
{{--                </label>--}}
{{--                   @foreach($allTournTeams as $tt)--}}
{{--                       @foreach($allTeams as $team)--}}
{{--                           @if($tt->fk_Teamid_Team === $team->id_Team)--}}
{{--                    <div class="row">--}}
{{--                        <div class = "col"> <h6>{{$team->Name}}</h6> </div>--}}
{{--                        <div class="col"><h6>{{$team->WonTournaments}}</h6></div>--}}
{{--                    </div>--}}
{{--                        @endif--}}
{{--                    @endforeach--}}
{{--                    @endforeach--}}

{{--            </div>--}}
    <div class="item2" style="font-size: 1rem;font-weight: bolder">
        <label>
            <h3 class="title">Dalyviai</h3>
        </label>
        <table class= "table" style="width: 100%" >
            <colgroup>
                <col span="1" style="width: 60%;">
                <col span="1" style="width: 40%;">
            </colgroup>

            <tbody>
{{--            @if($maxTeams->NumberOfMembers>1)--}}
@if($maxTeams->NumberOfMembers>1)
    @foreach($allTournTeams as $tt)
        <tr>
            @foreach($allTeams as $team)
                @if($tt->fk_Teamid_Team === $team->id_Team)
                    @if($Tournament->tournWinner === $team->id_Team)
                    <td style="width: 70%; color: #ae0078;font-size: 18px"> {{$team->Name}}  </td>
                        <td style="width: 30%;color: #ae0078;font-size: 18px">{{$tt->victories}} </td>
                    @else
                        <td style="width: 70%;"> {{$team->Name}}  </td>
                        <td style="width: 30%;">{{$tt->victories}} </td>
                    @endif
                @endif
            @endforeach
{{--            <td style="width: 30%;">{{$tt->victories}} </td>--}}

        </tr>
    @endforeach
@else
    @foreach($allTournUsers as $tu)
        <tr>
            @foreach($allUsers as $user)
                @if($tu->fk_Userid_User === $user->id)
                    <td style="width: 70%;"> {{$user->name}}  </td>
                @endif
            @endforeach
            <td style="width: 30%;">{{$tu->victories}} </td>
        </tr>
    @endforeach
@endif

            </tbody>
        </table>
    </div>
        <div class="item3">
            <label>
                <h3 class="title">Komentarai</h3>
            </label>
            @foreach($allComments as$cm)
                @foreach($allUsers as $user)
                    @if(($cm->fk_Userid_User===$user->id)and ($cm->fk_Tournamentid_Tournament===$Tournament->id_Tournament))
                    <div align="left">
                        <table class="comments" >
                            <thead>
                            <tr>
                                <th >{{$user->name}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>{{$cm->com_Text}}</td>
                            </tr>
                            </tbody>

                        </table>
                        <hr>
                    </div>
                    @endif
                @endforeach
            @endforeach
            <p style="margin-bottom: 0px;margin-left: 5px;font-size: 18px">Komentaras:</p>
            <form method="POST" action="{{ Route('insertComment', $Tournament->id_Tournament) }}" class="comment_form">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                 <textarea name="com_Text" type="text" class="form-control comment" required="required" placeholder="Rašyti komentarą"></textarea>
                <button type="submit" class="btn btn-primary" id= "buttonForm" style="background-color: darkslategray; color: white; margin-top:15px;margin-bottom: 15px;border-radius: 10px; ">Pateikti</button>
            </form>
        </div>
    <div class="item4">
    <div class="grid-container">

        @if($maxTeams->NumberOfMembers>1)

        @foreach($allMatches as $mat)
            <div style="background-color: #4a5568;color: white;font-size: 16px;padding: 10px;">
                <form action="{{ route('insertResult',$mat->id_team_match)}}"  method="post" id="matchForm" >
                    {{ csrf_field() }}
                    <table>
                    <tbody>
                    @foreach($tournTeams1 as $tt1)
                        <tr>
                        @if($mat->fk_Team1===$tt1->komid)

                        <td>{{$tt1->pavad1}}</td>
{{--                        <td>{{$mat->id_team_match}}</td>--}}
                        @if((($mat->result1=== null)||($Tournament->fk_Organizerid_User===Auth::user()->id))&&($Tournament->State != 1))
                                <td>
                                        <input type="number" id="quantity2" name="result1" min="0" max="9" value="{{$mat->result1}}" style="border-radius: 7px;margin-left: 10px; color: black">
{{--                                        <input type="submit">--}}
                                </td>
                                @else
                                    <td style=" text-align: center; color: white; font-weight: bolder; width: 30px; padding-left: 20px">
                                        <h6 style="margin-bottom: 0;">{{$mat->result1}}</h6>
                                        {{--                                        <input type="submit">--}}
                                    </td>


                                @endif
                                @break
                            @endif
                                @endforeach
                    </tr>
                    <tr>
                    @foreach($tournTeams2 as $tt2)
                            @if($mat->fk_Team2===$tt2->komid2)

                        <td>{{$tt2->pavad2}}</td>
                            @if((($mat->result2=== null)||($Tournament->fk_Organizerid_User===Auth::user()->id))&&($Tournament->State != 1))
                                <td>
                                        <input type="number"  id="quantity2" value="{{$mat->result2}}" name="result2" min="0" max="9" style="border-radius: 7px;margin-left: 10px;alignment: right; color: black">
                                </td>
                                @else
                                    <td style=" text-align: center; color: white; font-weight: bolder; width: 30px; padding-left: 20px">
                                        <h6 style="margin-bottom: 0;">{{$mat->result2}}</h6>
                                    </td>
                        @endif
                                @break

                            @endif
                        @endforeach
                    </tr>
                    <tr >
                        <td></td>

                        <td>

                            @if(((($mat->result1 === null) &&($mat->result2 === null))||($Tournament->fk_Organizerid_User===Auth::user()->id))&&($Tournament->State != 1))
                            <input type="submit" id="matchSave" value="Save" style="background-color: ghostwhite; color: black; border-radius: 5px; " />

{{--                            <input type="submit" style="color: #1a202c">--}}
                                @endif
                        </td>
                    </tr>


                            </tbody>
            </table>
                </form>
    </div>
        @endforeach

        @else
            @foreach($allMatchesUser as $mat)
                <div style="background-color: #4a5568;color: white;font-size: 16px;padding: 10px;">
                    <form action="{{ route('insertResultUsers',$mat->id_user_match)}}"  method="post" id="matchForm" >
                        {{ csrf_field() }}
                        <table>
                            <tbody>
                            @foreach($tournUsers1 as $tu1)
                                <tr>
                                    @if($mat->fk_Userid_User1===$tu1->userid)

                                        <td>{{$tu1->vardas1}}</td>
                                        {{--                        <td>{{$mat->id_team_match}}</td>--}}
                                        @if((($mat->result1=== null)||($Tournament->fk_Organizerid_User===Auth::user()->id))&&($Tournament->State != 1))
                                            <td>
                                                <input type="number" id="quantity2" name="result1" min="0" max="9" value="{{$mat->result1}}" style="border-radius: 7px;margin-left: 10px; color: black">
                                                {{--                                        <input type="submit">--}}
                                            </td>
                                        @else
                                            <td style=" text-align: center; color: white; font-weight: bolder; width: 30px; padding-left: 20px">
                                                <h6 style="margin-bottom: 0;">{{$mat->result1}}</h6>
                                                {{--                                        <input type="submit">--}}
                                            </td>


                                        @endif
                                        @break
                                    @endif
                                    @endforeach
                                </tr>
                                <tr>
                                    @foreach($tournUsers2 as $tu2)
                                        @if($mat->fk_Userid_User2===$tu2->userid2)

                                            <td>{{$tu2->vardas2}}</td>
                                            @if((($mat->result2=== null)||($Tournament->fk_Organizerid_User===Auth::user()->id))&&($Tournament->State != 1))
                                                <td>
                                                    <input type="number"  id="quantity2" value="{{$mat->result2}}" name="result2" min="0" max="9" style="border-radius: 7px;margin-left: 10px;alignment: right; color: black">
                                                </td>
                                            @else
                                                <td style=" text-align: center; color: white; font-weight: bolder; width: 30px; padding-left: 20px">
                                                    <h6 style="margin-bottom: 0;">{{$mat->result2}}</h6>
                                                </td>
                                            @endif
                                            @break

                                        @endif
                                    @endforeach
                                </tr>
                                <tr >
                                    <td></td>

                                    <td>

                                        @if(((($mat->result1 === null) &&($mat->result2 === null))||($Tournament->fk_Organizerid_User===Auth::user()->id))&&($Tournament->State != 1))
                                            <input type="submit" id="matchSave" value="Save" style="background-color: ghostwhite; color: black; border-radius: 5px; " />

                                            {{--                            <input type="submit" style="color: #1a202c">--}}
                                        @endif
                                    </td>
                                </tr>


                            </tbody>
                        </table>
                    </form>
                </div>
            @endforeach
@endif


</div>

        </div>

@endsection

