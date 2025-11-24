<?php
  include VIEWPATH.'includes/new_header.php';
  ?>
  
<!-- Site wrapper -->
<div class="wrapper">
  <?php
  include VIEWPATH.'includes/new_top_menu.php';
  include VIEWPATH.'includes/new_menu_principal.php';
  ?>

  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php 
    include 'includes/menu_user.php';
    ?>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">

      <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Enregistrement d'un utilisateur</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form id="FormData" action="<?php echo base_url()?>administration/User/add" method="POST" enctype="multipart/form-data">
                <div class="card-body row">
                  <div class="form-group col-lg-6">
                    <label for="exampleInputEmail1">Nom <spam class="text-danger">*</spam> </label>
                    <input type="text" class="form-control" id="NOM" name="NOM" placeholder="Nom" value="<?=set_value('NOM')?>">
                    <?php echo form_error('NOM', '<div class="text-danger">', '</div>'); ?>
                  </div>
                  <div class="form-group col-lg-6">
                    <label for="exampleInputEmail1">Pr&eacute;nom <spam class="text-danger">*</spam> </label>
                    <input type="text" class="form-control" id="PRENOM" name="PRENOM" placeholder="Pr&eacute;nom" value="<?=set_value('PRENOM')?>">
                    <?php echo form_error('PRENOM', '<div class="text-danger">', '</div>'); ?>
                  </div>

                  <div class="form-group col-lg-6">
                    <label for="exampleInputEmail1">Username<spam class="text-danger">*</spam> </label>
                    <input type="mail" class="form-control" id="USERNAME" name="USERNAME" placeholder="username@socarvie.bi" value="<?=set_value('USERNAME')?>">
                    <?php echo form_error('USERNAME', '<div class="text-danger">', '</div>'); ?>
                  </div>

                  <div class="form-group col-lg-6">
                    <label for="exampleInputEmail1">Password<spam class="text-danger">*</spam> </label>
                    <input type="password" class="form-control" id="PASSWORD" name="PASSWORD" value="<?=set_value('PASSWORD')?>">
                    <?php echo form_error('PASSWORD', '<div class="text-danger">', '</div>'); ?>
                  </div>
                  <div class="form-group col-lg-6">
                    <label for="exampleInputEmail1">Profile <spam class="text-danger">*</spam> </label>
                    <select class="custom-select" name="PROFIL_ID" id="PROFIL_ID">
                          <option>-- Select --</option>
                          <?php
                          foreach ($profil as $profils) {
                           echo"<option value='".$profils['PROFIL_ID']."'>".$profils['DESCRIPTION']."</option>";
                          }
                          ?>
                        </select>
                    
                    <?php echo form_error('PROFIL_ID', '<div class="text-danger">', '</div>'); ?>
                  </div> 

                  <div class="form-group col-lg-6">
                    <label for="exampleInputEmail1">Agence <spam class="text-danger">*</spam> </label>
                    <select class="custom-select" name="ID_AGENCE" id="ID_AGENCE">
                          <option>-- Select --</option>
                          <?php
                          foreach ($agence as $agences) {
                           echo"<option value='".$agences['ID_AGENCE']."'>".$agences['DESCRIPTION']."</option>";
                          }
                          ?>
                        </select>
                    
                    <?php echo form_error('ID_AGENCE', '<div class="text-danger">', '</div>'); ?>
                  </div> 
                  
                  
                  
                  
                  
                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary btn-block">Enregistrer</button>
                </div>
              </form>
            </div>
        
        
        <!-- /.card-body -->
        <!-- <div class="card-footer">
          Footer
        </div> -->
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php
 include VIEWPATH.'includes/new_copy_footer.php';  
  ?>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<?php
  include VIEWPATH.'includes/new_script.php';
  ?>
  <script>
  $(function () {
   
    //Date picker
    $('#DEBUT_EXERCICE').datetimepicker({
        format: 'L'
        // daysOfWeekDisabled: [0, 6]
    });    
    $('#FIN_EXERCICE').datetimepicker({
        format: 'L'
    });    

  })
 


</script>
</body>
</html>
