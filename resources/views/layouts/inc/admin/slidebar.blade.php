<!-- partial:partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
      <li class="nav-item">
        <a class="nav-link" href="dashboard">
          <i class="mdi mdi-home menu-icon"></i>
          <span class="menu-title">Dashboard</span>
        </a>
      </li>
      <li class="nav-item {{$user_role != 1 ? 'd-none' : ''}}">
        <a class="nav-link" href="{{ route('users') }}">
          <i class="mdi mdi-account-multiple menu-icon"></i>
          <span class="menu-title">Users</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('inventory') }}">
          <i class="mdi mdi-grid-large menu-icon"></i>
          <span class="menu-title">Inventory</span>
        </a>
      </li>
    </ul>
</nav>
<!-- partial -->