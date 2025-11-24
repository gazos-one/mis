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
                <h3 class="card-title">Modificaion d'un utilisateur</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form id="FormData" action="<?php echo base_url()?>administration/User/update" method="POST" enctype="multipart/form-data">
                <div class="card-body row">
                  <div class="form-group col-lg-6">
                    <label for="exampleInputEmail1">Nom <spam class="text-danger">*</spam> </label>
                    <input type="text" class="form-control" id="NOM" name="NOM" value="<?php echo $data['NOM']?>">
                    <input type="hidden" class="form-control" id="ID_USER" name="ID_USER" value="<?php echo $data['ID_USER']?>">
                    <?php echo form_error('NOM', '<div class="text-danger">', '</div>'); ?>
                  </div>
                  <div class="form-group col-lg-6">
                    <label for="exampleInputEmail1">Pr&eacute;nom <spam class="text-danger">*</spam> </label>
                    <input type="text" class="form-control" id="PRENOM" name="PRENOM"  value="<?php echo $data['PRENOM']?>">
                    <?php echo form_error('PRENOM', '<div class="text-danger">', '</div>'); ?>
                  </div>

                  <div class="form-group col-lg-6">
                    <label for="exampleInputEmail1">Username<spam class="text-danger">*</spam> </label>
                    <input type="mail" class="form-control" id="USERNAME" name="USERNAME" value="<?php echo $data['USERNAME']?>">
                    <?php echo form_error('USERNAME', '<div class="text-danger">', '</div>'); ?>
                  </div>

                  <div class="form-group col-lg-6">
                    <label for="exampleInputEmail1">Password<spam class="text-danger">*</spam> </label><br>
                    Le mot de passe doit etre change par l'utilisateur
                    <?php echo form_error('PASSWORD', '<div class="text-danger">', '</div>'); ?>
                  </div>

                  
                  <div class="form-group col-lg-6">
                    <label for="exampleInputEmail1">Profile <spam class="text-danger">*</spam> </label>
                    <select class="custom-select" name="PROFIL_ID" id="PROFIL_ID">
                          <option>-- Select --</option>
                          <?php
                          foreach ($profil as $profils) {
                            if ($profils['PROFIL_ID'] == $data['PROFIL_ID']) {
                              echo"<option value='".$profils['PROFIL_ID']."' selected>".$profils['DESCRIPTION']."</option>";
                            }
                            else{
                              echo"<option value='".$profils['PROFIL_ID']."'>".$profils['DESCRIPTION']."</option>";
                            }
                           
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
                            if ($agences['ID_AGENCE'] == $data['ID_AGENCE']) {
                              echo"<option value='".$agences['ID_AGENCE']."' selected>".$agences['DESCRIPTION']."</option>";
                            }
                            else{
                              echo"<option value='".$agences['ID_AGENCE']."'>".$agences['DESCRIPTION']."</option>";
                            }
                           
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
