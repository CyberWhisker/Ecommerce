<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
<!-- partial:partials/_navbar.html -->
<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="navbar-brand-wrapper d-flex justify-content-center">
      <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">  
        <a class="navbar-brand brand-logo" href="{{ route('admin.dashboard') }}">Admin</a>
        <a class="navbar-brand brand-logo-mini" href="index.html"><img src="images/logo-mini.svg" alt="logo"/></a>
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="mdi mdi-sort-variant"></span>
        </button>
      </div>  
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
      <ul class="navbar-nav mr-lg-4 w-100">
        <li class="nav-item nav-search d-none d-lg-block w-100">
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text" id="search">
                <i class="mdi mdi-magnify"></i>
              </span>
            </div>
            <input type="text" class="form-control" placeholder="Search now" aria-label="search" aria-describedby="search" id="searchBar">
          </div>
        </li>
      </ul>
      <button type="submit" class="btn btn-primary" id="searchBtn" style="margin-left: 10px;">Search</button>
      <ul class="navbar-nav navbar-nav-right">
        
        <li class="nav-item nav-profile dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" id="profileDropdown">
            <!-- <img src="images/faces/face5.jpg" alt="profile"/> -->
            <span class="nav-profile-name">{{ Auth::user()->first_name }} {{ substr(Auth::user()->middle_name, 0, 1) }}. {{ Auth::user()->last_name }}</span>
          </a>
          <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
            <a class="dropdown-item" href="{{ route('profile.edit')}}">
              <i class="mdi mdi-settings text-primary"></i>
              Settings
            </a>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <a class="dropdown-item" onclick="event.preventDefault(); this.closest('form').submit();">
                <i class="mdi mdi-logout text-primary"></i>
                Logout
              </a>
            </form>
          </div>
        </li>
      </ul>
      <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
        <span class="mdi mdi-menu"></span>
      </button>
    </div>
  </nav>
  <!-- partial -->
</nav>