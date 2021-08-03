<div class="row">
  
  @foreach($freeshown as $show)

  @if($show['vid'] == null)
  <div class="card rounded-0 bg-blue-800 mt-0 pt-0 mb-0 pb-0">
    <div class="card-header m-1 p-1" style="font-size: 1.2em;">{{$show['date']}}</div>
  </div>
  @else
  <div class="card rounded-0 bg-teal-800 mt-0 pt-0 mb-0 pb-0 toggle-popover-method" 
       data-popup="popover" 
       title="{{$show['bron_st_date']}} - {{$show['bron_en_date']}}" 
       data-html="true" 
       data-content="имя:{{$show['fio']}} <br>тел:{{$show['tel']}} <br>комментарий:{{$show['com']}}">
    <div class="card-header m-1 p-1" style="font-size: 1.2em">{{$show['date']}}</div>
  </div>
  @endif

  @endforeach
</div>


<script>
$(document).ready(function () {
		$('.toggle-popover-method').on('click', function() {
			$(this).popover('hover');
		});
});
</script>