
<form id="form_input" autocomplete="off">
    <div class="table-responsive">
        <div id="printarea">
            <?php $head = $list->row() ?>
            <table class="customers_a">
                <tr>
                    <td style="width : 100px;">Tanggal</td>
                    <td style="width : 5px;">:</td>
                    <td><?php echo $head->tgl_permintaan ?></td>
                </tr>
                <tr>
                    <td>Departemen</td>
                    <td>:</td>
                    <td><?php echo $head->nama_departemen ?></td>
                </tr>
            </table>
            
            <table class="table table-condensed table-bordered">
                <tr>
                    <th>No</th>
                    <th>Progres</th>
                    <th>Status</th>
                    <th>Keterangan Teknisi</th>
                    <th>Teknisi</th>
                    <th>Keterangan Mngr MTC</th>
                    <th>Manager MTC</th>
                    <th>Tgl Approve</th>
                    <th>Manager Dept</th>
                    <th>Tgl Approve</th>
                    <th>Inventaris</th>
                    <th>Keterangan</th>
                    <th>Tujuan</th>
                    <th>Gambar</th>
                </tr>
                <tbody id="row_body">
                    <?php
                    $no =0;
                    foreach ($list->result() as $data) {
                        $no++; ?>
                        <tr>
                            <td valign="top"><?php echo $no ?></td>
                            <td valign="top"><?php echo $data->progres ?></td>
                            <td valign="top"><?php echo $data->status_detail ?></td>
                            <td valign="top"><?php echo $data->keterangan_tkn ?></td>
                            <td valign="top"><?php echo $data->teknisi ?></td>
                            <td valign="top"><?php echo $data->keterangan_mtn ?></td>
                            <td valign="top"><?php echo $data->app_mtn ?></td>
                            <td valign="top"><?php echo $data->tgl_approved_mtn ?></td>
                            <td valign="top"><?php echo $data->app_mnger ?></td>
                            <td valign="top"><?php echo $data->tgl_app_manager ?></td>
                            <td valign="top"><?php echo $data->nama_inventaris ?></td>
                            <td valign="top"><?php echo $data->keterangan ?></td>
                            <td valign="top"><?php echo $data->tujuan ?></td>
                            <td valign="top">
                                <img onclick="view_gambar(this)" id="foto_gambar_<?php echo $no ?>" src="<?php echo base_url()?>assets/img/permintaan/<?php echo $data->gambar ?>" alt="" style="width: 50px; height:40px" onerror="this.onerror=null;this.src=\''+<?php echo base_url('assets/img/not_found.png')?>'\';"/>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <br>
    <div>
        <button id="btn_print" class="btn btn-primary btn-sm" type="button" onclick="printDiv(this)" >Print</button>
        <button class="btn btn-danger btn-sm" type="button" onclick="close_modal(this)">Close</button>
    </div>
</form>

<div class="modal fade" id="imagemodal_form" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Image preview</h4>
            </div>
            <div class="modal-body">
                <img src="" id="imagepreview_form" class="img-responsive" onerror="this.src='<?php echo base_url('assets/img/not_found.png')?>'" >
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" onclick="close_modal_prev(this)">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    function close_modal_prev(){
        $("#imagemodal_form").modal("hide")
    }
    function view_gambar(data)
    {
        id = data.id;
        $('#imagepreview_form').attr('src', $('#'+id).attr('src')); 
        $('#imagemodal_form').modal('show');

    }
    function printDiv(divName) {
        w=window.open();
        w.document.write($('#printarea').html());
        w.print();
        w.close();
    }

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