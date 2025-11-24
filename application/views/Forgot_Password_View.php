<!DOCTYPE html>
<html>
<head>
  <title>VOLCANO::<?=$title?></title>
<?php include VIEWPATH.'includes/header.php' ?>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b><i class="nav-icon fas fa-bus"></i>
      <span class="brand-text font-weight-light"> VOEX-AGPRC</span></b></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">     
      <span class="fas fa-user"></span>
      <span class="brand-text font-weight-light">Mot de passe oublié</span>
    </p>
      <?php if($message) echo $message ?>

     <form action="<?= base_url('Login/demander') ?>" method="POST">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Email / Téléphone" name="USERNAME">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Demander</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mt-3 mb-1">
        <a href="<?php echo base_url()?>Login">Login</a>
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
