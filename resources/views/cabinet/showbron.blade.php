@extends('cabinet.layouts.index')
@section('title', 'Отобразить комнаты')
@section('content')

<div class="row">
  <div class="col-12">
    <div class="card">
      <table class="table table-bordered table-responsive">
        <tr>
          <td></td>
          @foreach($TakeBron as $room)
       
          <td>{{$room->room}} </td>

          @endforeach
        
          
        </tr>
        @for ($i = 1; $i <= $showDate; $i++)
        <tr>
          <td>{{$i}}</td>
        </tr>
        @endfor

      </table>
    </div>
  </div>
</div>

@endsection
