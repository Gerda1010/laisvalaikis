@extends('layouts.test2')
@section('content')

    @if(Auth::user()->is_admin)
{{--        @if (count($errors) > 0)--}}
{{--            <div class="alert alert-danger">--}}
{{--                <p>There is an error in the data you are entering:</p>--}}
{{--                @foreach ($errors->all() as $error)--}}
{{--                    <p>{{ $error }}</p>--}}
{{--                @endforeach--}}
{{--            </div>--}}
{{--        @endif--}}
        <div class="container">
            <div class="row justify-content-center">

                <div class="col-md-8" style="margin-top: 40px ">
                    <div class="card">
                        <div class="card-header" style="background-color: #2d3748; color: white;" >Redaguoti naudotoją</div>

                        <div class="card-body">
                            <form class="form-horizontal" role="form" method="POST" action="{{ url('confirmEditedUser', $selectedUser->id) }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label text-md-right" style="margin-left: 30px;">Vardas</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="name" value="{{$selectedUser->name}}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label text-md-right" style="margin-left: 30px;">El. paštas</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="email" value="{{$selectedUser->email}}">
                                    </div>
                                </div>

                                <div>
                                    <button type="submit" id="buttonForm"class="btn btn-primary" style="alignment: right">
                                        Išsaugoti
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else <h1>you dont have access</h1>
    @endif
@endsection

