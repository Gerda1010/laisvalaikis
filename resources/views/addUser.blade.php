@extends('layouts.test2')
@section('content')

    @if(Auth::user()->is_admin)

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8" style="margin-top: 40px ">
                    <div class="card">
                        <div class="card-header" style="background-color: #2d3748; color: white;" >Pridėti naudotoją </div>

                        <div class="card-body">
                            <form class="form-horizontal" role="form" method="POST" action="{{ url('insertUser')}}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label text-md-right" style="margin-left: 30px">Vardas</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label text-md-right" style="margin-left: 30px">El. paštas</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="email" value="{{ old('email') }}">
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
            @else <h1>you dont have access</h1>
    @endif
@endsection
