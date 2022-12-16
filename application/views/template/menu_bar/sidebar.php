  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
       <div class="user-panel">
        <div class="pull-left image">
        <p><?php echo $this->session->userdata['username'] ?></p>
          <a href=""><i class="fa fa-circle text-success"></i> Online</a>
        
        </div>
        <div class="pull-left info">
         
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MIN MENU</li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Setting</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url('c_akun')?>"><i class="fa fa-circle-o"></i>Data akun</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-list"></i> <span>master</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php if(($this->session->userdata['level']==='ADMIN')){?>
            <li><a href="<?php echo base_url('c_departemen')?>"><i class="fa fa-circle-o"></i>Departemen</a></li>
            <li><a href="<?php echo base_url('c_karyawan')?>"><i class="fa fa-circle-o"></i>Karyawan</a></li>
            <?php } 
            if (($this->session->userdata['level']==='ADMIN DEPT') or ($this->session->userdata['level']==='ADMIN')){ ?>
            <li><a href="<?php echo base_url('c_inventaris')?>"><i class="fa fa-circle-o"></i>Data Inventaris</a></li>
            <!-- <li><a href="<?php //echo base_url('c_teknisi')?>"><i class="fa fa-circle-o"></i>Data teknisi</a></li> -->
            <?php } ?>
          </ul>
        
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Transkaksi</span>
          </a>
          <ul class="treeview-menu">
            <?php if(($this->session->userdata['level']==='ADMIN') OR ($this->session->userdata['level']==='ADMIN DEPT') or ($this->session->userdata['level']==='MANAGER DEPT') or ($this->session->userdata['level']==='MANAGER MTN') or ($this->session->userdata['level']==='TEKNISI')){?>
            <li><a href="<?php echo base_url('c_permintaan_new')?>"><i class="fa fa-circle-o"></i>Permintaan</a></li>
            <li><a href="<?php echo base_url('c_pengajuan_new')?>"><i class="fa fa-circle-o"></i>pengajuan</a></li>
            <?php } ?>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-table"></i> <span>Laporan</span>
          </a>
          <?php if(($this->session->userdata['level']==='ADMIN') or ($this->session->userdata['level']==='MANAGER MTN')){?>
          <ul class="treeview-menu">
            <li class="active"><a href="<?php echo base_url('c_laporan_permintaan')?>"><i class="fa fa-circle-o"></i>laporan permintaan</a></li>
            <li class="active"><a href="<?php echo base_url('C_laporan_pengajuan')?>"><i class="fa fa-circle-o"></i>laporan pengajuan</a></li>
          </ul>
          <?PHP } ?>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
<!-- <div class="control-sidebar-bg"></div>
</div> -->