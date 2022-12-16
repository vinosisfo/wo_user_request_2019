<body class="hold-transition login-page" style="background:url(assets/img/animation-bg.jpg);
no-repeat fixed; background-size: cover;
 -webkit-background-size: cover; 
 -moz-background-size: cover; -o-background-size: cover;">
<div class="login-box">
  <div class="login-logo">
    <b>USER REQUEST </b>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>
    <?php echo $this->session->flashdata('msg');?>
    <form action="<?php echo base_url('C_login/login')?>" method="post">
      <div class="form-group has-feedback">
        <input type="text" name="usernanme" class="form-control" placeholder="username" required="required">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="pass" class="form-control" placeholder="Password" required="required">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
    <!-- /.social-auth-links -->
    <!-- <a href="#">I forgot my password</a><br> -->
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

