@extends('cabinet.layouts.index')
@section('title', 'Отобразить комнат')
@section('content')

<div class="row">
  <div class="col-12">
    <div class="card">
      @foreach($TakeBron as $selectD)
      
      {{$selectD->day}}
       
      @endforeach
    </div>
  </div>
</div>

@endsection
