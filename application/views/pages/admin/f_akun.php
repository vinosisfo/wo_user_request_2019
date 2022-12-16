<div id="app">
<div class="content-wrapper"> 
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#fa-icons" data-toggle="tab">Tampilkan Data User</a></li>
            <!-- <li><a href="#" onclick="add_data(this)">Input Data User</a></li> -->
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
                          <th>username</th>
                          <th>password</th>
                          <th>level</th>
                          <th>status</th>                  
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="item in data_akun">
                          <td>{{item.id_user}}</td>
                          <td>{{item.username}}</td>
                          <td>{{item.password}}</td>
                          <td>{{item.level}}</td>
                          <td>{{item.status}}</td>
                          <td>
                            <button class="btn btn-primary btn-xs" v-on:click="select_row(item)">Edit</button>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div> 
            </div>
   
            <!--form input data-->  
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

              <form action="<?php echo base_url('c_akun/update_data')?>" method="POST" autocomplete="off">
              <div class="form-group" >
                <div class="col-md-10">
                  <label for="" class="control-label">username</label>
                  <input type="hidden" name="id_user" style="width: 30%;" autocomplate="off" class="form-control" id="exampleInputUsername" maxlength="20" minlength="5" required="required" v-model="edit_data.id_user">

                  <input type="text" name="username" style="width: 30%;" autocomplate="off" class="form-control" id="exampleInputUsername" maxlength="12" minlength="11" onkeypress="return hanyaAngka(event)" required="required" v-model="edit_data.username" readonly="readonly">
                </div>
              </div>

              <div class="form-group" >
                <div class="col-md-10">
                  <label for="" class="control-label">password</label>
                  <input type="password" name="password" class="form-control" style="width : 30%;" maxlength="20" minlength="3" required="required">
                </div>
              </div>

              <div class="form-group" >
                <div class="col-md-10">
                  <label for="" class="control-label">level</label>
                  <select name="level" class="form-control" required="required" style="width: 30%;">
                    <option value="edit_data.level">{{edit_data.level}}</option>
                    <option value="ADMIN">ADMIN</option>
                    <option value="MANAGER DEPT">Manager departemen</option>
                    <option value="MANAGER MTN">Manager maintenance</option>
                    <option value="ADMIN DEPT">Admin dept</option>
                    <option value="TEKNISI">Teknisi</option>
                  </select> 
                </div>
              </div>
              <br>
              <div class="footer" >
                <label></label>
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

<div class="modal fade" id="modal_form">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title judul"></h4>
      </div>
      <div class="modal-body">
        <div id="form_data"></div>
      </div>
      
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

</div>



<script>
  function add_data(){
    $.post("<?php echo base_url('c_akun/input_data')?>",{format : "input"},function(data){
      $(".judul").html("Input Data User")
      $("#modal_form").modal("show")
      $("#form_data").html(data)
    })
  }
</script>