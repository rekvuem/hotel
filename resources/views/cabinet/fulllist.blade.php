@extends('cabinet.layouts.index')
@section('title', 'Полный список занятости')
@section('content')
<style>
  .pace-demo {
    position: fixed;
    top: 50%;
    right: 50%;
    bottom: 50%;
    left: 50%;
    background-color: #37474f;
    z-index: 1000;
  }
  .pace_activity {
    position: absolute;
    top: 50%;
    left: 50%;

  }
</style>
<div class="preloader">
  <div class="pace-demo">
    <div class="theme_squares">
      <div class="pace_activity"></div>
    </div>
  </div>
</div>


<div class="row">
  <div class="col-12">
    <table class="table table-bordered table-responsive datatable-basic">
      <thead>
        <tr class="text-center text-bold bg-slate-700" style="font-size: 1.3em; ">
          <th>Дні</th>
          @foreach($TakeRoom as $room) 
          <th>{{ $room->room }}</th>
          @endforeach  
        </tr>
      </thead>
      <tbody> 
        @for ($i = 1; $i <= $carbon_days; $i++) 
        <tr>        
          <td class="bg-slate-700">{{$i}}</td>
          @foreach($takemyroom as $bron)
          @php
          switch ($bron['takeVid']){
          case 'заселен': $takeVidType= 'bg-teal-800';
          break;
          case 'забронирован': $takeVidType= 'bg-brown-800';
          break;
          case 'выселен' : $takeVidType= 'bg-grey-800';
          break;
          case 'свободно': $takeVidType= 'bg-white';
          break;
          case 'уборка': $takeVidType= 'bg-blue-800';
          break;
          case 'ремонт': $takeVidType= 'bg-danger-800';
          break;
          default: $takeVidType= ' ';
          break;
          }
          @endphp

          @if($bron['day'] == $i)
          @if($bron['bron'] == null)
          <td class="{{$takeVidType}}" style="cursor: pointer">

            <a href="#" 
               class="btn-icon takeday_information text-purple-800" 
               data-room="{{ $bron['roomid'] }}" 
               data-month="{{ $bron['monthid'] }}"
               data-rangedate="{{ $bron['day'] }}.{{ $bron['month'] }}"
               data-toggle="modal" 
               data-target="#modal_theme_bg_custom"><i class="icon-pencil5"></i></a>

          </td>
          @elseif($bron['takeVid'] == 'ремонт')
          <td class="{{$takeVidType}}" 
              style="cursor: pointer; font-weight: bold; font-size: 1.1em; font-style: italic">
            <span class="float-left">ремонт комнаты</span>
            <span class="float-right delete" 
                  data-bron="{{ $bron['bron'] }}"
                  data-room="{{ $bron['roomid'] }}"
                  data-start="{{ $bron['start_date'] }}"
                  data-end="{{ $bron['end_date'] }}"
                  ><i class="mi-delete"></i></span>
          </td>
          @elseif($bron['takeVid'] == 'уборка')

          <td class="{{$takeVidType}}" 
              style="cursor: pointer; font-weight: bold; font-size: 1.1em; font-style: italic">
            <span class="float-left">уборка комнаты</span>
            <span class="float-right delete" 
                  data-bron="{{ $bron['bron'] }}"
                  data-room="{{ $bron['roomid'] }}"
                  data-start="{{ $bron['start_date'] }}"
                  data-end="{{ $bron['end_date'] }}"
                  ><i class="mi-delete"></i></span>
          </td>

          @else 
          <td class="{{$takeVidType}}">
            <div title="тип заннятости" class="changeTypeVid" 
                 data-bron="{{ $bron['bornid'] }}"
                 data-toggle="modal" 
                 data-target="#modal_edit_vid"
                 style="cursor: pointer; width: 150px; font-style: italic; font-weight: bold;">
              {{ $bron['takeVid'] }}              
            </div>
            <div class="" title="Имя Фамилия гостя" style="font-weight: bold;">{{ $bron['fio'] }}</div>
            <div class="" title="телефон">{{ $bron['telehon'] }}</div>
            <div class="" title="комментарий">{{ $bron['comment'] }}</div>
            <div class="text-center ">  
              <span class="delete"   
                    data-bron="{{ $bron['bron'] }}"
                    data-room="{{ $bron['roomid'] }}"
                    data-start="{{ $bron['start_date'] }}"
                    data-end="{{ $bron['end_date'] }}"><i class="mi-delete text-danger-300"></i></span>   
            </div>
          </td>
          @endif
          @endif
          @endforeach
        </tr>
        @endfor 
      </tbody>          
    </table>
  </div>
</div>

