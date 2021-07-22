@extends('cabinet.layouts.index')
@section('title', 'Полный список занятости')
@section('content')
<div class="result"></div>
<div class="row">
  <div class="col-12">
    <div class="card">
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
            <td class="{{$takeVidType}}">
              <div class="">
              <a href="#" 
                 class=" btn-icon bootbox_form text-purple-800" 
                 data-room="{{ $bron['roomid'] }}" 
                 data-month="{{ $bron['monthid'] }}" 
                 data-bron="{{ $bron['bornid'] }}"
                 data-toggle="modal" 
                 data-target="#modal_theme_bg_custom"><i class="icon-pencil5"></i></a>
              </div>
            </td>
            @elseif($bron['takeVid'] == 'уборка')
            <td class="{{$takeVidType}}" style="font-weight: bold; font-size: 1.1em; font-style: italic">
              уборка
            </td>
            @else
            <td class="{{$takeVidType}}">
              <div class="selectVid" 
                   data-bron="{{ $bron['bornid'] }}" 
                   title="тип заннятости" 
                   style="width: 150px; font-style: italic; font-weight: bold;">
                {{ $bron['takeVid'] }}
              </div>
              <div class="" title="Имя Фамилия гостя" style="font-weight: bold;"> {{ $bron['fio'] }}</div>
              <div class="" title="телефон"> {{ $bron['telehon'] }}</div>
              <div class="" title="комментарий"> {{ $bron['comment'] }}</div>
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

   
//////////////////////////////////////////////////////////////////////////////////
  $('.bootbox_form').on('click', function () {

    var room = $(this).data('room');
    var month = $(this).data('month');
    window.location.href = $(this).attr('href');
    bootbox.dialog({
      title: 'Быстрая форма регистрации гостя',
      message: '<div class="row"><div class="col-12">'
              + '<form action="{{ route("cabinet.insertFastBron") }}" method="POST">'
              + '@csrf'
              + '<input type="hidden" name="roomid" class="form-control" value="' + room + '">'
              + '<input type="hidden" name="monthid" class="form-control" value="' + month + '">'
              + '<div class="row">'
              + '<div class="col-12">'
              + '<div class="from-group">'
              + '<input type="text" name="takeBron_range" class="form-control daterange-locale"  value="">'
              + '</div>'
              + '</div>'
              + '</div>'
              + '<div class="row"><div class="col-12"><div class="form-group">'
              + '<input type="text" name="fio" class="form-control" value="" placeholder="Имя Фамилия" >'
              + '</div>'
              + '<div class="form-group">'
              + '<input id="number_mobile" class="form-control" type="text" name="telephon" placeholder="Телефон" value="">'
              + '</div>'
              + '<div class="form-group">'
              + '<select name="takeVid" class="form-control select2">'
              + '<option value="забронирован">забронировать</option>'
              + '<option value="заселен">заселены</option>'
              + '<option value="уборка">уборка комнаты</option>'
              + '<option value="ремонт">ремонт комнаты</option>'
              + '</select>'
              + '</div>'
              + '<div class="form-group">'
              + '<textarea name="forText" class="form-control"></textarea>'
              + '</div></div></div>'
              + '</form>'
              + '</div></div>',
      buttons: {
        cancel: {
          label: 'отмена',
          className: 'btn-danger',
          callback: function () {
            setTimeout("location.reload(true);", 100);
          }
        },
        success: {
          label: 'изменить',
          className: 'btn-success',
          callback: function (data) {
            var input_room_id = $('input[name="roomid"]').val();
            var input_month_id = $('input[name="monthid"]').val();
            var input_range_date = $('input[name="takeBron_range"]').val();
            var input_fio = $('input[name="fio"]').val();
            var input_telepon = $('input[name="telephon"]').val();
            var input_vid = $('select[name="takeVid"]').val();
            var input_texxt = $('textarea[name="forText"]').val();
            $.ajax({
              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
              method: 'POST',
              url: "{{ route('cabinet.insertFastBron') }}",
              data: {roomid: input_room_id, monthid: input_month_id, takeBron_range: input_range_date, takeVid: input_vid, fio: input_fio, telephon: input_telepon, forText: input_texxt},
              success: function () {
                bootbox.alert({
                  title: 'Добавлено!',
                  message: 'Бронирование/заселение добавлено с '+input_range_date+'',
                  callback: function(){
                    setTimeout("location.reload(true);", 100);
                  }
                });

              }
            });
          }
        }

      }
    }
    ).on('shown.bs.modal', function () {

      $('#number_mobile').inputmask("+38(099) 999-99-99");
      $('.select2').select2({
        minimumResultsForSearch: Infinity
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
    }).init(function () {
      $(".bootbox.modal").find(".modal-header").addClass('bg-blue-800');
    });
  });
//////////////////////////////////////////////////////////////////////////////////
//  $('.empty_bron').on('click', function () {
//    var empty_clean = $(this).data('clean');
//    var empty_clean_room = $(this).data('room');
//
//    bootbox.prompt({
//      title: "Выбрать тип заннятости!",
//      inputType: 'select',
//      className: 'text-brown-300 select2',
//      locale: 'ru',
//      multiple: false,
//      buttons: {
//        confirm: {
//          label: 'изменить',
//          className: 'bg-green-600'
//        },
//        cancel: {
//          label: 'отмена',
//          className: 'bg-danger-400'
//        }
//      },
//      inputOptions: [
//        {
//          text: 'Выбрать...',
//          value: '',
//        },
//        {
//          text: 'уборка',
//          value: 'уборка',
//        }
//      ],
//      callback: function (result) {
//
//        if (result == 'уборка') {
//          $.ajax({
//            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
//            method: 'POST',
//            url: "{{ route('cabinet.insertAjaxBron') }}",
//            data: {_method: 'POST', id: empty_clean, room: empty_clean_room},
//            success: function () {
//              setTimeout("location.reload(true);", 100);
//            },
//            error: function () {
//              console.log('ошибка');
//            }
//          });
//        }
//
//      }
//    }).init(function() {
//      $(".bootbox.modal").find(".modal-header").addClass('bg-blue-800');
//  });
//
//  });
//////////////////////////////////////////////////////////////////////////////////
  $('.selectVid').on('click', function () {
    var broning = $(this).data('bron');
    bootbox.prompt({
      title: "Выбрать тип заннятости!",
      inputType: 'select',
      className: 'text-brown-300',
      locale: 'ru',
      multiple: false,
      buttons: {
        confirm: {
          label: 'изменить',
          className: 'bg-green-600'
        },
        cancel: {
          label: 'отмена',
          className: 'bg-danger-400'
        }
      },
      inputOptions: [
        {
          text: 'Выбрать...',
          value: '',
        },
        {
          text: 'забронированно',
          value: 'забронирован',
        },
        {
          text: 'заселен',
          value: 'заселен',
        },
        {
          text: 'выселен',
          value: 'выселен',
        }
      ],
      callback: function (result) {

        if (result == 'забронирован' || result == 'заселен' || result == 'выселен') {
          $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            method: 'POST',
            url: "{{ route('cabinet.updateTypeBron') }}",
            data: {_method: 'PUT', idtype: broning, optionType: result},
            success: function () {
              setTimeout("location.reload(true);", 100);
            },
            error: function () {
              console.log('ошибка');
            }
          });
        }

      }
    });
  });
});
</script>
@endsection