<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo baseAdminLte; ?>dist/img/avatar3.png" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $this->session->username ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
        <li class="active treeview">
          <a href="<?php echo base_url('main'); ?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-child"></i>
            <span>Guru / Karyawan</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-folder"></i> Harian</a></li>
            <li><a href="#"><i class="fa fa-folder"></i> Bulanan</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-users"></i>
            <span>Siswa</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-folder"></i> Harian</a>
              <ul class="treeview-menu">
                  <?php 
                    $count = count($submenu);
                    for ($i=0; $i < $count ; $i++) {
                      $countSubs = count($submenu[$i]['DATA']);
                     ?>
                      <li>
                        <a href="#"><i class="fa fa-circle-o"></i> <?php echo $submenu[$i]['KELAS']; ?>
                        <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i></span></a>
                      <ul class="treeview-menu">
                      <?php for ($x=0; $x < $countSubs ; $x++) {
                        $kelas_sekolah_id = $submenu[$i]['DATA'][$x]['KELAS_ID'];
                       ?>
                        <li><a href="<?php echo base_url('main/absensi/1/'.$kelas_sekolah_id) ?>"><i class="fa fa-circle-o"></i> <?php echo $submenu[$i]['DATA'][$x]['KELAS_JURUSAN']; ?></a></li>
                      <?php } ?>
                      </ul></li>
                  <?php } ?>
              </ul>
            </li>
            <li><a href="#"><i class="fa fa-folder"></i> Bulanan</a>
              <ul class="treeview-menu">
                <?php 
                  $count = count($submenu);
                  for ($i=0; $i < $count ; $i++) {
                    $countSubs = count($submenu[$i]['DATA']);
                   ?>
                    <li>
                      <a href="#"><i class="fa fa-circle-o"></i> <?php echo $submenu[$i]['KELAS']; ?>
                      <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i></span></a>
                    <ul class="treeview-menu">
                    <?php for ($x=0; $x < $countSubs ; $x++) {
                      $kelas_sekolah_id = $submenu[$i]['DATA'][$x]['KELAS_ID'];
                     ?>
                      <li><a href="<?php echo base_url('main/absensi/2/'.$kelas_sekolah_id) ?>"><i class="fa fa-circle-o"></i> <?php echo $submenu[$i]['DATA'][$x]['KELAS_JURUSAN']; ?></a></li>
                    <?php } ?>
                    </ul></li>
                <?php } ?>
              </ul>
            </li>
          </ul>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>