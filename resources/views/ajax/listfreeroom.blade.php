<select name="room" class="form-control selected">
  <option>Выбрать...</option>
  @foreach($freeshown as $rooms)
  <option value="{{$rooms['roomid']}}">{{$rooms['room']}} ({{$rooms['date']}})</option>
  @endforeach
</select>
  
<script src="{{ asset('theme/global_assets/js/plugins/forms/selects/select2.min.js') }}" type="text/javascript"></script>
<script>
$(document).ready(function () {
  $('.selected').select2();
});
</script>