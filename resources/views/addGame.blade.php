@extends('layouts.test2')
@section('content')

    @if(Auth::user()->is_admin)
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8" style="margin-top: 40px; alignment: center ">
                    <div class="card">
                        <div class="card-header"  style="background-color: #2d3748; color: white; ">Pridėti žaidimą</div>

                        <div class="card-body">
                            <form class="form-horizontal" role="form" method="POST" action="{{ url('insertGame')}}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label text-md-right" style="margin-left: 30px">Pavadinimas</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="Name" value="{{ old('Name') }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label text-md-right" style="margin-left: 30px">Narių skaičius</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="NumberOfMembers" value="{{ old('NumberOfMembers') }}">
                                    </div>
                                </div>
                         <div class="form-group row">
                             <label class="col-md-3 col-form-label text-md-right" style="margin-left: 30px; ">Objektas</label>
                                    <div class="col-md-6">
                                           <select class="form-control" name="fk_Objectid_Object">
                                               <option value="{{ old('fk_Objectid_Object') }}"></option>
                                               @foreach($allObjects as $obj)
                                                   <option value="{{$obj->id_Object}}">{{$obj->Name}}</option>
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

    @else <h1>you dont have access</h1>
    @endif
@endsection