<div id="modal_theme_bg_custom" class="modal fade" tabindex="-1">
  <div class="modal-dialog">
    <form action="" method="POST">
      <div class="modal-content">
        <div class="modal-header bg-blue-800">
          <h5 class="modal-title">Быстрая форма редактирования</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">
          <input type="hidden" id="roomid" name="roomid" class="form-control" value="">
          <input type="hidden" id="monthid" name="monthid" class="form-control" value="">

          <div class="row">
            <div class="col-12">
              <div class="form-group">
                <label><b>Выбрать промежуток дат:</b></label>
                <input type="text" id="rangeDate" name="takeBron_range" class="form-control daterange-locale"  value="">

              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="form-group">
                <select name="takeVid" class="form-control select2 viddea">
                  <option value="">Выбрать тип действия с номером...</option>   
                  <option value="забронирован">забронировать</option>
                  <option value="заселен">заселение</option>
                  <option value="уборка">уборка комнат</option>
                  <option value="ремонт">ремонт комнат</option>
                </select>
              </div>
            </div>
          </div>
          <div class="show_info_bron"> </div>
          <div class="show_info_live"> </div>
          <div class="show_info_delete"> 
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-link text-danger-800" data-dismiss="modal" onclick="location.reload(true);">Отмена</button>
          <button type="button" class="btn bg-success">Сохранить</button>
        </div>
      </div>

    </form>
  </div>
</div>

<div id="modal_edit_vid" class="modal fade" tabindex="-1">
  <div class="modal-dialog">
    <form action="" method="POST">
      <div class="modal-content">
        <div class="modal-header bg-blue-800">
          <h5 class="modal-title">Изменить вид деятельности</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="takeUPDbron" name="bronka" class="form-control" value="">
          <div class="row">
            <div class="col-12">
              <div class="form-group">
                <select name="takeNewVid" class="form-control select2">
                  <option value="">Выбрать тип действия с номером...</option>   
                  <option value="забронирован">забронировать</option>
                  <option value="заселен">заселение</option>
                  <option value="выселен">высиление</option>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-link text-danger-800" data-dismiss="modal" onclick="location.reload(true);">Отмена</button>
          <button type="button" class="btn bg-success-600 saveTyper">Сохранить</button>
        </div>
      </div>

    </form>
  </div>
