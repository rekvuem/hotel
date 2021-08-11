@extends('cabinet.layouts.index')
@section('title', 'Логи действий')
@section('content')
<div class="row">
  {{$show_logs->links()}}
</div>

<div class="row">
  @foreach($show_log as $log)
  <div class="col-2">
    <div class="card">
      <div class="card-body">  
        @if($log['action'] == 'быстрое изменение номера')    
        <div class=""><b>дата действия:</b> {{$log['action_log_date']}}</div>
        <div class=""><b>сотрудник:</b> {{$log['user_action']}}</div>
        <div class=""><b>действие:</b> {{$log['action']}}</div>
        <div class="">тип бронирования: {{$log['type_action']}}</div> 
        <div class="">дата бронирования: {{$log['date_bron']}}</div>  
        <div class="">номер комнаты: {{$log['number_room']}}</div> 
        <div class="">фио: {{$log['fio']}}</div> 
        <div class="">телефон: {{$log['tel']}}</div>
        <div class="">коментарий: {{$log['com']}}</div>
        @elseif($log['action'] == 'изменена цена')
        <div class=""><b>дата действия:</b> {{$log['action_log_date']}}</div>
        <div class=""><b>сотрудник:</b> {{$log['user_action']}}</div>
        <div class=""><b>действие:</b> {{$log['action']}}</div>
        <div class="">комната: {{$log['room']}}</div>
        <div class="">цена: {{$log['price']}}</div>
        <div class="">коментарий: {{$log['com']}}</div>
        @elseif($log['action'] == 'комментарий удален')
        <div class=""><b>дата действия:</b> {{$log['action_log_date']}}</div>
        <div class=""><b>сотрудник:</b> {{$log['user_action']}}</div>
        <div class=""><b>действие:</b> {{$log['action']}}</div>
        <div class="">комната: {{$log['room']}}</div>
        @elseif($log['action'] == 'комментарий изменен')
        <div class=""><b>дата действия:</b> {{$log['action_log_date']}}</div>
        <div class=""><b>сотрудник:</b> {{$log['user_action']}}</div>
        <div class=""><b>действие:</b> {{$log['action']}}</div>
        <div class="">комната: {{$log['room']}}</div>
        <div class="">коментарий: {{$log['com']}}</div>
        @elseif($log['action'] == 'добавлен месяц')
        <div class=""><b>дата действия:</b> {{$log['action_log_date']}}</div>
        <div class=""><b>сотрудник:</b> {{$log['user_action']}}</div>
        <div class=""><b>действие:</b> {{$log['action']}}</div>
        <div class="">месяц: {{$log['month']}}</div>
        @elseif($log['action'] == 'бронирование номера')
        <div class=""><b>дата действия:</b> {{$log['action_log_date']}}</div>
        <div class=""><b>сотрудник:</b> {{$log['user_action']}}</div>
        <div class=""><b>действие:</b> {{$log['action']}}</div>
        <div class="">тип бронирования: {{$log['type_action']}}</div> 
        <div class="">дата бронирования: {{$log['date_bron']}}</div>  
        <div class="">номер комнаты: {{$log['number_room']}}</div> 
        <div class="">фио: {{$log['fio']}}</div> 
        <div class="">телефон: {{$log['tel']}}</div>
        <div class="">коментарий: {{$log['com']}}</div>
        @elseif($log['action'] == 'удаление номера')
        <div class=""><b>дата действия:</b> {{$log['action_log_date']}}</div>
        <div class=""><b>сотрудник:</b> {{$log['user_action']}}</div>
        <div class=""><b>действие:</b> {{$log['action']}}</div>
        <div class="">комната: {{$log['number_room']}}</div>
        <div class="">дата удаления: {{$log['dating']}}</div>
        @elseif($log['action'] == 'обновление')
        <div class=""><b>дата действия:</b> {{$log['action_log_date']}}</div>
        <div class=""><b>сотрудник:</b> {{$log['user_action']}}</div>
        <div class=""><b>действие:</b> {{$log['action']}}</div>
        <div class=""><b>вид:</b> {{$log['vid']}}</div>
        <div class="">изменения: {{$log['edit']}}</div>
        <div class="">дата: {{$log['dating']}}</div>        
        @endif
      </div>
    </div>
  </div>
  @endforeach




</div>

@endsection
@section('page_java')
<script>
  $(document).ready(function () {

    $('.selected').select2();

  });
</script>
@endsection