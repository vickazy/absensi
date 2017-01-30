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
    <table class="table table-bordered table-hover">
      <thead>
        <tr>
          <th>No</th>
          <th>Tanggal</th>
          <?php 
            foreach ($listName as $key) {
               echo "<th>".$key['nama']."</th>";
             } 
          ?>
        </tr>
      </thead>
      <tbody>
        <?php
          if ($absensi['0']['TANGGAL']) {
            $x = 1; 
            foreach ($absensi as $key) {
              echo "
                <tr>
                  <td>".$x++."</td>
                  <td>".$key['TANGGAL']."</td>";

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
         ?>
      </tbody>
    </table>
	 </div>
</body>
</html>