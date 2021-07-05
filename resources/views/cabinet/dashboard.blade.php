@extends('cabinet.layouts.index')
@section('title', 'Страница информация')
@section('content')

<div class="row">
  <div class="col-2">
    <div class="card">
      <div class="card-body">
        <form action="{{ route('cabinet.insertToBron') }}" method="POST">
          @csrf
          <div class="form-group">
            <select name="takeKorp" class="form-control select2 takeRoom" >
              <option>Выбрать...</option>
              <option value="1">Корпус 1</option>
              <option value="2">Корпус 2</option>
            </select>
          </div>

          <div class="form-group roomos"></div>

          <div class="form-group">
            <div class="input-group">
              <span class="input-group-prepend">
                <span class="input-group-text"><i class="icon-calendar3"></i></span>
              </span>
              <input type="text" name="takeBron" class="form-control getDate" id="anytime-month-numeric" autocomplete="off" value="">
            </div>
          </div>
          
          <div class="form-group">
            <input type="text" name="fio" class="form-control" value="" placeholder="Имя Фамилия" autocomplete="off">
          </div>
          
          <div class="form-group">
            <input class="form-control" type="text" name="telephon" placeholder="Телефон" value="">
          </div>
          
          <div class="form-group">
            <select name="takeVid" class="form-control select2">
              <option value="забронировано">занято</option>
            </select>
          </div>

          <div class="form-group">
            <textarea name="forText" class="form-control"></textarea>
          </div>
          
          <input type="submit" class="btn btn-success float-right" value="Забронировать">
        </form>
      </div>
    </div>
  </div>
  <div class="col-9">
    <div class="card">
      <div class="card-body">
        @foreach($month as $m)
        <a href="{{ route('cabinet.updateyear', $m->id)}}" class="btn btn-sm">{{$m->month}}.{{$m->year}}</a> |
        @endforeach
      </div>
    </div>
    
    <div class="row">
      <div class="col-3">
        <div class="reverse"></div>
      </div>
      <div class="col-6">
        
      </div>
    </div>
    
    
  </div>
</div>

<div class="row">
  Куки: {!! Cookie::get('monthing') !!}
</div>

@endsection
@section('page_java')
<script src="{{ asset('theme/global_assets/js/plugins/pickers/daterangepicker.js') }}"></script>
<script src="{{ asset('theme/global_assets/js/plugins/pickers/anytime.min.js') }}"></script>
<script src="{{ asset('theme/global_assets/js/plugins/forms/selects/select2.min.js') }}" type="text/javascript"></script>
<!--<script src="{{ asset('theme/global_assets/js/plugins/ui/moment/moment.min.js') }}"></script> setTimeout('location.reload(true)', 3000);-->

<script>
$(document).ready(function () {
  $.ajaxSetup({ cache: false });
  $('.takeRoom').change(function () {
    var getroom = $(this).val();

    $.ajax({
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      method: 'GET',
      url: "{{ route('cabinet.selectrooms') }}",
        data: { _method: 'GET', getroom:getroom},
      success: function (data) {
        $('.roomos').html(data);
      },
      error: function () {
        alert('нет успеха');
      }
    });
  });
  
//  reservation
  $('.getDate').on('click',function(e){
    e.preventDefault();
    var rooms = $('#roomed').val();
    var GetDating = $(this).val();

    $.ajax({
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      method: 'GET',
      url: "{{ route('cabinet.chooseroom') }}",
        data: {check:GetDating, room:rooms},
      success: function (data) {
        $('.reverse').html(data);

      }
    });
  });
  

  $('#anytime-month-numeric').AnyTime_picker({
    format: '%d.%m.%Z'
  });

  $('.select2').select2({
    minimumResultsForSearch: Infinity
  });

  $('.selected').select2();

});
</script>
@endsection