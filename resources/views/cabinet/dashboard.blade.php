@extends('cabinet.layouts.index')
@section('title', 'Страница информация')
@section('content')

<div class="row">
  <div class="col-2 col-md-2 col-sm-12">
    <div class="card">
      <div class="card-body">
        <form action="{{ route('cabinet.insertToBron') }}" method="POST">
          @csrf
          <div class="form-group">
            <select name="takeKorp" class="form-control select2 takeKorpus" >
              <option>Выбрать...</option>
              <option value="1">Корпус 1</option>
              <option value="2">Корпус 2</option>
            </select>
          </div>

          <div class="form-group">
            <div class="row">
              <div class="col-12">
                <div class="input-group">
                  <span class="input-group-prepend">
                    <span class="input-group-text"><i class="icon-calendar3"></i></span>
                  </span>
                  <input type="text" name="takeBron_range" class="form-control daterange-locale getDate_start"  value="">
                </div>
              </div>
            </div>
          </div>
          <div class="form-group showroom">
          </div>
          <div class="form-group">
            <input type="text" name="fio" class="form-control" value="" placeholder="Имя Фамилия" >
          </div>

          <div class="form-group">
            <input id="number_mobile" class="form-control" type="text" name="telephon" placeholder="Телефон" value="">
          </div>

          <div class="form-group">
            <select name="takeVid" class="form-control select2">
              <option value="забронирован">забронировать</option>
              <option value="заселен">заселены</option>
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
    <div class="row">
      @foreach ($getBron_now as $now)
        @if($now->month_year == $now->bron_end_date)
      <div class="col-2">
        <div class="card">
          <div class="card-header bg-orange-800 pt-0 pb-0" style="font-weight: bold; font-size: 1.3em">{{$now->room}}</div>
          <div class="card-body bg-orange-700">
            <div class="" style="font-weight: bold; font-size: 1.2em">последний день</div>
            <div class="" style="font-weight: bold; font-size: 1em; font-style: italic">{{$now->bron_start_date}} - {{$now->bron_end_date}}</div>
            <div class="">{{$now->fio}}</div>
            <div class="">{{$now->telehon}}</div>
          </div>
        </div>
      </div>
        @endif
      @endforeach
    </div>

    <div class="row">
      <div class="col-6">
        @if(session('checkroom'))
        <div class="alert bg-info-700 text-white alert-styled-left alert-dismissible">
          <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
          <span class="font-weight-semibold">{{ session('checkroom') }}</span>
        </div>
        @endif
      </div>      
      <div class="col-6"></div>
    </div>
    <div class="reverse"></div>
  </div>
</div>

@endsection
@section('page_java')
<script src="{{ asset('theme/global_assets/js/plugins/ui/moment/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('theme/global_assets/js/plugins/pickers/daterangepicker.js') }}" type="text/javascript"></script>
<script src="{{ asset('theme/global_assets/js/plugins/forms/selects/select2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('theme/global_assets/js/plugins/forms/inputs/inputmask/jquery.inputmask.min.js') }}" type="text/javascript"></script>
<script>
$(document).ready(function () {

  $('#number_mobile').inputmask("+38(099) 999-99-99");

  $('.takeKorpus').change(function () {
    $('.getDate_start').change('click', function () {
      var get_korpus = $('.takeKorpus').val();
      var data_range = $(this).val();

      $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        method: 'get',
        url: "{{ route('cabinet.freeroom') }}",
        data: {korpus: get_korpus, daterange: data_range},
        success: function (data) {
          $('.reverse').html(data);
        }
      });


      $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        method: 'get',
        url: "{{ route('cabinet.listfreeroom') }}",
        data: {korpus: get_korpus, daterange: data_range},
        success: function (data) {
          $('.showroom').html(data);
        }
      });



    });

  });

  $('.daterange-locale').daterangepicker({
    applyClass: 'btn-sm btn-success',
    cancelClass: 'btn-sm btn-light',
    minDate: '01.06.2021',
    opens: 'right',
    locale: {
      format: 'DD.MM.YYYY',
      applyLabel: 'Ок',
      cancelLabel: 'Отмена',
      startLabel: 'Начальная дата',
      endLabel: 'Конечная дата',
      daysOfWeek: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
      monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
      firstDay: 1
    }
  });

  $('.select2').select2({
    minimumResultsForSearch: Infinity
  });

  $('.selected').select2();

});
</script>
@endsection