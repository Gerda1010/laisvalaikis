@extends('layouts.test2')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8" style="margin-top: 40px ">
                <div class="card">
                    <div class="card-header" style="background-color: #2d3748; color: white; ">Sukurti turnyrą</div>

                    <div class="card-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('insertTournament')}}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right" style="margin-left: 30px">Pavadinimas</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="Name" value="{{ old('Name') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right" style="margin-left: 30px">Maksimalus komandų sk.</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="MaximumTeams" value="{{ old('MaximumTeams') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right" style="margin-left: 30px">Turnyro pradžios data</label>
                                <div class="col-md-6">
                                    <input type="date" min="{{now()->format('Y-m-d')}}" class="form-control" name="StartDate" value="{{ old('StartDate') }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right" style="margin-left: 30px; ">Pradžios įvykis</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="StartEvent">
                                        <option value="{{ old('StartEvent') }}" ></option>
                                        @foreach($StartEvents as $stEv)
                                            <option value="{{$stEv->id_StartEvent}}">{{$stEv->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right" style="margin-left: 30px;">Žaidimas</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="fk_Gameid_Game">
                                        <option value="{{ old('fk_Gameid_Game') }}" ></option>
                                        @foreach($allGames as $gme)
                                            <option value="{{$gme->id_Game}}">{{$gme->Name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>



                                <div>
                                    <button type="submit" id="buttonForm"class="btn btn-primary" style="alignment: right">
                                        Pridėti
                                    </button>
                                </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection
