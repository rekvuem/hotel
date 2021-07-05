@foreach ($errors->all() as $error)
  <div class="alert bg-danger-800 text-white alert-styled-left alert-dismissible rounded-0">
    <span class="font-weight-semibold">{{ $error }}</span>
  </div>
@endforeach

@if(session('info'))
  <div class="alert bg-info-700 text-white alert-styled-left alert-dismissible">
    <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
    <span class="font-weight-semibold">{{ session('info') }}</span>
  </div>
@endif

@if(session('add'))
  <div class="alert alert-success bg-success-700 text-white alert-styled-left alert-dismissible">
    <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
    <span class="font-weight-semibold">{{ session('add') }}</span>
  </div>
@endif

@if(session('update'))
  <div class="alert alert-slate bg-slate-600 text-white alert-styled-left alert-dismissible">
    <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
    <span class="font-weight-semibold">{{ session('update') }}</span>
  </div>
@endif

@if(session('delete'))
  <div class="alert alert-danger bg-danger-600 text-white alert-styled-left alert-dismissible">
    <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
    <span class="font-weight-semibold">{{ session('delete') }}</span>
  </div>
@endif