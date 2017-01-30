<header class="main-header">

  <!-- Logo -->
  <a href="<?php echo base_url('v2/main'); ?>" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><b>Y</b>PPN</span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>Admin</b>YPPN</span>
  </a>

  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>
    <!-- Navbar Right Menu -->
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <!-- User Account: style can be found in dropdown.less -->
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="<?php echo baseAdminLte; ?>dist/img/avatar3.png" class="user-image" alt="User Image">
            <span class="hidden-xs"><?php echo $this->session->username ?></span>
          </a>
          <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header">
              <img src="<?php echo baseAdminLte; ?>dist/img/avatar3.png" class="img-circle" alt="User Image">
              <p>
                <?php echo $this->session->username ?>
              </p>
            </li>
            <!-- Menu Body -->
            <li class="user-body">
              <div class="row">
                
              </div>
              <!-- /.row -->
            </li>
            <!-- Menu Footer-->
            <li class="user-footer">
              <div class="pull-left">
                <a href="#" class="btn btn-default btn-flat">Profile</a>
              </div>
              <div class="pull-right">
                <a href="#" class="btn btn-default btn-flat">Log out</a>
              </div>
            </li>
          </ul>
        </li>
      </ul>
    </div>

  </nav>
</header>