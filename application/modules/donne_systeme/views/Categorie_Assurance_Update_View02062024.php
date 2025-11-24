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
    include 'includes/Menu_Categorie_Assurance.php';
    ?>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">

      <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Modification d'une catégorie d'assurance</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form id="FormData" action="<?php echo base_url()?>donne_systeme/Categorie_Assurance/update" method="POST" enctype="multipart/form-data">
                <div class="card-body row">
                  <div class="form-group col-lg-6">
                    <label for="exampleInputEmail1">Nom de la catégorie <spam class="text-danger">*</spam> </label>
                    <input type="hidden" class="form-control" id="ID_CATEGORIE_ASSURANCE" name="ID_CATEGORIE_ASSURANCE"  value="<?php echo $data['ID_CATEGORIE_ASSURANCE']?>">
                    <input type="text" class="form-control" id="DESCRIPTION" name="DESCRIPTION"  value="<?php echo $data['DESCRIPTION']?>">
                    <?php echo form_error('DESCRIPTION', '<div class="text-danger">', '</div>'); ?>
                  </div>
                  <div class="form-group col-lg-6">
                    <label for="exampleInputEmail1">Droit d'affiliation <spam class="text-danger">*</spam> </label>
                    <input type="number" class="form-control" id="DROIT_AFFILIATION" name="DROIT_AFFILIATION"  value="<?php echo $data['DROIT_AFFILIATION']?>">
                    <?php echo form_error('DROIT_AFFILIATION', '<div class="text-danger">', '</div>'); ?>
                  </div>

                  <div class="form-group col-lg-6">
                    <label for="exampleInputEmail1">Cotisation mensuelle<spam class="text-danger">*</spam> </label>
                    <input type="number" class="form-control" id="COTISATION_MENSUELLE" name="COTISATION_MENSUELLE" value="<?php echo $data['COTISATION_MENSUELLE']?>">
                    <?php echo form_error('COTISATION_MENSUELLE', '<div class="text-danger">', '</div>'); ?>
                  </div>
                  <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Plafond annuel <spam class="text-danger">*</spam> </label>
                    <input type="number" class="form-control" id="PLAFOND_ANNUEL" name="PLAFOND_ANNUEL" value="<?php echo $data['PLAFOND_ANNUEL']?>">
                    <?php echo form_error('PLAFOND_ANNUEL', '<div class="text-danger">', '</div>'); ?>
                  </div>

                  <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Plafond Lunette médicale<spam class="text-danger">*</spam> </label>
                    <input type="number" class="form-control" id="PLAFOND_LUNETTE" name="PLAFOND_LUNETTE" value="<?php echo $data['PLAFOND_LUNETTE']?>">
                    <?php echo form_error('PLAFOND_LUNETTE', '<div class="text-danger">', '</div>'); ?>
                  </div>

                  <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Plafond Montures<spam class="text-danger">*</spam> </label>
                    <input type="number" class="form-control" id="PLAFOND_MONTURES" name="PLAFOND_MONTURES" value="<?php echo $data['PLAFOND_MONTURES']?>">
                    <?php echo form_error('PLAFOND_MONTURES', '<div class="text-danger">', '</div>'); ?>
                  </div>

                  <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Plafond Prothèses dentaires<spam class="text-danger">*</spam> </label>
                    <input type="number" class="form-control" id="PLAFOND_PROTHESES_DENTAIRES" name="PLAFOND_PROTHESES_DENTAIRES" value="<?php echo $data['PLAFOND_PROTHESES_DENTAIRES']?>">
                    <?php echo form_error('PLAFOND_PROTHESES_DENTAIRES', '<div class="text-danger">', '</div>'); ?>
                  </div>

                  <div class="form-group col-lg-6">
                    <label for="exampleInputEmail1">Plafond hospitalisation<spam class="text-danger">*</spam> </label>
                    <input type="number" class="form-control" id="PLAFOND_COUVERTURE_HOSP_JOURS" name="PLAFOND_COUVERTURE_HOSP_JOURS" value="<?php echo $data['PLAFOND_COUVERTURE_HOSP_JOURS']?>">
                    <?php echo form_error('PLAFOND_COUVERTURE_HOSP_JOURS', '<div class="text-danger">', '</div>'); ?>
                  </div>
                  <div class="form-group col-lg-12">
                    <label for="exampleInputEmail1">Regime <spam class="text-danger">*</spam> </label>
                    <select class="custom-select" name="ID_REGIME_ASSURANCE" id="ID_REGIME_ASSURANCE">
                          <option>-- Select --</option>
                          <?php
                          foreach ($regime as $regimes) {
                          if ($regimes['ID_REGIME_ASSURANCE'] == $data['ID_REGIME_ASSURANCE']) {
                            echo"<option value='".$regimes['ID_REGIME_ASSURANCE']."' selected>".$regimes['DESCRIPTION']."</option>";
                          }
                          else{
                            echo"<option value='".$regimes['ID_REGIME_ASSURANCE']."'>".$regimes['DESCRIPTION']."</option>";
                          }
                          }
                          ?>
                        </select>
                    
                    <?php echo form_error('ID_REGIME_ASSURANCE', '<div class="text-danger">', '</div>'); ?>
                  </div> 
                  

                  <div class="form-group col-lg-6 row">

                  <div class="form-group col-lg-12">
                    <h4>
                      <small>Couverture Medicament</small>
                    </h4>
                  </div>

                    <div class="form-group col-lg-12">
                    <label for="exampleInputEmail1">Médicament générique<spam class="text-danger">*</spam> </label>
                    <input type="number" class="form-control" id="MED_GEN" name="MED_GEN" value="<?php echo $med1['POURCENTAGE']?>" min="1" max="100">
                    <?php echo form_error('MED_GEN', '<div class="text-danger">', '</div>'); ?>
                  </div>

                  <div class="form-group col-lg-12">
                    <label for="exampleInputEmail1">Médicament spécialisée<spam class="text-danger">*</spam> </label>
                    <input type="number" class="form-control" id="MED_SEP" name="MED_SEP" value="<?php echo $med2['POURCENTAGE']?>" min="1" max="100">
                    <?php echo form_error('MED_SEP', '<div class="text-danger">', '</div>'); ?>
                  </div>

                  </div> 

                  
                  <div class="form-group col-lg-6 row">
                  <div class="form-group col-lg-12">
                    <h4>
                      <small>Couverture Structure Sanitaire</small>
                    </h4>
                  </div>


                    <div class="form-group col-lg-12">
                    <label for="exampleInputEmail1">Structure Sanitaire I<spam class="text-danger">*</spam> </label> 
                    <input type="number" class="form-control" id="STRUCT_A" name="STRUCT_A" value="<?php echo $struca['POURCENTAGE']?>" min="1" max="100">
                    <?php echo form_error('STRUCT_A', '<div class="text-danger">', '</div>'); ?>
                  </div>


                  <div class="form-group col-lg-12">
                    <label for="exampleInputEmail1">Structure Sanitaire II<spam class="text-danger">*</spam> </label>
                    <input type="number" class="form-control" id="STRUCT_B" name="STRUCT_B" value="<?php echo $strucb['POURCENTAGE']?>" min="1" max="100">
                    <?php echo form_error('STRUCT_B', '<div class="text-danger">', '</div>'); ?>
                  </div>

                  <div class="form-group col-lg-12">
                    <label for="exampleInputEmail1">Structure Sanitaire III<spam class="text-danger">*</spam> </label>
                    <input type="number" class="form-control" id="STRUCT_C" name="STRUCT_C" value="<?php echo $strucc['POURCENTAGE']?>" min="1" max="100">
                    <?php echo form_error('STRUCT_C', '<div class="text-danger">', '</div>'); ?>
                  </div>

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
