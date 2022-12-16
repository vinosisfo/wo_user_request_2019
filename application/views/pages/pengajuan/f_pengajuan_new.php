<style>
    th, td { white-space: nowrap; }
    table.table tr th{
    background-color: #4CAF50 !important;
    color           : white !important;
    }

    .table-condensed>thead>tr>th, .table-condensed>tbody>tr>th, .table-condensed>tfoot>tr>th, .table-condensed>thead>tr>td, .table-condensed>tbody>tr>td, .table-condensed>tfoot>tr>td{
    padding: 1px;
    }
</style>
<div class="content-wrapper"> 
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#fa-icons" data-toggle="tab">Tampilkan Data Pengajuan</a></li>
                        <?php if($this->session->userdata['level']==='ADMIN'){?>
                        <li><button class="btn btn-danger" type="button" onclick="input_data(this)">Buat Pengajuan</button></li>
                        <?php } ?>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="fa-icons">
                            <div class="box">
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table class="customers_a">
                                            <tr>
                                                <td>Id Pengajuan</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="text" name="nomor_cari" id="nomor_cari" style="width : 180px;">
                                                </td>

                                                <td>Departemen</td>
                                                <td>:</td>
                                                <td>
                                                    <select name="departemen_cari" id="departemen_cari" style="width : 180px;">
                                                        <?php if($akses=="ok") { ?>
                                                            <option value="">ALL</option>
                                                        <?php } foreach ($dept->result() as $dpt) { ?>
                                                            <option value="<?php echo $dpt->id_departemen ?>"><?php echo $dpt->nama_departemen ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>

                                                <td>Tanggal</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="text" name="date1_cari" id="date1_cari" class="tanggal" readonly value="<?php echo date("Y-m-01") ?>" style="max-width : 80px;">-
                                                </td>

                                                <td>
                                                    <button type="button" class="btn btn-primary btn-sm" id='btn-cari'>Cari</button>
                                                </td>
                                            </tr>
                                            <tr>

                                                <td>Status</td>
                                                <td>:</td>
                                                <td>
                                                    <select name="status_cari" id="status_cari">
                                                        <option value="">ALL</option>
                                                        <option value="BARU">BARU</option>
                                                        <option value="APPROVE MANAGER DEPT">APPROVE MANAGER DEPT</option>
                                                        <option value="APPROVE MANAGER MTN">APPROVE MANAGER MTN</option>
                                                        <option value="PROSES TEKNISI">PROSES TEKNISI</option>
                                                        <option value="SELESAI">SELESAI</option>
                                                        <option value="TOLAK DEPT">DITOLAK DEPT</option>
                                                        <option value="TOLAK MTN">DITOLAK MTN</option>
                                                    </select>
                                                </td>

                                                <td>Inventaris</td>
                                                <td>:</td>
                                                <td>
                                                    <input type="text" name="inventaris_cari" id="inventaris_cari" style="width : 180px;">
                                                </td>
                                                <td colspan="2"></td>
                                                <td>
                                                    <input type="text" name="date2_cari" id="date2_cari" class="tanggal" readonly value="<?php echo date("Y-m-d") ?>" style="max-width : 80px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="table-responsive">
                                        <table id="data_list" class="table table-condensed table-bordered">
                                            <thead>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th>id pengajuan</th>
                                                <th>Tgl</th>
                                                <th>departemen</th>
                                                <th>inventaris</th>
                                                <th>diajukan</th>
                                                <th>Masalah</th>
                                                <th>Penanganan</th> 
                                                <th>Manager Dept App</th>
                                                <th>Tgl App</th>
                                                <th>Manager Mtn App</th> 
                                                <th>Tgl App</th> 
                                                <th>Teknisi</th>
                                                <th>Keterangan Tkn</th>             
                                                <th>Progres</th>
                                                <th>Status</th>
                                                <th>Tgl Perbaikan</th>
                                                <th>Tgl Selesai</th>
                                                <!-- <th>Gambar</th> -->
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div class="modal fade" id="modal_form" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content" style="max-width : 700px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title judul"></h4>
            </div>
            <div class="modal-body">
                <div id="form_data"></div>
            </div>
        </div>
    </div>
</div>



<script>
    function input_data(){
        $.post("<?php echo base_url('c_pengajuan_new/input_data')?>",{format : "input_data"}, function(data){
            $(".judul").html("Buat Pengajuan Baru")
            $("#modal_form").modal("show")
            $("#form_data").html(data)
        })
    }

    function close_modal(){
        $("#modal_form").modal("hide")
    }
    
    function edit_data(id_pengajuan,level){
        $.post("<?php echo base_url('c_pengajuan_new/edit_data')?>",{id_pengajuan : id_pengajuan,level : level}, function(data){
            $(".judul").html("Edit Pengajuan")
            $("#modal_form").modal("show")
            $("#form_data").html(data)
        })
    }

    function detail_data(id_pengajuan,level){
        $.post("<?php echo base_url('c_pengajuan_new/detail_data')?>",{id_pengajuan : id_pengajuan,level : level}, function(data){
            $(".judul").html("Detail Pengajuan")
            $("#modal_form").modal("show")
            $("#form_data").html(data)
        })
    }

    function hapus_data(id_pengajuan){
        if(confirm("Yakin Data Akan Dihapus")){
            $.post("<?php echo base_url('c_pengajuan_new/hapus_data')?>",{id_pengajuan : id_pengajuan}, function(data){
                if(data.hasil=="ok"){
                    table.ajax.reload();
                    alert("Data Berhasil Dihapus")
                    
                }
            },"json")
        }
    }

    function approve_data(id_pengajuan,level){
        $.post("<?php echo base_url('c_pengajuan_new/approve_data')?>",{id_pengajuan : id_pengajuan,level : level}, function(data){
            if(level=="TEKNISI"){
                $(".judul").html("Progres Pengajuan "+level)
            } else {
                $(".judul").html("Approve Pengajuan "+level)
            }
            
            $("#modal_form").modal("show")
            $("#form_data").html(data)
        })
    }

    var table;
    table = $('#data_list').DataTable({ 
        "processing"  : true,
        "serverSide"  : true,
        'responsive'  : true,
        'ordering'    : false,
        'lengthChange': false,
        "order"       : [],
        "ajax"        : {
        "url" : "<?php echo base_url('c_pengajuan_new/get_data')?>",
        "type": "POST",
        "data": function ( data ) {
                data.nomor_cari      = $('#nomor_cari').val();
                data.departemen_cari = $('#departemen_cari').val();
                data.inventaris_cari = $("#inventaris_cari").val();
                data.status_cari     = $("#status_cari").val();
                data.date1_cari      = $('#date1_cari').val();
                data.date2_cari      = $('#date2_cari').val();
                
            }
        },
    });

    $('#btn-cari').click(function(){ //button filter event click
        table.ajax.reload();  //just reload table
    });
    $('#btn-reset').click(function(){ //button reset event click
        $('#form-cari')[0].reset();
        table.ajax.reload();  //just reload table
    });

    $("#data_list_filter").css("display","none");

    $('.tanggal').datepicker({
        autoclose     : true,
        format        : 'yyyy-mm-dd',
        changeMonth   : true,
        changeYear    : true,
        orientation   : "top",
        todayHighlight: true,
        toggleActive  : true,
    });
</script>