  <?php
  include VIEWPATH.'includes/new_header.php';
  include VIEWPATH.'includes/new_top_menu.php';
  include VIEWPATH.'includes/new_menu_principal.php';
  ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php
    include 'includes/Menu_Membre.php';
    ?>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <?php 
                          if(!empty($this->session->flashdata('message')))
                             echo $this->session->flashdata('message');
            ?>
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Modification d'un affili&eacute;</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->

         <div class="card-body">
               <!-- <form id="FormData" action="#" method="POST"> -->
               <form id="FormData" action="<?php echo base_url()?>membre/Membre/update" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="ID_MEMBRE" class="form-control" value="<?php echo $selected['ID_MEMBRE']?>" id="ID_MEMBRE">
                      <div class="row">
                         <div class="form-group col-md-4">
                          <label for="NOM">
                             Nom
                             <i class="text-danger"> *</i>
                          </label>
                          <input type="text" name="NOM" class="form-control" value="<?php echo $selected['NOM']?>" id="NOM">
                          <?php echo form_error('NOM', '<div class="text-danger">', '</div>'); ?>
                      </div>
                  <div class="form-group col-md-4">
                          <label for="ID_TYPE_STRUCTURE">
                             Pr&eacute;nom
                             <i class="text-danger"> *</i>
                          </label>
                          <input type="text" name="PRENOM" class="form-control" value="<?php echo $selected['PRENOM']?>" id="PRENOM">
                          <?php echo form_error('PRENOM', '<div class="text-danger">', '</div>'); ?>
                       </div>
                       <div class="form-group col-md-4">
                    <label for="">Photo Passport</label>
                     <input type="file" name="URL_PHOTO" value="<?=set_value('URL_PHOTO')?>" accept="image/png, image/jpeg" class="form-control" id="URL_PHOTO">
                          <?php echo form_error('URL_PHOTO', '<div class="text-danger">', '</div>'); ?>
                  </div>

                       <div class="form-group col-md-3">
                          <label for="CNI">
                             CNI/PASSPORT
                             <i class="text-danger"> *</i>
                          </label>
                          <input type="text" name="CNI" class="form-control" value="<?php echo $selected['CNI']?>" id="CNI">
                          <?php echo form_error('CNI', '<div class="text-danger">', '</div>'); ?>
                       </div>
                       <div class="form-group col-md-3">
                          <label for="ID_SEXE">
                             Sexe
                             <i class="text-danger"> *</i>
                          </label><br>
                          <?php 
                          if ($selected['ID_SEXE'] == 1) {
                            ?>
                            <label class="radio-inline">
                            <input type="radio" name="ID_SEXE" id="inlineRadio1" value="1" checked="checked"> Homme &nbsp;&nbsp;&nbsp;&nbsp;
                          </label>
                          <label class="radio-inline">
                            <input type="radio" name="ID_SEXE" id="inlineRadio2" value="2"> Femme
                          </label>
                            <?php
                          }
                          else{
                            ?>
                            <label class="radio-inline">
                            <input type="radio" name="ID_SEXE" id="inlineRadio1" value="1"> Homme &nbsp;&nbsp;&nbsp;&nbsp;
                          </label>
                          <label class="radio-inline">
                            <input type="radio" name="ID_SEXE" id="inlineRadio2" value="2" checked="checked"> Femme
                          </label>
                            <?php
                          }
                          ?>
                          
                          <?php echo form_error('ID_SEXE', '<div class="text-danger">', '</div>'); ?>
                       </div>
                       <div class="form-group col-md-3">
                          <label for="DATE_NAISSANCE">
                              Date Naissance
                             <i class="text-danger"> *</i>
                          </label>
                          <input type="date" name="DATE_NAISSANCE" class="form-control" value="<?php echo $selected['DATE_NAISSANCE']?>" id="DATE_NAISSANCE">
                          <?php echo form_error('DATE_NAISSANCE', '<div class="text-danger">', '</div>'); ?>
                       </div>
                       <div class="form-group col-md-3">
                          <label for="ID_GROUPE_SANGUIN">
                             Groupe Sanguin
                             <i class="text-danger"> *</i>
                          </label>
                          <select class="form-control" name="ID_GROUPE_SANGUIN" id="ID_GROUPE_SANGUIN">
                          <option value="" >-- Sélectionner --</option>
                          <?php
                          foreach ($groupesanguin as $key => $value) {
                            if ($value['ID_GROUPE_SANGUIN'] == $selected['ID_GROUPE_SANGUIN']) {
                              ?>
                              <option value="<?=$value['ID_GROUPE_SANGUIN']?>" selected="selected"><?=$value['DESCRIPTION']?></option>
                              <?php
                            }
                            else{
                              ?>
                              <option value="<?=$value['ID_GROUPE_SANGUIN']?>" ><?=$value['DESCRIPTION']?></option>
                              <?php
                            }
                           ?>

                          
                          <?php
                           } ?>
                          </select>
                          <?php echo form_error('ID_GROUPE_SANGUIN', '<div class="text-danger">', '</div>'); ?>
                       </div>
                       <div class="form-group col-md-3">
                          <label for="PROVINCE_ID">
                             Province de résidence
                             <i class="text-danger"> *</i>
                          </label>
                          <select class="form-control"  onchange="province(this)" name="PROVINCE_ID" id="PROVINCE_ID">
                          <option value="" >-- Sélectionner --</option>
                          <?php
                          foreach ($province as $key => $value) { 
                            if ($value['PROVINCE_ID'] == $selected['PROVINCE_ID']) {
                              ?>
                            <option value="<?=$value['PROVINCE_ID']?>" selected="selected"><?=$value['PROVINCE_NAME']?></option>
                              <?php
                            }
                            else{
                              ?>
                              <option value="<?=$value['PROVINCE_ID']?>"><?=$value['PROVINCE_NAME']?></option>
                              <?php
                            }
                           } 
                           ?>
                          </select>
                          <?php echo form_error('PROVINCE_ID', '<div class="text-danger">', '</div>'); ?>
                       </div>
                       <div class="form-group col-md-3">
                          <label for="COMMUNE_ID">
                             Commune de résidence
                             <i class="text-danger"> *</i>
                          </label>
                          <select class="form-control"  aria-describedby="emailHelp" name="COMMUNE_ID" id="COMMUNE_ID">
                            <option value="">-- Sélectionner --</option>
                            <?php
                          foreach ($commune as $key => $value) { 
                            if ($value['COMMUNE_ID'] == $selected['COMMUNE_ID']) {
                              ?>
                            <option value="<?=$value['COMMUNE_ID']?>" selected="selected"><?=$value['COMMUNE_NAME']?></option>
                              <?php
                            }
                            else{
                              ?>
                              <option value="<?=$value['COMMUNE_ID']?>"><?=$value['COMMUNE_NAME']?></option>
                              <?php
                            }
                           } 
                           ?>
                          </select>
                          <?php echo form_error('COMMUNE_ID', '<div class="text-danger">', '</div>'); ?>
                       </div>
                       <div class="form-group col-md-3">
                          <label for="TELEPHONE">
                             Téléphone
                             <i class="text-danger"> *</i>
                          </label>
                          <input type="number" name="TELEPHONE" class="form-control" value="<?php echo $selected['TELEPHONE']?>" id="TELEPHONE">
                          <?php echo form_error('TELEPHONE', '<div class="text-danger">', '</div>'); ?>
                       </div>
                       <div class="form-group col-md-3">
                          <label for="ID_EMPLOI">
                              Emploi
                             <i class="text-danger"> *</i>
                          </label>
                          <select class="form-control" name="ID_EMPLOI" id="ID_EMPLOI">
                          <option value="" >-- Sélectionner --</option>
                          <?php
                          foreach ($emploi as $key => $value) {
                            if ($value['ID_EMPLOI'] == $selected['ID_EMPLOI']) {
                              ?>
                              <option value="<?=$value['ID_EMPLOI']?>" selected="selected"><?=$value['DESCRIPTION']?></option>
                              <?php
                            }
                            else{
                              ?>
                              <option value="<?=$value['ID_EMPLOI']?>"><?=$value['DESCRIPTION']?></option>
                              <?php
                            }

                           } ?>
                          </select>
                          <?php echo form_error('ID_EMPLOI', '<div class="text-danger">', '</div>'); ?>
                       </div>

                       <div class="form-group col-md-3">
                          <label for="ADRESSE">
                              Adresse de residence actuelle
                             <i class="text-danger"> *</i>
                          </label>
                          <input type="text" name="ADRESSE" class="form-control" value="<?php echo $selected['ADRESSE']?>" id="ADRESSE">
                          <?php echo form_error('ADRESSE', '<div class="text-danger">', '</div>'); ?>
                       </div>

                       <div class="form-group col-md-3">
                          <label for="DATE_ADHESION">
                             Date d'adhesion
                             <i class="text-danger"> *</i>
                          </label>
                          <input type="date" name="DATE_ADHESION" class="form-control" value="<?php echo $selected['DATE_ADHESION']?>" id="DATE_ADHESION">
                          <?php echo form_error('DATE_ADHESION', '<div class="text-danger">', '</div>'); ?>
                       </div>

                       <div class="form-group col-md-3">
                          <label for="CODE_AFILIATION">
                             Code d'afiliation
                             <i class="text-danger"> *</i>
                          </label>
                          <input type="text" readonly="readonly" name="CODE_AFILIATION" class="form-control" value="<?php echo $selected['CODE_AFILIATION']?>" id="CODE_AFILIATION">
                          <?php echo form_error('CODE_AFILIATION', '<div class="text-danger">', '</div>'); ?>
                       </div>

                       <div class="form-group col-md-3">
                          <label for="ID_AGENCE">
                              Agence
                             <i class="text-danger"> *</i>
                          </label>
                          <input type="hidden" readonly="readonly" name="ID_AGENCE" class="form-control" value="<?php echo $agence['ID_AGENCE']?>" id="ID_AGENCE">
                          <input type="text" readonly="readonly" class="form-control" value="<?php echo $agence['DESCRIPTION']?>" id="DESCRIPTION">
                          <?php echo form_error('ID_AGENCE', '<div class="text-danger">', '</div>'); ?>
                       </div>

                       
                    </div>
                                        <div class="row" style="margin-top: 5px">
                                            <div class="col-12 text-center" id="divdata">
                                                <input type="submit" value="Enregistrer" class="btn btn-primary"/>
                                            </div>
                                        </div>
                                    </form>
          </div> 
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
 <?php
  include VIEWPATH.'includes/new_copy_footer.php';
  ?>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<?php
  include VIEWPATH.'includes/new_script.php';
  ?>
<!-- jQuery -->

</body>
</html>
<script>
  $(document).ready(function(){ 
    $('#message').delay(5000).hide('slow');
    });
</script>
<script>

     function province(va){
      var provine_id= $(va).val();
      $.post('<?php echo base_url('membre/Membre/get_commune')?>',
          {provine_id:provine_id},
          function(data){
            $('#COMMUNE_ID').html(data);
          });
     }
     </script>