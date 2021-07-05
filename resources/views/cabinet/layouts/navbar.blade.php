<div class="navbar navbar-expand-md navbar-dark bg-indigo">

		<div class="d-md-none">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
      <i class="icon-tree5"></i>
    </button>
		</div>

		<div class="collapse navbar-collapse" id="navbar-mobile">
    <ul class="navbar-nav ml-md-3 mr-md-auto">
      <li class="nav-item dropdown">
        <a href="#" class="navbar-nav-link dropdown-toggle caret-0" data-toggle="dropdown">
          <i class="icon-people"></i>
          <span class="d-md-none ml-2">Users</span>
          <span class="badge badge-mark border-orange-400 ml-auto ml-md-0"></span>
        </a>

        <div class="dropdown-menu dropdown-content wmin-md-300">
          <div class="dropdown-content-header">
            <span class="font-weight-semibold">Users online</span>
            <a href="#" class="text-default"><i class="icon-search4 font-size-base"></i></a>
          </div>

          <div class="dropdown-content-body dropdown-scrollable">
            <ul class="media-list">
            </ul>
          </div>

          <div class="dropdown-content-footer bg-light">
            <a href="#" class="text-grey mr-auto">All users</a>
            <a href="#" class="text-grey"><i class="icon-gear"></i></a>
          </div>
        </div>
      </li>

      <li class="nav-item dropdown">
        <a href="#" class="navbar-nav-link dropdown-toggle caret-0" data-toggle="dropdown">
          <i class="icon-pulse2"></i>
          <span class="d-md-none ml-2">Activity</span>
          <span class="badge badge-mark border-orange-400 ml-auto ml-md-0"></span>
        </a>

        <div class="dropdown-menu dropdown-content wmin-md-350">
          <div class="dropdown-content-header">
            <span class="font-weight-semibold">Latest activity</span>
            <a href="#" class="text-default"><i class="icon-search4 font-size-base"></i></a>
          </div>

          <div class="dropdown-content-body dropdown-scrollable">
            <ul class="media-list">
            </ul>
          </div>

          <div class="dropdown-content-footer bg-light">
            <a href="#" class="text-grey mr-auto">All activity</a>
            <div>
              <a href="#" class="text-grey" data-popup="tooltip" title="Clear list"><i class="icon-checkmark3"></i></a>
              <a href="#" class="text-grey ml-2" data-popup="tooltip" title="Settings"><i class="icon-gear"></i></a>
            </div>
          </div>
        </div>
      </li>
    </ul>

    <ul class="navbar-nav">
      <li class="nav-item dropdown dropdown-user">
        <a href="#" class="navbar-nav-link d-flex align-items-center dropdown-toggle" data-toggle="dropdown">
          <span>Victoria</span>
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