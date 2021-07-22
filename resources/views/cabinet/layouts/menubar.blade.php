	<div class="navbar navbar-expand-md navbar-light">
		<div class="text-center d-md-none w-100">
			<button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse" data-target="#navbar-navigation">
				<i class="icon-unfold mr-2"></i>
				Навигация
			</button>
		</div>

		<div class="navbar-collapse collapse" id="navbar-navigation">
			<ul class="navbar-nav navbar-nav-highlight">
				<li class="nav-item">
					<a href="{{route('cabinet.dashboard')}}" class="navbar-nav-link">
						<i class="icon-home4 mr-2"></i>
						Главная
					</a>
				</li>

				<li class="nav-item dropdown">
					<a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">
						<i class="icon-strategy mr-2"></i>
						Корпус №1
					</a>
					<div class="dropdown-menu">
						<a href="{{ route('cabinet.korpus', ['korpus'=>1]) }}" class="dropdown-item"><i class="icon-align-center-horizontal"></i> Комнаты по отдельности</a>
      <a href="{{ route('cabinet.fullShowRoom', ['korpus'=>1]) }}" class="dropdown-item"><i class="icon-align-center-horizontal"></i> Полный список</a>
					</div>
				</li>
    
				<li class="nav-item dropdown">
					<a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">
						<i class="icon-strategy mr-2"></i>
						Корпус №2
					</a>
					<div class="dropdown-menu">
						<a href="{{ route('cabinet.korpus', ['korpus'=>2]) }}" class="dropdown-item"><i class="icon-align-center-horizontal"></i> Комнаты по отдельности</a>
      <a href="{{ route('cabinet.fullShowRoom', ['korpus'=>2]) }}" class="dropdown-item"><i class="icon-align-center-horizontal"></i> Полный список</a>
					</div>
				</li>
    
				<li class="nav-item dropdown">
					<a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">
						<i class="icon-strategy mr-2"></i>
						Корпус №3
					</a>
					<div class="dropdown-menu">
						<a href="{{ route('cabinet.korpus', ['korpus'=>3]) }}" class="dropdown-item"><i class="icon-align-center-horizontal"></i> Комнаты по отдельности</a>
      <a href="{{ route('cabinet.fullShowRoom', ['korpus'=>3]) }}" class="dropdown-item"><i class="icon-align-center-horizontal"></i> Полный список</a>
					</div>
				</li>
   
				<li class="nav-item">
					<a href="{{route('cabinet.setting')}}" class="navbar-nav-link">
						<i class="icon-gear mr-2"></i>
						Настройки
					</a>
				</li>
    
				<li class="nav-item">
					<a href="#" class="navbar-nav-link">
						<i class="mi-help-outline mr-2"></i>
      Активный месяц: {{Cookie::get('month_year_text')}}
					</a>
				</li>
			</ul>

		</div>
	</div>