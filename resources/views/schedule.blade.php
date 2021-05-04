
@extends('layouts.test2')

@section('content')
    <div class="grid-container">
    <div class="itemT">
        <form class="form-horizontal" role="form" method="POST" action="{{ url('makeReservation')}}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="form-group row">
                <label class="col-md-4 col-form-label text-md-right" style="margin-left: 30px">Laisvalaikio zona</label>
                <div class="col-md-6">
                    <select class="form-control" name="fk_Objectid_Object">
                        <option value="{{ old('fk_Objectid_Object') }}" ></option>
                        @foreach($allObjects as $obj)
                            <option value="{{$obj->id_Object}}">{{$obj->Name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-4 col-form-label text-md-right" style="margin-left: 30px">Laikas</label>
                <div class="col-md-6">
                    <select class="form-control" name="time">
                        <option value="{{ old('time') }}" ></option>
                        @foreach($times as $time)
                            <option value="{{$time}}">{{$time}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div>
                <button type="submit" id="buttonForm"class="btn btn-primary" style="alignment: right">
                    Rezervuoti
                </button>
            </div>

        </form>
    </div>

    <div class="itemT" style="background-color: ghostwhite;border-radius: 20px; margin:0 auto;">
        <br>
   <h5 style="text-align: center; ">{{$mytime}}</h5>
        <br>
     <table class="table" style="width: 95%; margin:0 auto;">
         <colgroup>
             <col span="1" style="width: 20%;">
             <col span="1" style="width: 20%;">
             <col span="1" style="width: 20%;">
             <col span="1" style="width: 20%;">
         </colgroup>

         <thead>
         <th class="col" style="width: 20%; text-align: center"; > Laikas</th>
         @foreach($allObjects as $obj)
         <th class="col" style=" text-align: center;width: 20%;">{{$obj->Name}}</th>

         @endforeach
         </thead>

<tbody>
    @foreach($times as $time)
<tr>
    <td style="width: 20%">
        <p>{{$time}}</p>
    </td>
    @foreach($allObjects as $obj)
    @foreach($allReservations as $res)

        @if(($res->time===$time)&&($res->fk_Objectid_Object===$obj->id_Object))
        <td style="background-color: darkred; color: white">Užimta</td>
            @else
                <td style="background-color: seagreen; color: white">Laisva</td>

            @endif
@break

    @endforeach

                @endforeach

</tr>
    @endforeach


    </tbody>
    </table>
    </div>


    </div>
{{--    <div class="container">--}}
{{--        <div>--}}
{{--            <a class="btn btn-info pull-right" href="{{route('teams')}}">Create Appointment</a>--}}
{{--        </div>--}}

{{--        @if(!$appointments || count($appointments) < 1)--}}
{{--            <div>--}}
{{--                <h2>You have no Appointments yet</h2>--}}
{{--            </div>--}}
{{--        @endif--}}

{{--        <div class="row">--}}
{{--            <div class="col-md-8 col-md-offset-2">--}}
{{--                <div class="panel panel-default">--}}
{{--                    <div class="panel-heading"><h2>Appointments</h2></div>--}}
{{--                    <div class="panel-body" id="calendar">--}}
{{--                        {!! $appointments->calendar() !!}--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@endsection--}}

{{--@section('script')--}}
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>--}}
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>--}}
{{--    {!! $appointments->script() !!}--}}
@endsection
