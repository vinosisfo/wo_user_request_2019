<div id="app">
<div class="content-wrapper"> 
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#fa-icons" data-toggle="tab">Tampilkan Data karyawan</a></li>
            <li><a href="#glyphicons" data-toggle="tab">Tambah Data karyawan</a></li>
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
                          <th>Nama</th>
                          <th>no tlp / email</th>
                          <th>departemen</th>                  
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="item in data_karyawan">
                          <td>{{item.id_karyawan}}</td>
                          <td>{{item.nama_karyawan}}</td>
                          <td>{{item.no_tlp}}/{{item.email}}</td>
                          <td>{{item.nama_departemen}}</td>
                          <td>
                            <button class="btn btn-primary btn-xs" v-on:click="select_row(item)">Edit</button>
                            <button class="btn btn-danger btn-xs" v-on:click="hapus_data(item.id_karyawan)">delete</button>
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
                  <h3 class="box-title">Form Input Data karyawan</h3>
                </div><!-- form start -->
                  
                <form id="f_admin" class="form-horizontal" action="<?php echo base_url('c_karyawan/simpan_data')?>" method="POST">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Nama karayawan <font color ="red">*</font> </label>
                      <input type="text" name="nama_karyawan" autocomplate="off" style="width: 30%;" class="form-control" id="exampleInputPassword1" placeholder="nama karayawan" minlength="2" maxlength="50"  pattern="[a-zA-Z . , - ]{1,}" autofocus="autofocus" required="required">
                    </div>

                    <div class="form-group">
                      <label for="exampleInputEmail1">No Telepon <font color ="red">*</font></label>
                      <input type="text" name="no_tlp" style="width: 30%;" autocomplate="off" class="form-control" id="exampleInputUsername" placeholder="no_tlp" maxlength="13" minlength="5" onkeypress="return hanyaAngka(event)" required="required">
                    </div>

                    <div class="form-group">
                      <label for="exampleInputEmail1">Alamat <font color ="red">*</font></label>
                      <textarea name="alamat" maxlength="300" minlength="10" class="form-control" style="width:30%"></textarea>
                    </div>

                    <div class="form-group">
                      <label>Email</label>
                      <input type="email" name="email" class="form-control" maxlength="50" minlength="8" required="required" style="width: 30%;" >
                    </div>

                    <div class="form-group">
                      <label class="exampleInputEmail1">departemen</label>
                      <select name="departemen" class="form-control" required="required" style="width: 30%;">
                        <option value="">pilih departemen</option>
                        <?php foreach ($data as $item) {?>
                        <option value="<?php echo $item->id_departemen?>"><?php echo $item->nama_departemen?></option>
                        <?php } ?>
                      </select>
                    </div>

                    <div class="form-group">
                      <label class="exampleInputEmail1">Level</label>
                      <select name="level" class="form-control" required="required" style="width: 30%;">
                        <option value="">PILIH</option>
                        <option value="ADMIN">ADMIN</option>
                        <option value="MANAGER DEPT">Manager departemen</option>
                        <option value="MANAGER MTN">Manager maintenance</option>
                        <option value="ADMIN DEPT">Admin dept</option>
                        <option value="TEKNISI">Teknisi</option>
                      </select>
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

              <form action="<?php echo base_url('c_karyawan/update_data')?>" method="POST">
              <div class="form-group" >
                <div class="col-md-12">
                  <label for="" class="control-label">No telp</label>
                  <input type="hidden" name="id_karyawan" style="width: 30%;" autocomplate="off" class="form-control" id="exampleInputUsername" maxlength="20" minlength="5" required="required" v-model="edit_data.id_karyawan">
                   <input type="hidden" name="id_user" style="width: 30%;" autocomplate="off" class="form-control" id="exampleInputUsername" maxlength="20" minlength="5" required="required" v-model="edit_data.id_user">

                  <input type="text" name="no_tlp" style="width: 30%;" autocomplate="off" class="form-control" id="exampleInputUsername" placeholder=" --no_tlp--" maxlength="12" minlength="11" onkeypress="return hanyaAngka(event)" required="required" v-model="edit_data.no_tlp">
                </div>
              </div>

              <div class="form-group" >
                <div class="col-md-10">
                  <label for="" class="control-label">Alamat</label>
                  <textarea name="alamat" class="form-control" maxlength="200" minlength="10" required="required">{{edit_data.alamat}}</textarea>
                </div>
              </div>

              <div class="form-group" >
                <div class="col-md-10">
                  <label for="" class="control-label">Email</label>
                  <input type="email" name="email" class="form-control" maxlength="50" minlength="8" required="required" v-model="edit_data.email">
                </div>
              </div>

              <div class="form-group" >
                <div class="col-md-10">
                  <label class="exampleInputEmail1">departemen</label>
                      <select name="departemen" class="form-control" required="required" style="width: 30%;" v-model="edit_data.id_departemen" >
                        <option v-bind:value="edit_data.id_departemen">{{ edit_data.nama_departemen }}</option>
                        <?php foreach ($data as $item) {?>
                        <option value="<?php echo $item->id_departemen?>"><?php echo $item->nama_departemen?></option>
                        <?php } ?>
                      </select>
                </div>
              </div>

              <div class="form-group" >
                <div class="col-md-10">
                  <label class="exampleInputEmail1">Level</label>
                      <select name="level" class="form-control" required="required" style="width: 30%;">
                        <option v-model='edit_data.level'>{{edit_data.level}}</option>
                        <option value="MANAGER DEPT">Manager departemen</option>
                        <option value="MANAGER MTN">Manager maintenance</option>
                        <option value="ADMIN DEPT">Admin dept</option>
                      </select>
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