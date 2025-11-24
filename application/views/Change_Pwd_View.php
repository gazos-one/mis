  <?php
  include VIEWPATH.'includes/new_header.php';
  include VIEWPATH.'includes/new_top_menu.php';
  include VIEWPATH.'includes/new_menu_principal.php';
  ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Modification du mot de passe</h1>
          </div>





        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Modification du mot de passe</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
            <form role="form" action="<?=base_url('Change_Pwd/changer')?>" enctype="multipart/form-data" method="POST">

                <div class="card-body">
                  <div class="form-group">
                    <label for="">Ancien mot de passe</label>
                   <input type="password" class="form-control" name="ACTUEL_PASSWORD" value="<?=set_value('ACTUEL_PASSWORD')?>" autofocus>
                             <div style="color: red">   <?php echo form_error('ACTUEL_PASSWORD');
                             echo $msg;

                              ?> </div>
                  </div>


                 <div class="form-group">
                    <label for="">Nouveau mot de passe</label>
              <input type="password" class="form-control" name="NEW_PASSWORD" value="<?=set_value('NEW_PASSWORD')?>" autofocus>
                             <div style="color: red">   <?php echo form_error('NEW_PASSWORD'); ?> </div>
                  </div>


                         <div class="form-group">
                    <label for="">Confirmer le nouveau mot de passe</label>
                <input type="password" class="form-control" name="PASSWORDCONFIRM" value="<?=set_value('PASSWORDCONFIRM')?>" autofocus>
                             <div style="color: red">   <?php echo form_error('PASSWORDCONFIRM'); ?> </div>
                  </div>

  
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Modifier</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
            </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-6">

          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>



<?php include VIEWPATH.'includes/footer.php' ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/js/bootstrap-select.min.js"></script>


</body>
</html>
