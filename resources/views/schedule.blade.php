
@extends('layouts.test2')

@section('content')
    <div class="grid-container">

<br>
    <div class="itemT" style="background-color: ghostwhite;border-radius: 20px; margin:0 auto;width: 70%;height: 500px;overflow: auto;text-align:center">
        <br>

        <form method="post" action="{{route('byDate')}}">
            @csrf
            <input style="margin: auto;" name="somedate" type="date" value="{{$mytime}}" onchange="this.form.submit()"  min="{{now()->format('Y-m-d')}}" max="{{ now()->addDays(14)->format('Y-m-d') }}" >

        </form>
{{--{{$mytime}} <br>--}}
{{--        @php--}}
{{--     $var = $mytime--}}
{{--        @endphp--}}
{{--        {{$var}}--}}
        <br>
     <table class="table" style="width: 95%; margin:0 auto;">
         <colgroup>
             <col span="1" style="width: 10%;">
             <col span="1" style="width: 30%;">
             <col span="1" style="width: 30%;">
             <col span="1" style="width: 30%;">
         </colgroup>

         <thead>
         <th class="col" style="width: 10%; text-align: center"; > Laikas</th>
         @foreach($allObjects as $obj)
         <th class="col" style=" text-align: center;width: 30%;">{{$obj->Name}}</th>

         @endforeach
         </thead>

<tbody>
    @foreach($times as $time)

<tr>
    <td style="width: 10%">
        <p>{{\Carbon\Carbon::parse($time)->format('G:i')}}</p>
    </td>

@foreach($allObjects as $obj)
        @php
            $val = 0
        @endphp
            @foreach($allReservations as $res)
       @if(($res->time===$time)&&($res->fk_Objectid_Object===$obj->id_Object))
           @if($res->fk_Tournament == null)
               <td style="background-color: darkred; color: white;width: 30%">Užimta</td>
                @else
               @foreach($tourn as $tr)
                   @if($res->fk_Tournament==$tr->id_Tournament)
                    <td style="background-color: rebeccapurple; color: white;width: 30%">{{$tr->Name}}</td>
                        @endif
                    @endforeach
@endif
         @php
         $val = 1
            @endphp
                @break
            @else

           @continue

            @endif
        @endforeach
    @if($val != 1)
                <td style="background-color: seagreen; color: white;width: 30%">

            <a style="height: 50px;padding: 0" onclick="return confirm('Patvirtinkite rezervaciją')" href="{{action('scheduleController@makeReservation',['time'=> $time, 'obj'=>$obj->id_Object, 'mytime'=>$mytime ])}}">
                 Laisva
                    </a>
                </td>
                @endif
                @endforeach


</tr>
    @endforeach


    </tbody>
    </table>
    </div>

@endsection
