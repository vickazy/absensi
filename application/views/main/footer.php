  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 16.12
    </div>
    <strong>Copyright &copy; Almsaeed Studio. <i class="fa fa-registered">Ranahweb</i> </strong> All rights
    reserved.
  </footer>

  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>

</div>
<!-- ./wrapper -->
    

<!-- jQuery 2.2.3 -->
<script src="<?php echo baseAdminLte; ?>plugins/jQuery/jquery-3.1.1.min.js"></script>
<!-- <script src="<?php// echo baseAdminLte; ?>plugins/jQuery/jquery-2.2.3.min.js"></script> -->
<!-- <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script> -->
<!-- Bootstrap 3.3.6 -->
<!-- <script src="<?php //echo baseAdminLte; ?>bootstrap/js/bootstrap3.7.min.js"></script> -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<!-- bootstrap datepicker -->
<script src="<?php echo baseAdminLte; ?>plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- FastClick -->
<script src="<?php echo baseAdminLte; ?>plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo baseAdminLte; ?>dist/js/app.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo baseAdminLte; ?>plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="<?php echo baseAdminLte; ?>plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo baseAdminLte; ?>plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- SlimScroll 1.3.0 -->
<script src="<?php echo baseAdminLte; ?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- ChartJS 1.0.1 -->
<script src="<?php echo baseAdminLte; ?>plugins/chartjs/Chart.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo baseAdminLte; ?>dist/js/pages/dashboard2.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo baseAdminLte; ?>dist/js/demo.js"></script>

<!-- <script src="<?php //echo baseAdminLte; ?>plugins/jQuery/jquery-1.12.3.js"></script> -->
<!-- DataTables -->
<script src="<?php echo baseAdminLte; ?>plugins/datatables/jquery.dataTables2.min.js"></script>

<!-- PAGE SCRIPT -->

<script type="text/javascript">
  $(document).ready(function() {
    $('#datepicker').datepicker({
      autoclose: true,
      format: 'yyyy-mm-dd',
      changeMonth: true,
      changeYear: true,
      showButtonPanel: true
    });

    $('#datepicker2').datepicker({
      autoclose: true,
      viewMode: 'months',
      changeMonth: true,
      changeYear: true,
      showButtonPanel: true,
      format: 'yyyy-mm',
      minViewMode: "months"
    });
    
    $('#example').DataTable({
      "paging":false, 
      "scrollX": true 
    }); 
  });

  function goBack() {
    window.history.back();
  }

</script>
</body>
</html>