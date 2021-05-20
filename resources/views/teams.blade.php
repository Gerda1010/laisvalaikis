@extends('layouts.test2')

@section('content')

    <div class="grid-container">
        <br>
        <div class="itemT" style="background-color: ghostwhite; border-radius: 15px; alignment: center;text-align:center">
           <br>

            <a href="{{action('teamsController@teamsRegistration')}}" id="button1" class="btn btn-dark" style="width: 150px; margin-left: 5px;margin-right: 5px">
                Sukurti komandą</a>
            <br>
            <table id="table" class="table table-hover table-condensed" >
                <thead>
                <tr>

                    <th style="width:20%;border-bottom: 10px;">Pavadinimas</th>
                    <th style="width:30%;border-bottom: 10px;">Laimėti turnyrai</th>
                    <th style="width:30%;border-bottom: 10px;">Narių skaičius</th>

                </tr>
                </thead>
                <tbody>
                @foreach($allTeams as $asTeam)
                    <tr>

                        <td>{{ $asTeam->Name }}</td>
                        <td>{{ $asTeam->WonTournaments }}</td>
                        <td>{{$asTeam->members}}</td>

                    </tr>
                @endforeach
                </tbody>
            </table>
            {{$allTeams->appends(request()->input())->links()}}
        </div>
    </div>

@endsection
