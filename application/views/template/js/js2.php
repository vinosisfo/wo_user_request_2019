
<!--tambahkan custom css disini-->
<!-- iCheck -->
<link href="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/iCheck/flat/blue.css') ?>" rel="stylesheet" type="text/css" />
<!-- Morris chart -->
<link href="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/morris/morris.css') ?>" rel="stylesheet" type="text/css" />
<!-- jvectormap -->
<link href="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/jvectormap/jquery-jvectormap-1.2.2.css') ?>" rel="stylesheet" type="text/css" />
<!-- Date Picker -->
<link href="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/datepicker/datepicker3.css') ?>" rel="stylesheet" type="text/css" />
<!-- Daterange picker -->
<link href="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/daterangepicker/daterangepicker-bs3.css') ?>" rel="stylesheet" type="text/css" /> 
<!-- bootstrap wysihtml5 - text editor -->
<link href="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') ?>" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/datatables/dataTables.bootstrap.css') ?>"/>


<link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/datatables/dataTables.bootstrap.css') ?>">
    <!-- Theme style -->
<link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.0.5/dist/css/AdminLTE.min.css') ?>">

<script src="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/jQuery/jQuery-2.1.4.min.js') ?>"></script>
  
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/datatables/dataTables.bootstrap.min.js') ?>"></script>
    <!-- SlimScroll -->
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/slimScroll/jquery.slimscroll.min.js') ?>"></script>
    <!-- FastClick -->
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/fastclick/fastclick.min.js') ?>"></script>
    <!-- AdminLTE App -->
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/dist/js/app.min.js') ?>"></script>
    <!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/dist/js/demo.js') ?>"></script>
    <!-- page script -->
    <script src="<?php echo base_url('assets/AdminLTE-2.0.5/bootstrap/js/bootstrap.js') ?>"></script>
        <script src="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/datepicker/bootstrap-datepicker.js')?>"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('.tanggal').datepicker({
                    format   : "yyyy-mm-dd",
                    autoclose: true
                });
            });
   $(document).ready(function() {
     
    $("[cek_a]").click(function() {
        $('#' + $(this).attr("cek_a")).prop('checked',
       function(i, oldVal) { return !oldVal; });
    });
});
</script>

    <script>
      $(function () {
        $("#example1").DataTable();
        $("#example3").DataTable();
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": true,
        });
      });
    </script>

    <script type="text/javascript">
    
    function hanyaAngka(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
    return false;
    return true;
    }
    </script>

