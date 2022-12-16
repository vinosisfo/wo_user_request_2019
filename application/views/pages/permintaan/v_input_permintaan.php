
<form id="form_input" autocomplete="off">
    <div class="table-responsive">
        <table class="customers_a">
            <tr>
                <td style="width : 100px;">Tanggal</td>
                <td style="width : 5px;">:</td>
                <td>
                    <input type="text" name="tanggal" id="tanggal" class="tanggal" readonly style="width: 80px;" value="<?php echo date("Y-m-d") ?>">
                </td>
            </tr>
            <tr>
                <td>Departemen</td>
                <td>:</td>
                <td><?php echo strtoupper($this->session->userdata('nama_departemen')) ?></td>
            </tr>
        </table>
        <br>
        <div>
            <button class="btn btn-xs btn-danger" type="button" onclick="add_row_number(this)">Tambah</button>
        </div>
        <table class="table table-condensed table-bordered">
            <tr>
                <th></th>
                <th>No</th>
                <th>Inventaris</th>
                <th>Keterangan</th>
                <th>Tujuan</th>
                <th>Gambar</th>
            </tr>
            <tbody id="row_body"></tbody>
        </table>
    
</div>
<div>
    <button id="btn_simpan" class="btn btn-primary btn-sm" type="submit" >Simpan</button>
    <button class="btn btn-danger btn-sm" type="button" onclick="close_modal(this)">Close</button>
</div>
</form>

<script>
    // function simpan_data(){
        $('#form_input').submit(function(e){
        e.preventDefault();
        v_inventaris = document.getElementsByName('inventaris[]');
        for (i=0; i<v_inventaris.length; i++)
        {
            nomor = parseInt(i)+1;
            if (v_inventaris[i].value == "")
            {
                alert("Inventaris Tidak Boleh Kosong");
                $("#inventaris_"+nomor).focus()
                return false;
            }
        }

        v_keterangan = document.getElementsByName('keterangan[]');
        for (i=0; i<v_keterangan.length; i++)
        {
            nomor = parseInt(i)+1;
            if (v_keterangan[i].value == "")
            {
                alert("Keterangan Tidak Boleh Kosong");
                $("#keterangan_"+nomor).focus()
                return false;
            }
        }

        v_tujuan = document.getElementsByName('tujuan[]');
        for (i=0; i<v_tujuan.length; i++)
        {
            nomor = parseInt(i)+1;
            if (v_tujuan[i].value == "")
            {
                alert("Tujuan Tidak Boleh Kosong");
                $("#tujuan_"+nomor).focus()
                return false;
            }
        }

        $("#btn_simpan").prop("disabled",true)
        $.ajax({
            url        : '<?php echo base_url('c_permintaan_new/simpan_data') ?>',
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

    function add_row_number(){
        cek = $('.no_urut:last').val();
        if (typeof cek != "undefined") {
            no = cek;
        } else {
            no = 0;
        }
        add_row(no)
    }

    function add_row(no){
        no   = (parseInt(no) < 1) ? 1 :(parseInt(no)+1);
        from = "from_"+no;
        row  = '<tr>'+
                    '<td valign="top">'+
                        '<img src="<?php echo base_url()?>assets/img/hapus.png" class="rButton" style="width:15px;" title="Hapus Data">'+
                    '</td>'+
                    '<td valign="top">'+
                        '<input type="text" class="no_urut transparant" id="no_urut_'+no+'" value="'+no+'" readonly style="width : 40px;">'+
                    '</td>'+
                    '<td valign="top">'+
                        '<select name="inventaris[]" id="inventaris_'+no+'" onchange="cek_double(this,\''+no+'\');">'+
                            '<option value="">PILIH</option>'+
                            <?php foreach ($inv->result() as $invt) { ?>
                                '<option value="<?php echo $invt->id_inventaris ?>"><?php echo $invt->nama_inventaris ?></option>'+
                            <?php } ?>
                        '</select>'+
                    '</td>'+
                    '<td valign="top">'+
                        '<textarea name="keterangan[]" id="keterangan_'+no+' maxlength="200" style="resize:none;width : 250px; height : 40px;"></textarea>'+
                    '</td>'+
                    '<td valign="top">'+
                    '<textarea name="tujuan[]" id="tujuan_'+no+' maxlength="200" style="resize:none;width : 250px; height : 40px;"></textarea>'+
                    '</td>'+
                    '<td valign="top">'+
                        '<input type="file" name="gambar[]" id="gambar_'+no+'" accept=".jpg,.png,.gif,.image/*" id="filename" onchange="tampilkanPreview(this,\''+'preview_'+no+''+'\')">'+
                        '<img id="preview_'+no+'" src="" alt="" style="width: 20%; height:20%;" onerror="this.onerror=null;this.src=\''+'<?php echo base_url('assets/img/not_found.png')?>'+'\';"/>'+
                    '</td>'+
                '</tr>';

        $("#row_body").append(row)
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

    $(document).on('click', 'img.rButton', function () {
		$(this).closest('tr').remove();
		return false;
	});
    add_row_number();

    function cek_double(data,urut){
        $.post("<?php echo base_url('c_permintaan_new/cek_double')?>",$("#form_input").serialize(),function(data){
            if(data.hasil=="ada"){
                alert("Data Inventaris Sama Pada Baris No. "+urut)
                opsi = '<option value="">PILIH</option>'+
                        <?php foreach ($inv->result() as $invt) { ?>
                            '<option value="<?php echo $invt->id_inventaris ?>"><?php echo $invt->nama_inventaris ?></option>'+
                        <?php } ?>
                        '';
                $("#inventaris_"+urut).html(opsi)
            }
        },"json")
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