<nav class="navbar">
  <a href="#" class="sidebar-toggler">
    <i data-feather="menu"></i>
  </a>
  <div class="navbar-content">
    <ul class="navbar-nav">
      <li class="nav-item dropdown nav-profile">
        <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
         {{-- <a href="{{ url('/edit_password' , Auth::user()->id)}}" class="p-2 flex items-center">
          <i data-feather="user"></i><span>Change Password</span>
        </a>
        <a href="{{ url('/logout')}}" class="p-2 flex items-center">
          <span class="p-0 pr-1 pt-1 text-muted">LOGOUT</span>
          <i data-feather="log-out"></i>
        </a> --}}
        <div class="figure">
          <img src="{{ url('https://icon-library.com/images/avatar-icon-png/avatar-icon-png-25.jpg') }}" alt="">
        </div>
      </a>
      <div class="dropdown-menu" aria-labelledby="profileDropdown">
        <div class="dropdown-header d-flex flex-column align-items-center">
          <div class="figure mb-3">
            <img src="{{ url('https://icon-library.com/images/avatar-icon-png/avatar-icon-png-25.jpg') }}" alt="">
          </div>
          <div class="info text-center">
            <p class="name font-weight-bold mb-0">{{ session()->get('user')['name'] }}</p>
            <p class="email text-muted mb-3">{{ session()->get('user')['nip'] }}</p>
          </div>
        </div>

        <div class="dropdown-body">
          <ul class="profile-nav p-0 pt-3">
            <li class="nav-item">
              <a href="{{ url('/edit_password' , Auth::user()->id) }}" class="nav-link">
                <i data-feather="user"></i>
                <span>Edit Password</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="/logout" class="nav-link">
                <i data-feather="log-out"></i>
                <span>Log Out</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </li>
  </ul>
</div>

</nav>