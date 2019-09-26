
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Property Management System</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/css/app.css">
    <link href="{{ asset('css/master.css') }}" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper"  id="app">

  <!-- Navbar -->
  <nav id="navigation-header" class="main-header navbar navbar-expand navbar-light border-bottom ">

    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars text-white"></i></a>
      </li>
    </ul>


    <!-- SEARCH FORM -->
      <div class="input-group col-xs-12 col-md-6 col-lg-5 q-pa-md ">
        <input class="form-control form-control-navbar" @keyup="searchit" v-model="search" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" @click="searchit">
            <i class="fa fa-search"></i>
          </button>
        </div>
      </div>

  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/dashboard" class="brand-link">
      <img src="./img/LogoGap.jpg" alt="Asset Management Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Property Management</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">   
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="./img/boy.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <router-link to="/profile">
          <a  class="d-block text-white">{{ Auth::user()->name }} <p>{{ Auth::user()->type}}</p> </a>
          </router-link>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Dashboard -->
          @can('isAdmin')
          <li class="nav-item">
            <router-link to="/dashboard" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                Dashboard
                </p>
            </router-link>
          </li>
          <!-- End for Dashboard -->

          <!-- Tree view for assets -->
          <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-chart-bar"></i>
                  <p>
                    Assets <i class="right fa fa-angle-left "></i>
                  </p>
              </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/pendings" class="nav-link">&nbsp;&nbsp;&nbsp;&nbsp;
                  <i class="fas fa-dot-circle"></i>&nbsp;
                    <p>Pendings</p>
                </router-link>
              </li>
              <li class="nav-item">
              <router-link to="/assets" class="nav-link">&nbsp;&nbsp;&nbsp;&nbsp;
              <i class="fas fa-dot-circle"></i>&nbsp;
                <p>RPCPPE</p>
              </router-link>
              </li>
              <li class="nav-item">
              <router-link to="/inventory" class="nav-link">&nbsp;&nbsp;&nbsp;&nbsp;
              <i class="fas fa-clipboard"></i>&nbsp;
                <p>ICS</p>
              </router-link>
              </li>
              <li class="nav-item">
              <router-link to="/iirup" class="nav-link">&nbsp;&nbsp;&nbsp;&nbsp;
                <i class="fas fa-trash-restore-alt"></i>&nbsp;
                 <p>IIRUP</p>
              </router-link>
              </li>
            </ul>
          </li>
          @endcan
          <!-- End for Assets Tree View -->

          <!-- Done For Management Tree View-->
          @can('isAdmin')
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-cog"></i>
                <p>Management<i class="right fa fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/users" class="nav-link">&nbsp;&nbsp;&nbsp;&nbsp;
                 <i class="fas fa-users-cog"></i>&nbsp;
                  <p>Users</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/users-type" class="nav-link">&nbsp;&nbsp;&nbsp;&nbsp;
                 <i class="fas fa-users-cog"></i>&nbsp;
                  <p>Users Type</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/accountable-officers" class="nav-link">&nbsp;&nbsp;&nbsp;&nbsp;
                 <i class="fas fa-users-cog"></i>&nbsp;
                  <p>Accountable Officers</p>
                </router-link>
              </li> 
              <li class="nav-item">
                <router-link to="/account-codes" class="nav-link">&nbsp;&nbsp;&nbsp;&nbsp;
                <i class="fas fa-code"></i>&nbsp;
                  <p>Account Codes</p>
                </router-link>
              </li> 
            </ul>
          </li>
          @endcan
          <!-- end for Management Tree View -->
          @can('isEmployeeOrSupply')
          <li class="nav-item">
            <router-link to="/requests" class="nav-link">
              <i class="nav-icon fas fa-thumbtack"></i>
              <p>
                Request Properties
              </p>
            </router-link>
          </li>
          @endcan
          @can('isEmployee')
          <li class="nav-item">
            <router-link to="/employee-dashboard" class="nav-link">
              <i class="nav-icon fas fa-list"></i>
              <p>
                List of Accountabilities
              </p>
            </router-link>
          </li>
          @endcan
          <li class="nav-item">
            <router-link to="/profile" class="nav-link">
              <i class="nav-icon fas fa-user-cog"></i>
              <p>
                Profile
              </p>
            </router-link>
          </li>
          
          <!-- Limimt user to see the developer navbar using can -->
          <!-- @can('isAdminOrAuthor')
          <li class="nav-item">
            <router-link to="/developer" class="nav-link">
            <i class="nav-icon fas fa-cog"></i>
              <p>
                Developer
              </p>
            </router-link>
          </li>
          @endcan -->
          <!-- End can Here -->
          <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}"
              onclick="event.preventDefault();
              document.getElementById('logout-form').submit();">
              <i class="nav-icon fas fa-power-off"></i>
                <p>
                  {{ __('Logout') }}
                </p>
            </a>
              <!-- To create logout button and trigger the method -->
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
              </form>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
   <div class="content">
   <div class="container-fluid">
   <!-- Router -->
    <router-view></router-view>
   <!-- Vue Progressbar -->
   <vue-progress-bar></vue-progress-bar>
   </div>
   </div>
  </div>
  <!-- /.content-wrapper -->


  <!-- Main Footer -->
  <!-- <footer class="main-footer"> -->
    <!-- To the right -->
    <!-- <div class="float-right d-none d-sm-inline"> -->
      <!-- Anything you want -->
    <!-- </div> -->
    <!-- Default to the left -->
    <!-- <strong>Copyright &copy; 2014-2018 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved. -->
  <!-- </footer> -->
</div>
<!-- ./wrapper -->
@auth
<script>
    window.user = @json(auth()->user())
</script>
@endauth
<script src="/js/app.js"></script>
</body>
</html>