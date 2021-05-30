@extends('layouts.test2')

@section('content')

    <div class="grid-container">
        <br>
        <div class="itemT" style="background-color: ghostwhite; border-radius: 15px; alignment: center">

            <a href="{{action('tournamentsController@createTournament')}}" id="button1" class="btn btn-dark" style="width: 150px; margin-left: 5px;margin-right: 5px">
                Sukurti turnyrą</a>
            <br>
            <table id="table" class="table table-hover table-condensed" >
                <thead>
                <tr>
                    <th style="width:25%;border-bottom: 10px;">Pavadinimas</th>
                    <th style="width:20%;border-bottom: 10px;">Žaidimas</th>
{{--                    <th style="width:30%;border-bottom: 10px;">Komandų skaičius</th>--}}
                    <th style="width:15%;border-bottom: 10px;">Turnyro data</th>
                    <th style="width:20%;border-bottom: 10px;">Organizatorius</th>
                    <th style="width:20%;border-bottom: 10px;">Būsena</th>
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

                        <td>{{ $asTr->StartDate }}</td>

                    @foreach($allUsers as $us)
                        @if($us->id === $asTr->fk_Organizerid_User)
                            <td>{{ $us->name }}</td>

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
    </div>

@endsection

