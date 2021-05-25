
@extends('layouts.test2')

@section('content')
    <div class="grid-container">

<br>
    <div class="itemT" style="background-color: ghostwhite;border-radius: 20px; margin:0 auto;width: 100%;height: 500px;overflow: auto;text-align:center">
        <br>

        <form method="post" action="{{action('scheduleController@byDate')}}">
            @csrf
            <input style="margin: auto;" name="somedate" type="date" value="{{$mytime}}" onchange="this.form.submit()"  min="{{now()->format('Y-m-d')}}" max="{{ now()->addDays(15)->format('Y-m-d') }}" >

        </form>

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
        {{$mytime}}
<tr>
    <td style="width: 20%">
        <p>{{$time}}</p>
    </td>

        @foreach($allObjects as $obj)
        @php
            $val = 0
        @endphp
            @foreach($allReservations as $res)
       @if(($res->time===$time)&&($res->fk_Objectid_Object===$obj->id_Object))
        <td style="background-color: darkred; color: white">Užimta</td>

         @php
         $val = 1
            @endphp
                @break
            @else

           @continue

            @endif
        @endforeach
    @if($val != 1)
                <td style="background-color: seagreen; color: white">

            <a style="height: 50px;padding: 0" onclick="return confirm('Patvirtinkite rezervaciją')" href="{{action('scheduleController@makeReservation',['time'=> $time, 'obj'=>$obj->id_Object, 'mytime'=>$mytime])}}">
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