</div>
@endsection
@section('page_java')
<script src="{{ asset('theme/global_assets/js/plugins/ui/moment/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('theme/global_assets/js/plugins/pickers/daterangepicker.js') }}" type="text/javascript"></script>
<script src="{{ asset('theme/global_assets/js/plugins/tables/datatables/datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('theme/global_assets/js/plugins/forms/inputs/inputmask/jquery.inputmask.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('theme/global_assets/js/plugins/forms/selects/select2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('theme/global_assets/js/plugins/notifications/bootbox.min.js') }}"></script>
<script>
              $(window).on('load', function(){
                                var $preloader = $('.pace-demo'),
                        $loader = $preloader.find('.pace_activity');
                $loader.fadeOut();
                $preloader.delay(250).fadeOut(200);
                $('.preloader').delay(250).fadeOut(200);
              });
            $(document).ready(function () {

//////////////////////////////////////////////////////////////////////////////////
              $('.datatable-basic').DataTable({
                fixedHeader: {
                  header: true,
                  footer: true
                },
                autoWidth: true,
                responsive: true,
                stateSave: true,
                searching: false,
                lengthChange: false,
                info: false,
                ordering: false,
                paginate: false,
                pageLength: 31,
                dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
                language: {
                  paginate: {'first': 'First', 'last': 'Last', 'next': '→', 'previous': '←'}
                }
              });
//////////////////////////////////////////////////////////////////////////////////////////////////////////
              $('.select2').select2({
                minimumResultsForSearch: Infinity
              });
//////////////////////////////////////////////////////////////////////////////////////////////////////////
              $('.daterange-locale').daterangepicker({
                applyClass: 'btn-sm btn-success',
                cancelClass: 'btn-sm btn-light',
                minDate: '01.07.2021',
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
//////////////////////////////////////////////////////////////////////////////////////////////////////////
              $('.takeday_information').on('click', function () {
                var take_rangedate_info = $(this).data('rangedate');
                var id_room = $(this).data('room');
                var id_month = $(this).data('month');
                $('#rangeDate').val(take_rangedate_info + ' - ' + take_rangedate_info);
                $('#roomid').val(id_room);
                $('#monthid').val(id_month);
              });
//////////////////////////////////////////////////////////////////////////////////////////////////////////             
              $('.viddea').on('change', function () {
                var changeVid = $(this).val();

                if (changeVid == 'забронирован') {
                  $('.show_info_bron').show();
                  $('.show_info_live').hide();
                  $('.show_info_bron').html('<div class="row"><div class="col-12"><div class="form-group"><input type="text" name="fio" class="form-control" value="" placeholder="Имя Фамилия" required=""></div></div><div class="col-12"><div class="form-group"><input class="form-control" type="text" name="telephon" placeholder="Телефон" value="" required=""></div></div><div class="col-12"><div class="form-group"><textarea name="forText" class="form-control"></textarea></div></div></div>');
                } else if (changeVid == 'заселен') {
                  $('.show_info_live').show();
                  $('.show_info_bron').hide();
                  $('.show_info_live').html('<div class="row"><div class="col-12"><div class="form-group"><input type="text" name="fio" class="form-control" value="" placeholder="Имя Фамилия" required=""></div></div><div class="col-12"><div class="form-group"><input class="form-control" type="text" name="telephon" placeholder="Телефон" value="" required=""></div></div><div class="col-12"><div class="form-group"><textarea name="forText" class="form-control"></textarea></div></div></div>');
                } else if (changeVid == 'уборка') {
                  $('.show_info_bron').hide();
                  $('.show_info_live').hide();
                } else if (changeVid == 'ремонт') {
                  $('.show_info_bron').hide();
                  $('.show_info_live').hide();
                } else if (changeVid == 'очистить') {
                  $('.show_info_bron').hide();
                  $('.show_info_live').hide();
                }
              });
//////////////////////////////////////////////////////////////////////////////////////////////////////////
              $('.bg-success').click(function () {
                var take_room_info = $('input[name="roomid"]').val();
                var take_month_info = $('input[name="monthid"]').val();
                var input_fio = $('input[name="fio"]').val();
                var input_telepon = $('input[name="telephon"]').val();
                var input_vid = $('select[name="takeVid"]').val();
                var input_texxt = $('textarea[name="forText"]').val();
                var input_range_date = $('#rangeDate').val();


                $.ajax({
                  headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                  method: 'POST',
                  url: "{{ route('cabinet.insertFastBron') }}",
                  data: {
                    roomid: take_room_info,
                    monthid: take_month_info,
                    takeBron_range: input_range_date,
                    takeVid: input_vid,
                    fio: input_fio,
                    telephon: input_telepon,
                    forText: input_texxt
                  },
                  success: function () {
                    bootbox.alert({
                      title: 'Добавлено!',
                      message: 'Внесены изменения ' + input_range_date + '',
                      callback: function () {
                        $('.takeday_information').hide();
                        setTimeout("location.reload(true);", 100);
                      }
                    }).init(function () {
                      $(".bootbox.modal").find(".modal-header").addClass('bg-teal-800');
                      $(".bootbox.modal").find(".modal-body").addClass('bg-teal-700');
                      $(".bootbox.modal").find(".modal-footer").addClass('bg-teal-700');
                      $(".bootbox.modal").find(".btn-primary").removeClass().addClass('btn bg-teal-800');
                    });

                  }
                });
              });
////////////////////////////////////////очистить комнаты от записи////////////////////////////////////////
              $('.delete').on('click', function () {
                var take_bronid = $(this).data('bron');
                var take_room = $(this).data('room');
                var take_start_date = $(this).data('start');
                var take_end_date = $(this).data('end');

                bootbox.dialog({
                  message: 'Удалить/очистить',
                  title: 'Вы уверены что хотите очистить запись комнаты',
                  buttons: {
                    danger: {
                      label: 'Нет',
                      className: 'btn-danger bg-danger-700',
                      callback: function () {
                        setTimeout("location.reload(true);", 100);
                      }
                    },
                    success: {
                      label: 'Да',
                      className: 'btn-success bg-success-800',
                      callback: function () {
                        bootbox.alert({
                          title: 'Комната!',
                          message: 'Данная комната была освобождена!',
                          callback: function () {

                            $.ajax({
                              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                              method: 'POST',
                              url: "{{ route('cabinet.deleteTypeBron') }}",
                              data: {
                                _method: "DELETE",
                                bronus: take_bronid,
                                room: take_room,
                                start_date: take_start_date,
                                end_date: take_end_date
                              },
                              success: function () {
                                setTimeout("location.reload(true);", 100);
                              }
                            });
                          }
                        });
                      }
                    }
                  }
                }).init(function () {
                  $(".bootbox.modal").find(".modal-header").addClass('bg-danger-800');
                  $(".bootbox.modal").find(".modal-body").addClass('bg-danger-700');
                  $(".bootbox.modal").find(".modal-footer").addClass('bg-danger-700');
                  $(".bootbox.modal").find(".btn-primary").removeClass().addClass('btn bg-danger-800');
                });
              });
////////////////////////////////////////изменить тип заняттости///////////////////////////////////////////
              $('.changeTypeVid').on('click', function () {
                var bronid = $(this).data('bron');
                $('#takeUPDbron').val(bronid);
              });
////////////////////////////////сохранение данных бронирования (типа занятости)///////////////////////////
              $('.saveTyper').on('click', function () {
                var input_bronid_hidden = $('input[name="bronka"]').val();
                var input_vid = $('select[name="takeNewVid"]').val();

                $.ajax({
                  headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                  method: 'POST',
                  url: "{{ route('cabinet.updateTypeBron') }}",
                  data: {
                    bron: input_bronid_hidden,
                    takeVid: input_vid
                  },
                  success: function (data) {
                    bootbox.alert({
                      title: 'Статус',
                      message: 'Статус бронирования/заселения/выселения изменен',
                      callback: function () {
//                        console.log(data);
                        setTimeout("location.reload(true);", 100);
                      }
                    }).init(function () {
                      $(".bootbox.modal").find(".modal-header").addClass('bg-teal-800');
                      $(".bootbox.modal").find(".modal-body").addClass('bg-teal-700');
                      $(".bootbox.modal").find(".modal-footer").addClass('bg-teal-700');
                      $(".bootbox.modal").find(".btn-primary").removeClass().addClass('btn bg-teal-800');
                    });

                  }
                });


              });
            });
</script>
@endsection