  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-3">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <?php foreach ($permintaan_baru as $baru) {?>
              <h3><?php echo $baru->status_baru?></h3>
              <?php } ?>
              <p>Permintaan Baru</p><br>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-3">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <?php foreach ($app_mng_dept as $dept) {?>
              <h3><?php echo $dept->dept ?><sup style="font-size: 20px"></sup></h3>
              <?php } ?>
              <p>Permintaan Yang Telah di Approve Manager Departemen</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer"> <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-3">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <?php foreach ($app_mtn as $mtn) {?>
              <h3><?php echo $mtn->app_mtn?></h3>
              <?php }?>
              <p>Permintaan Yang Telah di Approve manager maintenace</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer"> <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-3">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <?php foreach ($dtselesai as $selesai) {?>
              <h3><?php echo $selesai->data_selesai ?></h3>
              <?php } ?>
              <p>Permintaan Yang telah selesai</p><br>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>

      <!-- pengajuan -->
        <div class="row">
        <div class="col-lg-3 col-xs-3">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <?php foreach ($permintaan_baru_pg as $baru) {?>
              <h3><?php echo $baru->status_baru?></h3>
              <?php } ?>
              <p>Pengajuan Baru</p><br>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-3">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <?php foreach ($app_mng_dept_pg as $dept) {?>
              <h3><?php echo $dept->dept ?><sup style="font-size: 20px"></sup></h3>
              <?php } ?>
              <p>Pengajuan di Approve Manager Departemen</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer"> <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-3">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <?php foreach ($app_mtn_pg as $mtn) {?>
              <h3><?php echo $mtn->app_mtn?></h3>
              <?php }?>
              <p>Pengajuan di Approve manager maintenace</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer"> <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-3">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <?php foreach ($dtselesai_pg as $selesai) {?>
              <h3><?php echo $selesai->data_selesai ?></h3>
              <?php } ?>
              <p>Pengajuan Yang telah selesai</p><br>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  

<!-- jQuery 3 -->