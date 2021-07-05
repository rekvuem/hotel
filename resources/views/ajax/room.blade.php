<select name="room" class="form-control selected" id="roomed">
  <option>Выбрать...</option>
  @foreach($Room as $rom)
  <option data-id="{{$rom->id}}" value="{{$rom->id}}">{{$rom->room}}</option>
  @endforeach
</select>

<script src="{{ asset('theme/global_assets/js/plugins/forms/selects/select2.min.js') }}" type="text/javascript"></script>
<script>
$(document).ready(function () {
  $('.selected').select2();
});
</script>