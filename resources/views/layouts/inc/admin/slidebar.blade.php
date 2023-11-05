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
      <li class="nav-item {{$user_role != 1 ? 'd-none' : ''}}">
        <a class="nav-link" href="{{ route('inventory') }}">
          <i class="bi bi-list-task menu-icon"></i>
          <span class="menu-title">Inventory</span>
        </a>
      </li>
      <li class="nav-item {{$user_role != 1 ? 'd-none' : ''}}">
        <a class="nav-link" href="{{ route('admin.order') }}">
          <i class="bi bi-truck-front menu-icon"></i>
          <span class="menu-title">Order</span>
        </a>
      </li>
      <li class="nav-item {{$user_role != 1 ? 'd-none' : ''}}">
        <a class="nav-link" href="{{ route('survey') }}">
          <i class="bi bi-search menu-icon"></i>
          <span class="menu-title">Survey Products</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('calendar') }}">
          <i class="bi bi-calendar-check menu-icon"></i>
          <span class="menu-title">Set Visit</span>
        </a>
      </li>
      <li class="nav-item {{$user_role != 1 ? 'd-none' : ''}}">
        <a class="nav-link" href="{{ route('setting') }}">
          <i class="mdi mdi-settings menu-icon"></i>
          <span class="menu-title">Setting</span>
        </a>
      </li>
    </ul>
</nav>
<!-- partial -->