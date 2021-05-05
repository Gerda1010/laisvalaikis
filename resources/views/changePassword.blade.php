@extends('layouts.test2')

@section('content')

    <div class="container">
        <br>
        <div class="row justify-content-center">

            <div class="col-md-8">

                <div class="card">

                    <div class="card-header "style="background-color: #2d3748; color: white; ">Slaptažodžio keitimas</div>



                    <div class="card-body">

                        <form method="POST" action="{{ route('change.password') }}">

                            @csrf



                            @foreach ($errors->all() as $error)

                                <p class="text-danger">{{ $error }}</p>

                            @endforeach

                            <div class="form-group row">

                                <label for="password" class="col-md-4 col-form-label text-md-right">Esamas slaptažodis</label>

                                <div class="col-md-6">

                                    <input id="password" type="password" class="form-control" name="current_password" autocomplete="current-password">

                                </div>
                            </div>

                            <div class="form-group row">

                                <label for="password" class="col-md-4 col-form-label text-md-right">Naujas slaptažodis</label>



                                <div class="col-md-6">

                                    <input id="new_password" type="password" class="form-control" name="new_password" autocomplete="current-password">

                                </div>

                            </div>

                            <div class="form-group row">

                                <label for="password" class="col-md-4 col-form-label text-md-right">Pakartokite naują slaptažodį</label>

                                <div class="col-md-6">

                                    <input id="new_confirm_password" type="password" class="form-control" name="new_confirm_password" autocomplete="current-password">

                                </div>

                            </div>

                            <div class="form-group row mb-0">

                                <div class="col-md-8 offset-md-4">

                                    <button type="submit" class="btn btn-primary" id="button1">

                                        Atnaujinti

                                    </button>

                                </div>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
