
<!-- jQuery 3 -->
<script src="<?php echo base_url('assets/AdminLTE-2.4.3/bower_components/jquery/dist/jquery.min.js')?>"></script>

<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url('assets/AdminLTE-2.4.3/bower_components/bootstrap/dist/js/bootstrap.min.js')?>"></script>
<!-- DataTables -->
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/datatables/dataTables.bootstrap.min.js') ?>"></script>
<!-- SlimScroll -->
<script src="<?php echo base_url('assets/AdminLTE-2.4.3/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')?>"></script>
<script src="<?php echo base_url('assets/AdminLTE-2.4.3/bower_components/jquery-slimscroll/jquery.slimscroll.js')?>"></script>

<!-- FastClick -->
<script src="<?php echo base_url('assets/AdminLTE-2.4.3/bower_components/fastclick/lib/fastclick.js')?>"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url('assets/AdminLTE-2.4.3/dist/js/adminlte.min.js')?>"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url('assets/AdminLTE-2.4.3/dist/js/demo.js')?>"></script>

<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url('assets/AdminLTE-2.4.3/bower_components/jquery-ui/jquery-ui.min.js')?>"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Morris.js charts -->
<script src="<?php echo base_url('assets/AdminLTE-2.4.3/bower_components/raphael/raphael.min.js')?>"></script>
<!-- <script src="<?php //echo base_url('assets/AdminLTE-2.4.3/bower_components/morris.js/morris.min.js')?>"></script> -->
<!-- Sparkline -->
<script src="<?php echo base_url('assets/AdminLTE-2.4.3/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js')?>"></script>
<!-- jvectormap -->
<script src="<?php echo base_url('assets/AdminLTE-2.4.3/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')?>"></script>
<script src="<?php echo base_url('assets/AdminLTE-2.4.3/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')?>"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url('assets/AdminLTE-2.4.3/bower_components/jquery-knob/dist/jquery.knob.min.js')?>"></script>
<!-- daterangepicker -->
<script src="<?php echo base_url('assets/AdminLTE-2.4.3/bower_components/moment/min/moment.min.js')?>"></script>
<script src="<?php echo base_url('assets/AdminLTE-2.4.3/bower_components/bootstrap-daterangepicker/daterangepicker.js')?>"></script>
<!-- datepicker -->
<script src="<?php echo base_url('assets/AdminLTE-2.4.3/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')?>"></script>
<script src="<?php echo base_url('assets/AdminLTE-2.4.3/plugins/plugins/bootstrap-datepicker/bootstrap-datepicker.js')?>"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo base_url('assets/AdminLTE-2.4.3/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')?>"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="<?php //echo base_url('assets/AdminLTE-2.4.3/dist/js/pages/dashboard.js')?>"></script> -->

<!-- vue js + axios -->
<script src="<?php echo base_url('assets/AdminLTE-2.4.3/js/vue/vue.min.js')?>"></script>
<script src="<?php echo base_url('assets/AdminLTE-2.4.3/js/axios/axios.min.js')?>"></script>


<!-- page script -->
<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true
    });
  // $('#slim').slimScroll({
  //   height: '200px'
  //     });
  });

   $(".datepicker").datepicker({
     autoclose  : true,
     format     : 'yyyy-mm-dd',
     changeMonth: true,
     changeYear : true
    });

   function hanyaAngka(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
    return false;
    return true;
    }

    function Checkfiles()
    {
        var fup = document.getElementById('filename');
        var fileName = fup.value;
        var ext = fileName.substring(fileName.lastIndexOf('.') + 1);
        if(ext == "jpg,png,gif")
        {
            return true;
        } 
        else if(ext=="")
        {
            alert("No file selected");
            fup.focus();
            return false;
        }else
        {
            alert("Sorry, You can upload xls file only !");
            fup.focus();
            return false;
        }
    }
    function tampilkanPreview(gambar,idpreview){
        //membuat objek gambar
        var gb = gambar.files;
        
        //loop untuk merender gambar
        for (var i = 0; i < gb.length; i++){
        //bikin variabel
            var gbPreview = gb[i];
            var imageType = /image.*/;
            var preview=document.getElementById(idpreview);            
            var reader = new FileReader();
            
            if (gbPreview.type.match(imageType)) {
            //jika tipe data sesuai
                preview.file = gbPreview;
                reader.onload = (function(element) { 
                    return function(e) { 
                        element.src = e.target.result; 
                    }; 
                })(preview);

                //membaca data URL gambar
                reader.readAsDataURL(gbPreview);
            }else{
            //jika tipe data tidak sesuai
                alert("Type file tidak sesuai. Khusus image.");
            }
           
        }    
    }
</script>