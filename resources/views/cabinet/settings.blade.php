@extends('cabinet.layouts.index')
@section('title', 'Настройки')
@section('content')

<div class="row">
  <div class="col-2">
    <div class="card">
      <div class="card-header">добавить месяц/год</div>
      <div class="card-body">
        <form action="{{route('cabinet.insertYear')}}" method="POST">
          @csrf
          {{method_field('POST')}}
          <div class="form-group">
            <div class="row">
              <div class="col-6">
                <select name="month" class="select2" title="месяц">
                  <option value="01">01</option>
                  <option value="02">02</option>
                  <option value="03">03</option>
                  <option value="04">04</option>
                  <option value="05">05</option>
                  <option value="06">06</option>
                  <option value="07">07</option>
                  <option value="08">08</option>
                  <option value="09">09</option>
                  <option value="10">10</option>
                  <option value="11">11</option>
                  <option value="12">12</option>
                </select>
              </div>
              <div class="col-6">
                <select name="year" class="select2" title="год">
                  @for($y=2021; $y<=2050; $y++)
                  <option value="{{$y}}">{{$y}}</option>
                  @endfor
                </select>
              </div>
            </div>
          </div>
          <input type="submit" class="btn btn-sm float-right bg-blue-600" value="добавить">
        </form>
      </div>
    </div>

    <div class="card">
      <div class="card-header bg-brown-700">Месяцы</div>
      <div class="card-body">
        @foreach($TakeYear as $year)
        <div><a href="{{ route('cabinet.updateyear', $year->id)}}" class="">{{$year->month}}.{{$year->year}}</a></div>
        @endforeach
        {{$TakeYear->links()}}
      </div>
    </div>

    <div class="card">
      <div class="card-header bg-blue-400">Управление базой данных</div>
      <div class="card-body">
        <a class="btn" href="{{route('cabinet.getClear')}}">Очистить кеш сайта</a>
        
      </div>
    </div>
  </div>
  <div class="col-3">
    <div class="card">
      <div class="card-header">добавить комнаты</div>
      <div class="card-body">
        <form action="{{route('cabinet.addRoom')}}" method="POST">
          @csrf
          {{method_field('POST')}}
          <div class="form-group">
            <div class="row">
              <div class="col-6">
                <select name="korpus" class="select2">
                  @for($k=1; $k<=3; $k++)
                  <option>{{$k}}</option>
                  @endfor
                </select>
              </div>
              <div class="col-6">  
                <input class="form-control" type="text" name="roomos" placeholder="комната" value="">
              </div> 
              <div class="col-6">  
                <input class="form-control" type="text" name="price" placeholder="цена за комнату" value="">
              </div> 
              <div class="col-6">  
                <input class="form-control" type="text" name="comment" placeholder="описание комнаты" value="">
              </div> 
            </div>
          </div>
          <input type="submit" class="btn btn-sm float-right bg-blue-600" value="добавить">
        </form>
      </div>
    </div>


    <div class="card">
      <div class="card-header bg-violet-800 p-1" style="font-size: 1.3em">FAQ (помощь)</div>
      <div class="card-body">
        <p class=""><b>добавить месяц/год</b> - при добавлении месяца автоматически проставляются существующие комнаты которые расположены в правой стороне страницы. В списке месяцев будет показыватся 12 последних записей, чтоб использовать список активного месяца нужно выбрать и нажать на месяц чтоб активировать.</p>

        <p class=""><b>добавить комнаты</b> - </p>

        <p class=""><b>редактирование комнаты</b> - редактировать можно цены и описание комнат, при завершении редактирование нужно нажать <b>Enter</b></p>

        <p class=""><b>Активация месяца</b> - для активации месяца Вам нужно нажать на добавленный при перезагрузки у Вас отобразится в меню Активный месяц</p>
      </div>
    </div>


  </div>
  <div class="col-3">
    <div class="card">
      <div class="card-header font-weight-bold">Корпус №1</div>
      <table class="table table-bordered">
        <thead>
          <tr>
            <td>комната</td>
            <td>цена</td>
            <td>дополнительно</td>
          </tr>
        </thead>
        <tbody>
          @foreach($room_1 as $room)
          <tr>
            <td> <b>{{$room->room}} </b></td>
            <td>
              <input class="form-control price" 
                     data-room="{{$room->id_room}}"
                     data-number="{{$room->room}}"
                     type="text" 
                     autocomplete="off" 
                     value="{{$room->price}}">
            </td>
            <td>
              <input class="form-control comments" 
                     data-room="{{$room->id_room}}" 
                     data-number="{{$room->room}}"
                     type="text" 
                     autocomplete="off" 
                     value="{{$room->comment}}">
            </td>
          </tr>  
          @endforeach
        </tbody>
      </table>
    </div>
  </div>  
  <div class="col-3">
    <div class="card">
      <div class="card-header font-weight-bold">Корпус №2</div>
      <table class="table table-bordered">
        <thead>
          <tr>
            <td>комната</td>
            <td>цена</td>
            <td>дополнительно</td>
          </tr>
        </thead>
        <tbody>
          @foreach($room_2 as $room)
          <tr>
            <td><b>{{$room->room}}</b></td>
            <td>
              <input class="form-control price" 
                     data-room="{{$room->id_room}}" 
                     data-number="{{$room->room}}"
                     type="text" 
                     autocomplete="off"
                     value="{{$room->price}}">
            </td>
            <td>
              <input class="form-control comments" 
                     data-room="{{$room->id_room}}" 
                     data-number="{{$room->room}}"
                     type="text" 
                     autocomplete="off" 
                     value="{{$room->comment}}">
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection
@section('page_java')
<script src="{{ asset('theme/global_assets/js/plugins/notifications/bootbox.min.js') }}"></script>
<script src="{{ asset('theme/global_assets/js/plugins/forms/selects/select2.min.js') }}" type="text/javascript"></script>
<script>
$(document).ready(function () {
  $('.select2').select2({
    minimumResultsForSearch: Infinity
  });
  $('.selected').select2();

  $('.price').keypress(function (e) {
    if (e.which == 13) {
      var price = $(this).val();
      var room = $(this).data('room');
      var number = $(this).data('number');
      $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        method: 'POST',
        url: "{{ route('cabinet.updateroominfo') }}",
        data: {_method: 'PUT', roomid: room, priceofroom: price, roomnumber: number},
        success: function () {
          bootbox.alert({
            title: 'Обновлено!',
            message: 'данные комнаты были изменены!',
            callback: function () {
              setTimeout("location.reload(true);", 100);
            }
          });

        },
        error: function (data) {
          console.log(data);
        }
      });
    }
  });


  $('.comments').keypress(function (e) {
    if (e.which == 13) {
      var commet = $(this).val();
      var room = $(this).data('room');
      var number = $(this).data('number');
      $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        method: 'POST',
        url: "{{ route('cabinet.updateroominfocomment') }}",
        data: {_method: 'PUT', roomid: room, commentofroom: commet, roomnumber: number},
        success: function () {
          bootbox.alert({
            title: 'Обновлено!',
            message: 'данные комнаты были изменены!',
            callback: function () {
              setTimeout("location.reload(true);", 100);
            }
          });

        },
        error: function (data) {
          console.log(data);
        }
      });
    }
  });

});
</script>
@endsection