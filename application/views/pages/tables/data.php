<div class="content-wrapper"> 
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#fa-icons" data-toggle="tab">Tampilkan Data alumni</a></li>
            <li><a href="#glyphicons" data-toggle="tab">Tambah Data alumni</a></li>
          </ul>
        
          <div class="tab-content">
            <div class="tab-pane active" id="fa-icons">
              <div class="box">
                <div class="box-body scrolltable">
                  <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <?php 
                            echo $this->session->flashdata('msg');
                          ?>
                          <th width="30px" align="center">No</th>
                          <th>NPM</th>
                          <th>Nama</th>
                          <th>thn lulus</th>
                          <th>Jurusan</th>
                          <th>IPK</th>                  
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td><?php //echo $no++ ?></td>
                          <td><?php //echo $alumni->npm ?></td>
                          <td><?php //echo $alumni->nama_alumni ?></td>
                          <td><?php //echo $alumni->thn_lulus ?></td>
                          <td><?php //echo $alumni->jurusan ?></td>
                          <td><?php //echo $alumni->ipk ?></td>
                          <td>jdsakkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkdsadmsnadmandm jdsakkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkdsadmsnadmandm</td>
                        </tr>
                        <tr>
                          <td><?php //echo $no++ ?></td>
                          <td><?php //echo $alumni->npm ?></td>
                          <td><?php //echo $alumni->nama_alumni ?></td>
                          <td><?php //echo $alumni->thn_lulus ?></td>
                          <td><?php //echo $alumni->jurusan ?></td>
                          <td><?php //echo $alumni->ipk ?></td>
                         <td>jdsakkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkdsadmsnadmandm</td>
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
                  <h3 class="box-title">Form Input Data User</h3>
                </div><!-- form start -->
                  
                <form action="<?php echo base_url(). 'admin/C_alumni/add_alumni'; ?>" method="POST" role="form">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="exampleInputEmail1">kode Alumni</label>
                      <input type="text" name="kode_alumni" autocomplate="off" style="width: 30%;" class="form-control" id="exampleInputUsername" placeholder="nama" maxlength="50" required='required' readonly='readonly' >
                    </div>

                    <div class="form-group">
                      <label for="exampleInputEmail1">Nama Alumni <font color ="red">*</font> </label>
                      <input type="text" name="nama_alumni" autocomplate="off" style="width: 30%;" class="form-control" id="exampleInputPassword1" placeholder="nama alumni" minlength="2" maxlength="50"  pattern="[a-zA-Z . , - ]{1,}" autofocus="autofocus" required="required">
                    </div>

                    <div class="form-group">
                      <label for="exampleInputEmail1">NPM <font color ="red">*</font></label>
                      <input type="text" name="npm" style="width: 30%;" autocomplate="off" class="form-control" id="exampleInputUsername" placeholder="npm" maxlength="20" minlength="5" onkeypress="return hanyaAngka(event)" required="required">
                    </div>

                    <div class="form-group">
                      <label for="exampleInputEmail1">Tahun lulus <font color ="red">*</font></label>
                      <input type="text" name="tahun_lulus" style="width: 30%;" class="form-control tanggal" id="exampleInputUsername" placeholder="tahun lulus" readonly="readonly" required="required">
                    </div>

                    <div class="form-group">
                      <label for="exampleInputEmail1">Jurusan <font color ="red">*</font> </label>
                      <select class="form-control" required name="jurusan" style="width: 30%;">
                          <option value="">pilih jurusan</option>
                          <option value="sistem informasi">sistem informasi</option>
                      </select>
                    </div>

                    <div class="form-group">
                      <label for="exampleInputEmail1">Judul Skripsi <font color ="red">*</font> </label>
                      <textarea name="judul" style="width: 30%;" autocomplate="off" class="form-control" id="exampleInputUsername" maxlength="150"   required="required"></textarea>
                    </div>

                    <div class="form-group">
                      <label for="exampleInputEmail1">IPK <font color ="red">*</font></label>
                      <input type="text" name="ipk" class="form-control" autocomplate="off" placeholder="4,00" maxlength="5" minlength="3" style="width: 30%;" pattern="[0-9 . - ]{1,}" autofocus="autofocus" required="required">
                    </div>
                
                    <div class="form-group">
                      <label for="exampleInputEmail1">Password untuk alumni</label>
                      <input type="text" name="pass" style="width: 30%;" class="form-control" id="exampleInputUsername" placeholder="" readonly="readonly">
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
  </section><!-- /.content -->
</div>