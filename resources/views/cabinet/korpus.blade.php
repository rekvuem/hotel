@extends('cabinet.layouts.index')
@section('title', 'Страница информация')
@section('content')

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        @foreach($TakeRoom as $room)
        <a href="{{ route('cabinet.korpus',[$room->corpus, 'room'=>$room->id]) }}" class="btn btn-sm bg-blue-800 mt-1">{{$room->room}}</a>
        @endforeach
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header"><h3>{{$month->month}}.{{$month->year}}</h3></div>
      <div class="card-body">
        <table class="table table-bordered table-responsive">
          <tr class="bg-slate-800">
            @forelse($TakeBron as $selectD)
            <td>
              {{$selectD->day}}
            </td>
            @empty
            @endforelse
          </tr>
          <tr>       

            @foreach($TakeBron as $key => $selectD)
              @if(empty($selectD->fio))
            <td style="font-size: 0.92em">
              -
            </td>
              @else
            <td style="font-size: 0.92em">
              <div class="">Занятость: {{ $selectD->takeVid }}</div>
              <div class="">Имя Фамилия: {{ $selectD->fio }}</div>
            </td>
              @endif
            @endforeach


          </tr>
        </table>

      </div>
    </div>
  </div>
</div>



@endsection
