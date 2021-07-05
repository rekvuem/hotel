@foreach ($errors->all() as $error)
  <div class="alert bg-success text-white alert-styled-left alert-dismissible">
    <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
    <span class="font-weight-semibold">{{ $error }}</span>
  </div>
@endforeach

@if(session('add'))
  <div class="alert bg-info-700 text-white alert-styled-left alert-dismissible">
    <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
    <span class="font-weight-semibold">{{ session('add') }}</span>
  </div>
@endif

@if(session('update'))
  <div class="alert bg-info-700 text-white alert-styled-left alert-dismissible">
    <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
    <span class="font-weight-semibold">{{ session('update') }}</span>
  </div>
@endif

@if(session('info'))
  <div class="alert bg-info-700 text-white alert-styled-left alert-dismissible">
    <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
    <span class="font-weight-semibold">{{ session('info') }}</span>
  </div>
@endif