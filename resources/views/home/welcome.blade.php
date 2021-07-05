@extends('home.layouts.index')
@section('title','Главная страница')
@section('content')

<div class="content d-flex justify-content-center align-items-center">
  <form method="POST" action="{{ route('login') }}" class="login-form">
    @csrf
    <div class="card mb-0">
						<div class="card-body">
        <div class="text-center mb-3">
          <i class="icon-people icon-2x text-warning-400 border-warning-400 border-3 rounded-round p-3 mb-3 mt-1"></i>
          <h5 class="mb-0">{{ __('Авторизация') }}</h5>
        </div>

        <div class="form-group form-group-feedback form-group-feedback-left">
          <input type="text"
                 id="email"
                 name="email"
                 class="form-control"
                 placeholder="{{ __('E-Mail') }}" 
                 value="{{ old('email') }}" 
                 autocomplete="email" required autofocus>
          <div class="form-control-feedback">
            <i class="icon-user text-muted"></i>
          </div>
        </div>

        <div class="form-group form-group-feedback form-group-feedback-left">
          <input 
            type="password" 
            name="password"
            class="form-control" 
            placeholder="{{ __('Пароль') }}" 
            autocomplete="current-password">
          <div class="form-control-feedback">
            <i class="icon-lock2 text-muted"></i>
          </div>
        </div>

        <div class="form-group d-flex align-items-center">
          <div class="form-check mb-0">
            <label class="form-check-label">
              <input type="checkbox" name="remember" class="form-input-styled" id="remember" {{ old('remember') ? 'checked' : '' }} data-fouc \>
              запомнить
            </label>
          </div>
        </div>

        <div class="form-group">
          <button type="submit" class="btn btn-primary btn-block">Войти <i class="icon-circle-right2 ml-2"></i></button>
        </div>  

						</div>
    </div>    
  </form>
  
</div>
@endsection