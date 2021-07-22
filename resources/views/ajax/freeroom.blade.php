<div class="row">
  @foreach($freeshown as $freecom)
  
  @if($freecom['vid'] == null)
  <div class="col-1">
    <div class="card">
      <div class="bg-blue-600">{{$freecom['room']}}</div>
      <div class="">
        {{$freecom['date']}}
      </div>
    </div>
  </div>
  @else
  <div class="col-1">
    <div class="card">
      <div class="bg-teal-700">{{$freecom['room']}}</div>
      <div class="">
        {{$freecom['date']}}
      </div>
    </div>
  </div>
  
  @endif
  @endforeach
</div>