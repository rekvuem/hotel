@extends('cabinet.layouts.index')
@section('title', 'Настройки')
@section('content')

<div class="row">
  <div class="col-2">
    <div class="card">
      <div class="card-header">добавить месяц/год</div>
      <div class="card-body">
        <select>
          @for($m=1; $m<=12; $m++)
          <option>{{$m}}</option>
          @endfor
        </select>
        <select>
          @for($y=2021; $y<=2050; $y++)
          <option> {{$y}}</option>
          @endfor
        </select>
      </div>
      <div class="card-footer">
        @foreach($TakeYear as $year)
        <div>{{$year->month}}.{{$year->year}}</div>
        @endforeach
      </div>


    </div>
  </div>
  <div class="col-2">
    <div class="card">
      <div class="card-header">добавить комнаты</div>
      <div class="card-body">
        <select>
          @for($k=1; $k<=2; $k++)
          <option>{{$k}}</option>
          @endfor
        </select>
        <input class="form-control" type="text" name="name" placeholder="комната" value="">
      </div>
    </div>
  </div>
  <div class="col-2">
    <div class="card">
    <table>
        @foreach($room_1 as $room)
        <tr>
          <td>{{$room->room}} </td>
          <td><input class="form-control" type="text" name="name" value="" autocomplete="off"></td>
        </tr>  
        @endforeach
    </table>
    </div>
  </div>  
  <div class="col-2">
    <div class="card">
    <table>
        @foreach($room_2 as $room)
        <tr>
          <td>{{$room->room}}</td>
          <td><input class="form-control" type="text" name="name" autocomplete="off" value=""></td>
        </tr>
        @endforeach
    </table>
    </div>
  </div>
</div>

<div class="row">
  очистить базу / очистить месяц / очистить логи
</div>


@endsection