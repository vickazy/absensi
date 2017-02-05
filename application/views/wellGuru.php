<!DOCTYPE html>
<html>
<head>
  <title>Report Table</title>
    <link rel="stylesheet" href="<?php echo baseAdminLte; ?>dist/css/AdminLTE.min.css">
    <style>
      table{
        border: 10pt;
        /*width: 95%;*/
        border-color: #111111;
      }
      td{
        padding-right: 15px;
        padding-left: 15px;
        /*white-space: nowrap;*/
      }

    </style>
</head>
<body>
	<div id="outtable">
    <h2><b><?php echo $keterangan; ?></b></h2>
    <table class="table table-bordered table-Striped">
      <thead> 
        <tr> 
          <th>No</th>
          <th>Nama</th>
          <th>Jabatan</th>
          <th>IN</th>
          <th>OUT</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $x = 1; 
          foreach ($absensi as $key) { 
          echo "
            <tr>
              <td>".$x++."</td>
              <td>".$key['NAMA']."</td>
              <td>".$key['JABATAN']."</td>
              <td>".$key['IN']."</td>
              <td>".$key['OUT']."</td>
            </tr>
          ";
         }
      ?>
      </tbody>
	  </table>
	 </div>
</body>
</html>