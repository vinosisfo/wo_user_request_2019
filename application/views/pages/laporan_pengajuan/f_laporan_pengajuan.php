<div class="content-wrapper"> 
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#fa-icons" data-toggle="tab">laporan Pengajuan</a></li>
          </ul>
        
          <div class="tab-content">
            <div class="tab-pane active" id="fa-icons">
              <div class="box">
                <div class="box-body scrolltable">
                  <div class="table-responsive">
                    <form id="form_laporan" autocomplete="off">
                      <table class="customers_a">
                        <tr>
                          <td>Format</td>
                          <td>:</td>
                          <td colspan="2">
                            <select name="format" id="format">
                              <option value="">PILIH</option>
                              <option value="HARIAN">HARIAN</option>
                              <option value="MINGGUAN">MINGGUAN</option>
                              <option value="BULANAN">BULANAN</option>
                            </select>
                          </td>

                          <td>Departemen</td>
                          <td>:</td>
                          <td>
                            <select name="departemen" id="departemen" style="min-width : 99%;">
                              <?php if($akses=="ok") { ?>
                                <option value="">ALL</option>
                              <?php } foreach ($dept->result() as $dpt) { ?>
                                <option value="<?php echo $dpt->id_departemen ?>"><?php echo $dpt->nama_departemen ?></option>
                              <?php } ?>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td>Tanggal</td>
                          <td>:</td>
                          <td>
                            <input type="text" name="date1" id="date1" class="tanggal" readonly value="<?php echo date("Y-m-d") ?>" style="width: 80px;">
                          </td>
                          <td>
                            <input type="text" name="date2" id="date2" class="tanggal" readonly value="<?php echo date("Y-m-d") ?>" style="width: 80px;">
                          </td>

                          <td>Status</td>
                          <td>:</td>
                          <td>
                            <select name="status" id="status">
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
                        </tr>
                        <tr>
                          <td>Inventaris</td>
                          <td>:</td>
                          <td colspan="2">
                            <input type="inventaris" id="inventaris" style="min-width : 99%;">
                          </td>
                        </tr>
                        <tr>
                          <td colspan="4">
                            <button type="button" class="btn btn-sm btn-primary" onclick="view_data(this)">View</button>
                            <span id="btn_print" hidden>
                              <button type="button" class="btn btn-sm btn-danger">Print</button>
                            </span>
                          </td>
                        </tr>
                      </table>
                    </form>
                  </div>
                  <div id="data_report"></div>
                </div>
              </div> 
            </div>
            <!--form input data-->  
          </div><!-- /.nav-tabs-custom -->
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div>
  </section><!-- /.content -->
</div>

<script>
  function view_data(){
    format = $("#format").val()
    if(format==""){
      alert("Format Tidak Boleh Kosong");
      $("#format").focus()
      return false
    }

    url="<?php echo base_url('c_laporan_pengajuan/get_laporan')?>";
    $('#form_laporan').attr('action',url);
    $('#form_laporan').attr('target','_blank');
    $('#form_laporan').attr('method','post');
    $('#form_laporan').submit();
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