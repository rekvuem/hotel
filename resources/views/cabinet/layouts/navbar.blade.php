<div class="navbar navbar-expand-md navbar-dark bg-indigo">



		<div class="collapse navbar-collapse" id="navbar-mobile">
    <ul class="navbar-nav ml-md-3 mr-md-auto">
      Кабинет управления регистрации/бронирование гостей
    </ul>

    <ul class="navbar-nav">
      <li class="nav-item dropdown dropdown-user">
        <a href="#" class="navbar-nav-link d-flex align-items-center dropdown-toggle" data-toggle="dropdown">
          <span>{{Cookie::get('fio')}}</span>
        </a>

        <div class="dropdown-menu dropdown-menu-right">
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
          <a href="#" class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="icon-exit3"></i>
            <span> 
              {{ __('Выход') }}
            </span>
          </a>
        </div>
      </li>
    </ul>
		</div>
</div>
<!-- /main navbar -->