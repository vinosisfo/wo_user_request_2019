<div id="app">
<div class="content-wrapper"> 
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#fa-icons" data-toggle="tab">Tampilkan Data inventaris</a></li>
            <li><a href="#glyphicons" data-toggle="tab">Tambah Data inventaris</a></li>
          </ul>
        
          <div class="tab-content">
            <div class="tab-pane active" id="fa-icons">
              <div class="box"> 
                <div class="box-body scrolltable">
                  <div class="table-responsive">
                    <h5 v-if="(message !='')" class="text-success">
                      <div class='alert alert-info' role='alert'><b><span class='glyphicon glyphicon-envelope'></span></b>{{message.text}}</div>
                    </h5>
                    <table id="dttable" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <?php 
                            echo $this->session->flashdata('msg');
                          ?>
                          <th>id</th>
                          <th>departemen</th>
                          <th>nama inventaris</th>
                          <th>tgl operasi</th>
                          <th>tgl Beli</th>
                          <th>keterangan</th>             
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="item in data_inventaris">
                          <td>{{item.id_inventaris}}</td>
                          <td>{{item.nama_departemen}}</td>
                          <td>{{item.nama_inventaris}}</td>
                          <td v-if="(item.tgl_operasi==='0000-00-00')">-</td>
                          <td v-if="(item.tgl_operasi !=='0000-00-00')">{{item.tgl_operasi}}</td>
                          <td v-if="(item.tgl_beli==='0000-00-00')">-</td>
                          <td v-if="(item.tgl_beli !=='0000-00-00')">{{item.tgl_beli}}</td>
                          <td>{{item.keterangan}}</td>
                          <td>
                            <button class="btn btn-primary btn-xs" v-on:click="select_row(item)">Edit</button>
                            <button class="btn btn-danger btn-xs" v-on:click="hapus_data(item.id_inventaris)">delete</button>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div> 
            </div>
   
            <!--form input data-->   
            <div class="tab-pane" id="glyphicons">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Form Input Data inventaris</h3>
                </div><!-- form start -->
                  
                <form  class="form-horizontal" action="<?php echo base_url('c_inventaris/simpan_data')?>" method="POST">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Departemen <font color ="red">*</font> </label>
                      <select name="id_departemen" class="form-control" style="width: 30%;" required="required">
                        <option value="">pilih departemen</option>
                        <?php foreach ($departemen as $item) {?>
                        <option value="<?php echo $item->id_departemen?>"><?php echo $item->nama_departemen?></option>
                        <?php } ?>
                      </select>
                    </div>

                    <div class="form-group">
                      <label for="exampleInputEmail1">Nama inventaris <font color ="red">*</font> </label>
                      <input type="text" name="nama_inventaris" autocomplate="off" style="width: 30%;" class="form-control" id="exampleInputPassword1" placeholder="nama inventaris" minlength="2" maxlength="50"   autofocus="autofocus" required="required">
                    </div>

                    <div class="form-group">
                      <label for="exampleInputEmail1">keterangan <font color ="red">*</font> </label>
                      <textarea name="keterangan" class="form-control" maxlength="200" minlength="4" style="width: 30%;" required="required" placeholder="keterangan inventaris"></textarea>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Tgl Operasi <font color ="red">*</font> </label>
                      <input type="text" name="tgl_operasi" id="tgl_operasi" readonly value="<?php echo date('Y-m-d')?>" required class="tanggal form-control" style="max-width :30%;">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Tgl Beli <font color ="red">*</font> </label>
                      <input type="text" name="tgl_beli" id="tgl_beli" readonly value="<?php echo date('Y-m-d')?>" required class="tanggal form-control" style="max-width :30%;">
                    </div>

                    <div class="box-footer">
                      <input type="submit" name="tambah" class="btn btn-info btn-flat glyphicon glyphicon-floppy-save" value="Simpan">
                    </div>
                  </div>
                </form>
                    
              </div><!-- /#ion-icons -->
            </div><!-- /.tab-content -->
          </div><!-- /.nav-tabs-custom -->
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div>

     <div class="modal fade" id="modal-default"> 
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit data</h4>
              </div>

              <form action="<?php echo base_url('c_inventaris/update_data')?>" method="POST" autocomplete="off">
              <div class="form-group" >
                <div class="col-md-12">
                  <label for="" class="control-label">Departemen</label>
                  <input type="hidden" name="id_inventaris" style="width: 30%;" autocomplate="off" class="form-control" id="exampleInputUsername" maxlength="20" minlength="5" required="required" v-model="edit_data.id_inventaris">

                  <select name="id_departemen" class="form-control" style="width: 30%;" required="required">
                    <option v-bind:value="edit_data.id_departemen">{{edit_data.nama_departemen}}</option>
                    <?php foreach ($departemen as $item) {?>
                    <option value="<?php echo $item->id_departemen?>"><?php echo $item->nama_departemen?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <div class="col-md-12">
                  <label for="exampleInputEmail1">Nama inventaris <font color ="red">*</font> </label>
                  <input type="text" name="nama_inventaris" autocomplate="off" style="width: 30%;" class="form-control" id="exampleInputPassword1" placeholder="departemen" minlength="2" maxlength="50"   autofocus="autofocus" required="required" v-model="edit_data.nama_inventaris">
                </div>
              </div>

              <div class="form-group">
                <div class="col-md-12">
                  <label for="exampleInputEmail1">keterangan <font color ="red">*</font> </label>
                  <textarea name="keterangan" class="form-control" maxlength="200" minlength="4" style="width: 30%;" required="required" placeholder="keterangan inventaris">{{edit_data.keterangan}}</textarea>
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-12">
                  <label for="exampleInputEmail1">Tgl Operasi <font color ="red">*</font> </label>
                  <input v-model="edit_data.tgl_operasi" type="text" name="tgl_operasi" id="tgl_operasi" readonly required class="tanggal form-control" style="max-width :30%;">
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-12">
                  <label for="exampleInputEmail1">Tgl Beli <font color ="red">*</font> </label>
                  <input v-model="edit_data.tgl_beli"  type="text" name="tgl_beli" id="tgl_beli" readonly required class="tanggal form-control" style="max-width :30%;">
                </div>
              </div>
              <div class="form-group" >
                <div class="col-md-10">
                  <button type="submit" class="btn btn-primary">Update</button>
                </div>
              </div>
              </form>

              <div class="modal-footer">
                <!-- <button type="button" class="btn btn-primary">Update</button> -->
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
  </section><!-- /.content -->
</div>

<!-- moodal di sini -->

</div>

<script>
  $(document).ready(function () {
      $('.tanggal').datepicker({
          autoclose  : true,
          format     : 'yyyy-mm-dd',
          changeMonth: true,
          changeYear : true
      });
  });
</script>