<!-- Main content -->
<section class="content">
  <!-- Main row -->
  <div class="row">
    <!-- Left col -->
    <div class="col-md-12">
      <!-- MAP & BOX PANE -->
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title"><?php echo $title ?></h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <p>
            <?php $typeUser = $this->uri->segment(4); ?>
            <form action="<?php echo base_url('main/absensiGuru/2/'.$typeUser) ?>" method="get" style="display: flex; position: absolute;">
            <div class="input-group" style="margin-right: 10px; width: 215px;">
                <input class="form-control" type="text" id="datepicker2" required placeholder="Tanggal" name="date">
                <div class="input-group-btn">
                  <button type="submit" class="btn btn-danger">Ok</button>
                </div>
            </div>
            <a target="_blank" class="btn btn-warning" href="<?php echo base_url('main/printToXLS/'.$date.'/'.$typeUser); ?>">Print</a>
            </form>
          </p>
          <div class="table-responsive">
            <table id="example" class="table table-bordered table-hover">
              <thead>
                <th>No</th>
                <th>Nama</th>
                <th>Jabatan</th>
                <?php 
                  foreach ($absensi['listtanggal'] as $key) {
                     echo "<th>".$key['tanggal']."</th>";
                   } 
                ?>
              </thead>
              <tbody>
                <?php
                  if ($absensi['0']['NAMA']) {
                    $x = 1; 
                    foreach ($absensi as $key) {
                      if ($key['NAMA']) {
                        echo "
                          <tr>
                            <td>".$x++."</td>
                            <td>".$key['NAMA']."</td>
                            <td>".$key['JABATAN']."</td>";

                          foreach ($key['DATA'] as $key2) {
                            if (!$key2['IN']) {
                              echo "<td class='bg-red color-palette'></td>";
                            } else {
                              echo "<td>".$key2['IN']." | ".$key2['OUT']."</td>";
                            }
                            
                          }
                        echo "</tr>";
                      }
                    }
                  }
                 ?>
              </tbody>
            </table>
          </div>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</section>
<!-- /.content -->