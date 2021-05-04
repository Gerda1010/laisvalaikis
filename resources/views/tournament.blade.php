@extends('layouts.test2')

@section('content')

<br>
<div class="row" style="margin-left: 7px">
    @if($Tournament->State===3)
    <button id="myBtn" style="background-color: darkslategray; color: white; margin-left: 20px;border-radius: 5px; ">Užsiregistruoti</button>

@if($Tournament->fk_Organizerid_User===Auth::user()->id)
    <form action="{{ route('startTournament',$Tournament->id_Tournament)}}"  method="post">
        {{ csrf_field() }}
        <input type="submit" value="Pradėti turnyrą" style="background-color: darkslategray;  color: white; margin-left: 20px;border-radius: 5px; border: none; height: 35px" />
    </form>
        @endif
    @else
        <button id="myBtn" style="background-color: dimgray;  color: white; margin-left: 20px;border-radius: 5px; " disabled>Užsiregistruoti</button>


        <form action="{{ route('startTournament',$Tournament->id_Tournament)}}"  method="post">
            {{ csrf_field() }}
            <input type="submit" disabled value="Pradėti turnyrą" style="background-color: dimgray; color: white; margin-left: 20px;border-radius: 5px; border: none; height: 35px" />
        </form>
    @endif
        <button id="logBtn" style="background-color: darkslategray; color: white; margin-left: 20px;border-radius: 5px; ">Turnyro istorija</button>
</div>
    <br>
{{--Modalas--}}
    <!-- The Modal -->
    <div id="myModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header" style="alignment: left">

                <h2 >Pasirinkite komandą</h2>
                <span class="close2">&times;</span>
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
               <div ><button type="submit" id="buttonForm" class="btn btn-primary" style="alignment:right;">
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
            <span class="close">&times;</span>
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
{{--    Modalas--}}

{{--<div class="container-fluid" >--}}
{{--    <div class="row">--}}

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

{{--                    <tr>--}}

{{--                        <td style="width: 60%;">Narių skaičius</td>--}}
{{--                        @foreach($allGames as $gme)--}}
{{--                            @if($gme->id_Game === $Tournament->fk_Gameid_Game)--}}
{{--                                <td style="width: 40%;">{{$gme->NumberOfMembers}}</td>--}}
{{--                            @endif--}}
{{--                        @endforeach--}}
{{--                    </tr>--}}
                    <tr style="border-bottom: 1px solid #000;">
                    <tr>

                        <td style="width: 60%;">Turnyro pradžia</td>
                        <td style="width: 40%;">{{$Tournament->StartDate}}</td>
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
            <h3 class="title">Komandos</h3>
        </label>
        <table class= "table" style="width: 100%" >
            <colgroup>
                <col span="1" style="width: 60%;">
                <col span="1" style="width: 40%;">
            </colgroup>

            <tbody>

                @foreach($allTournTeams as $tt)
                    @foreach($allTeams as $team)
                        <tr>
                        @if($tt->fk_Teamid_Team === $team->id_Team)
                                <td style="width: 70%;"> {{$team->Name}} </td>
                        @endif
{{--                            @foreach($allTournTeams as $rez)--}}
{{--                                @if($team->id_Team===$tt->fk_Teamid_Team)--}}
{{--                            <td style="width: 30%;">{{$tt->victories}} </td>--}}
{{--                                @endif--}}
{{--                                @break--}}
{{--                            @endforeach--}}
                        </tr>

                    @endforeach
                @endforeach
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


        @foreach($allMatches as $mat)
            <div style="background-color: #4a5568;color: white;font-size: 16px;padding: 10px;">
                <form action="{{ route('insertResult',$mat->id_team_match)}}"  method="post" >
                    {{ csrf_field() }}
                    <table>
                    <tbody>
                    @foreach($tournTeams1 as $tt1)
                        @if($mat->fk_Team1===$tt1->komid)

                        <td>{{$tt1->pavad1}}</td>
{{--                        <td>{{$mat->id_team_match}}</td>--}}
                                <td>
                                        <input type="number" id="quantity" name="result1" min="1" max="9" style="border-radius: 7px;margin-left: 10px; color: black">
{{--                                        <input type="submit">--}}
                                </td>
                    </tr>
                    @break
                    @endif
                    @endforeach
                    <tr>
                    @foreach($tournTeams2 as $tt2)
                            @if($mat->fk_Team2===$tt2->komid2)

                        <td>{{$tt2->pavad2}}</td>
                                <td>
                                    <form>
                                        <input type="number"  id="quantity" name="result2" min="1" max="9" style="border-radius: 7px;margin-left: 10px;alignment: right; color: black">
                                </td>
                    </tr>
                    <tr >
                        <td></td>
                        <td>
{{--                                <button type="submit" id="matchBtn" class="btn btn-primary"">--}}
{{--                                    Išsaugoti--}}
{{--                                </button>--}}
                            <input type="submit" id="buttonMtch" value="Save" style="background-color: ghostwhite; color: black; border-radius: 5px; " />

{{--                            <input type="submit" style="color: #1a202c">--}}
                        </td>
                    </tr>

                    @break

                            @endif
                    @endforeach
                            </tbody>
            </table>
                </form>
    </div>
        @endforeach





</div>

        </div>

@endsection
