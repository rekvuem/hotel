<select name="room" class="form-control selected">
  <option>Выбрать...</option>
  @foreach($getRoom as $roomus)
  <option value="{{$roomus->id_room}}">{{$roomus->room}} (<b>{{$roomus->price}} грн.</b>)</option>
  @endforeach
</select>

<script src="{{ asset('theme/global_assets/js/plugins/forms/selects/select2.min.js') }}" type="text/javascript"></script>
<script>
$(document).ready(function () {
  $('.selected').select2();

    $('select[name=room]').change('click', function () {
      var get_korpus = $('.takeKorpus').val();
      var data_range = $('.getDate_start').val();
      var take_new_room = $(this).val();
      
      $('.reverse').hide();
      
      $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        method: 'GET',
        url: "{{ route('cabinet.shownoneroom') }}",
        data: {
          roomid:take_new_room,
          korpus: get_korpus, 
          daterange: data_range
        },
        success: function (data) {
          $('.reverse_room').html(data);
        }
      });
      
    });
  
});
</script>