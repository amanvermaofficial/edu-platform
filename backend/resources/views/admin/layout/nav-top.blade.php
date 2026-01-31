<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">

    <!-- User Dropdown -->
    <li class="nav-item dropdown user-menu">

        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
            <img src="{{ asset('admin/dist/img/user2-160x160.jpg') }}"
                 class="user-image img-circle elevation-2" alt="User Image">
        </a>

        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

            <!-- User info section -->
            <li class="user-header bg-primary">
                <img src="{{ asset('admin/dist/img/user2-160x160.jpg') }}"
                     class="img-circle elevation-2" alt="User Image">

                <p>
                    {{ auth()->user()->name }}
                    <small>Member since {{ auth()->user()->created_at->format('M Y') }}</small>
                </p>
            </li>

            <!-- Footer (buttons) -->
            <li class="user-footer">


                <!-- Logout button -->
                <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button class="btn btn-default btn-flat float-right">Logout</button>
                </form>

            </li>

        </ul>

    </li>
</ul>


    
  </nav>