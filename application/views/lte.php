<?php 
    $this->load->view('main/head');
    $this->load->view('main/header');
    $this->load->view('main/sidebar', $submenu); ?>
    <!-- Content Wrapper. Contains page content -->
    <style type="text/css">
      td{white-space: nowrap;}
    </style>
    <div class="content-wrapper" style="min-height: 100%">
        <section class="content-header">
          <h1>
            <?php echo $menu; ?>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url('Dashboard_c') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"><?php echo $menu; ?></li>
          </ol>
        </section>
        <!-- Content Header (Page header) -->
        <?php $this->load->view($page); ?>
     </div>
    <!-- /.content-wrapper -->

<?php $this->load->view('main/footer'); ?>