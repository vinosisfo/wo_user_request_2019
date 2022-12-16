
<form id="form_input" autocomplete="off">
    <div class="table-responsive">
        <?php $head = $list->row() ?>
        <table class="customers_a">
            <tr>
                <td style="width : 100px;">Tanggal</td>
                <td style="width : 5px;">:</td>
                <td>
                    <input type="hidden" name="level" id="level" value="<?php echo $level ?>" readonly>
                    <input type="hidden" name="id_pengajuan" id="id_pengajuan" readonly value="<?php echo $head->id_pengajuan ?>">
                    <input type="text" name="tanggal" id="tanggal" class="tanggal" readonly style="width: 80px;" value="<?php echo $head->tgl_pengajuan ?>">
                </td>
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
                <th><?php echo ($level=="TEKNISI") ? "Progres" : "Status" ?></th>
                <?php if($level=="TEKNISI"){ ?>
                <th>Keterangan Teknisi</th> 
                <?php } ?>
                <?php if(($level=="MANAGER MTN") OR ($level=="TEKNISI")){ ?>
                    <th>Penanganan</th>
                <?php } ?>
                <th>Inventaris</th>
                <th>Masalah</th>
                <th>Gambar</th>
            </tr>
            <tbody id="row_body">
                <?php
                $no =0;
                foreach ($list->result() as $data) {
                    $no++; ?>
                    <tr>
                        <td valign="top">
                            <input type="hidden" name="id_detail[]" id="id_detail_<?php echo $no ?>" value="<?php echo $data->id_dtpengajuan ?>" readonly\>
                            <input type="text" class="no_urut transparant" id="no_urut_<?php echo $no ?>" value="<?php echo $no ?>" readonly style="width : 40px;">
                        </td>
                        <td>
                            <?php if($level=="TEKNISI"){ ?>
                                <select name="progres[]" id="progres_<?php echo $no ?>">
                                <?php if($data->progres > 0){ ?>
                                    <option value="<?php echo $data->progres ?>"><?php echo $data->progres ?></option>
                                <?php } ?>
                                <option value="">PILIH</option>
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="30">30</option>
                                <option value="40">40</option>
                                <option value="50">50</option>
                                <option value="60">60</option>
                                <option value="70">70</option>
                                <option value="80">80</option>
                                <option value="90">90</option>
                                <option value="100">100</option>
                            </select>
                            <?php } else { ?>
                                <select name="status_detail[]" id="status_detail_<?php echo $no ?>">
                                <?php
                                $arr_rpl = ["MTN","DEPT"];
                                $status_replace = str_replace($arr_rpl,"",$data->status_detail); 
                                if(strlen($status_replace) > 3){ ?>
                                    <option value="<?php echo $status_replace ?>"><?php echo $status_replace ?></option>
                                <?php } ?>
                                <option value="">PILIH</option>
                                <option value="APPROVE">APPROVE</option>
                                <option value="TOLAK">TOLAK</option>
                            </select>
                            <?php } ?>
                            
                        </td>
                        <?php if($level=="TEKNISI") { ?>
                            <td>
                                <textarea name="keterangan_tkn[]" id="keterangan_tkn_<?php echo $no ?>" maxlength="100" style="resize:none;width : 250px; height : 40px;"><?php echo $data->keterangan_tkn ?></textarea>
                            </td>
                        <?php } ?>
                        <?php if(($level=="MANAGER MTN") OR ($level=="TEKNISI")){ ?>
                            <td valign="top">
                                <?php if($level=="TEKNISI"){ ?>
                                    <?php echo $data->penanganan ?>
                                <?php } else { ?>
                                    <textarea name="penanganan[]" id="penanganan_<?php echo $no ?>" maxlength="100" style="resize:none;width : 250px; height : 40px;"><?php echo $data->penanganan ?></textarea>
                                <?php } ?>
                                
                            </td>
                        <?php } ?>
                        <td valign="top"><?php echo $data->nama_inventaris ?></td>
                        <td valign="top"><?php echo $data->masalah ?></td>
                        <td valign="top">
                            <img onclick="view_gambar(this)" id="foto_gambar_<?php echo $no ?>" src="<?php echo base_url()?>assets/img/pengajuan/<?php echo $data->gambar ?>" alt="" style="width: 50px; height:40px;" onerror="this.onerror=null;this.src=\''+<?php echo base_url('assets/img/not_found.png')?>'\';"/>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    
</div>
<div>
    <button id="btn_simpan" class="btn btn-primary btn-sm" type="submit" >Simpan</button>
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
    // function simpan_data(){
        $('#form_input').submit(function(e){
        e.preventDefault();
        v_status = document.getElementsByName('status_detail[]');
        for (i=0; i<v_status.length; i++)
        {
            nomor = parseInt(i)+1;
            if (v_status[i].value == "")
            {
                alert("Status Tidak Boleh Kosong");
                $("#status_detail_"+nomor).focus()
                return false;
            }
        }

        // $("#btn_simpan").prop("disabled",true)
        level = '<?php echo $level ?>';
        if(level=="TEKNISI"){
            url_set = '<?php echo base_url('c_pengajuan_new/approve_data_progres') ?>'
        } else{
            url_set = '<?php echo base_url('c_pengajuan_new/approve_data_proses') ?>'
        }
        $.ajax({
            url        : url_set,
            type       : "POST",
            data       : new FormData(this),
            dataType   : "json",
            processData: false,
            contentType: false,
            cache      : false,
            async      : true,
            success    : function(data)
            {
                if(data.hasil=="ok"){
                    table.ajax.reload();
                    alert("Data Berhasil Disimpan")
                    close_modal()

                }
            }
        })
    })
    // }

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