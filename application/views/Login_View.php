<!DOCTYPE html>
<html>
<head>
  <title>MISanté - <?=$title?></title>
<?php include VIEWPATH.'includes/header.php' ?>
<!-- <link rel="icon" href="<?php echo base_url() ?>dist/img/favicon.ico" type="image/gif" sizes="16x16"> -->
<link rel="icon" href="<?php echo base_url() ?>dist/img/favicon.ico" type="image/gif">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <img src="<?php echo base_url() ?>dist/img/mislogo.png" alt="">
    <a href="#">
        <b>
            <!-- <i class="nav-icon fas fa-chess-queen"></i> -->

      <span class="brand-text font-weight-light"> Mutualité Interprofessionnelle de Santé </span></b></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">     
      <span class="fas fa-user"></span>
      <span class="brand-text font-weight-light"> CONNEXION</span>
    </p>
      <?php if($message) echo $message ?>

     <form action="<?= base_url('Login/do_login') ?>" method="POST">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Email/Téléphone" name="USERNAME">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="PASSWORD">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
         
          <!-- /.col -->
          <div class="col-12">
            <button type="submit" class="btn btn-success btn-block">Se connecter</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

     
      <!-- /.social-auth-links -->

      <p class="mb-1">
        <a href="<?php echo base_url()?>Login/password_oublie" class="btn btn-link" >Mot de passe oublié</a>
      </p>
    
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<!--  -->
<script src="<?php echo base_url()?>plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url()?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url()?>dist/js/adminlte.min.js"></script>

  <script>
  $(document).ready(function(){ 
    $('#messages').delay(5000).hide('slow');
    });
</script>

</body>
</html>
