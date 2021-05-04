@extends('layouts.test2')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8" style="margin-top: 40px ">
            <div class="card">
                <div class="card-header" id="antraste" style="background-color: #2d3748; color: white; ">Sukurti komandą</div>

                <div class="card-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('insertTeam')}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right" style="margin-left: 30px">Pavadinimas</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="Name" value="{{ old('Name') }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right" style="margin-left: 30px">Naudotojai</label>
                            <div class="col-md-6">
                            <select class="form-control" name="fk_Userid_User1">
                                <option value="{{ old('fk_Userid_User') }}" ></option>
                                @foreach($allUsers as $user)
                                    @if($user->id!==Auth::user()->id)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right" style="margin-left: 30px">Naudotojai</label>
                            <div class="col-md-6">
                            <select class="form-control" name="fk_Userid_User2">
                                <option value="{{ old('fk_Userid_User') }}" ></option>
                                @foreach($allUsers as $user)
                                    @if($user->id!==Auth::user()->id)
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                            </div></div>




                            <div class="col-md-10 offset-md-4" style="margin-left: -35px">
                                <button type="submit" id="buttonForm"class="btn btn-primary">
                                    Pridėti
                                </button>
                            </div>





                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
