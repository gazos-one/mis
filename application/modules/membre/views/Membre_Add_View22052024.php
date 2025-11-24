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
              <!-- <div class="card-header">
                <h3 class="card-title">Ajout d'un affili&eacute;</h3>
              </div> -->
              <!-- /.card-header -->
              <!-- form start -->

         <div class="card-body">
               <!-- <form id="FormData" action="#" method="POST"> -->
               <form id="FormData" action="<?php echo base_url()?>membre/Membre/add" method="POST" enctype="multipart/form-data">
                      <div class="row">
                        <div class="col-md-12">
                          <h4>Identification de l'Affilié</h4>
                        </div>
                         <div class="form-group col-md-3">
                          <label for="NOM">
                             Nom
                             <i class="text-danger"> *</i>
                          </label>
                          <input type="text" name="NOM" class="form-control" value="<?=set_value('NOM')?>" id="NOM">
                          <?php echo form_error('NOM', '<div class="text-danger">', '</div>'); ?>
                      </div>
                  <div class="form-group col-md-3">
                          <label for="ID_TYPE_STRUCTURE">
                             Pr&eacute;nom
                             <i class="text-danger"> *</i>
                          </label>
                          <input type="text" name="PRENOM" class="form-control" value="<?=set_value('PRENOM')?>" id="PRENOM">
                          <?php echo form_error('PRENOM', '<div class="text-danger">', '</div>'); ?>
                       </div>
                       <div class="form-group col-md-3">
                    <label for="">Photo Passport <i class="text-danger"> *</i></label>
                     <input type="file" name="URL_PHOTO" value="<?=set_value('URL_PHOTO')?>" accept="image/png, image/jpeg" class="form-control" id="URL_PHOTO" required="required"> <!-- required="required-->
                          <?php echo form_error('URL_PHOTO', '<div class="text-danger">', '</div>'); ?>
                  </div>

                       <div class="form-group col-md-3">
                          <label for="CNI">
                             CNI/PASSPORT
                             <i class="text-danger"> *</i>
                          </label>
                          <input type="text" name="CNI" class="form-control" value="<?=set_value('CNI')?>" id="CNI">
                          <?php echo form_error('CNI', '<div class="text-danger">', '</div>'); ?>
                       </div>
                       <div class="form-group col-md-3">
                          <label for="ID_SEXE">
                             Sexe 
                             <i class="text-danger"> *</i>
                          </label><br>
                          <?php
                          if (set_value('ID_SEXE')) {
                           ?>
                           <label class="radio-inline">
                            <input type="radio" name="ID_SEXE" id="inlineRadio1" value="1" <?php if (set_value('ID_SEXE') == 1){echo"checked";} ?>> Homme &nbsp;&nbsp;&nbsp;&nbsp;
                          </label>
                          <label class="radio-inline">
                            <input type="radio" name="ID_SEXE" id="inlineRadio2" value="2" <?php if (set_value('ID_SEXE') == 2){echo"checked";} ?>> Femme
                          </label>
                           <?php
                          }
                          else{
                            ?>
                          <label class="radio-inline">
                            <input type="radio" name="ID_SEXE" id="inlineRadio1" value="1"> Homme &nbsp;&nbsp;&nbsp;&nbsp;
                          </label>
                          <label class="radio-inline">
                            <input type="radio" name="ID_SEXE" id="inlineRadio2" value="2"> Femme
                          </label>
                            <?php
                          }
                          ?>
                            
                          
                          <?php echo form_error('ID_SEXE', '<div class="text-danger">', '</div>'); ?>
                       </div>
                       <div class="form-group col-md-3">
                          <label for="DATE_NAISSANCE">
                              Date Naissance (Plus de <?php echo $agemin ?> ans)
                             <i class="text-danger"> *</i>
                          </label>
                          <!-- <?php
                          $todaydate = strtotime(date('Y-m-d'));
                          $realdate = strtotime('-16 year', $todaydate);
                          $realdate = date('Y-m-d', $realdate);
                          ?> -->
                          <input type="date" name="DATE_NAISSANCE" class="form-control" value="<?=set_value('DATE_NAISSANCE')?>" id="DATE_NAISSANCES">
                          <!-- <input type="text" name="DATE_NAISSANCE" class="form-control" value="<?=set_value('DATE_NAISSANCE')?>" id="DATE_NAISSANCE"> -->
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
                              ?>
                              <option value="<?=$value['ID_GROUPE_SANGUIN']?>" ><?=$value['DESCRIPTION']?></option>
                              <?php
                            }
                           ?>
                          </select>
                          <?php echo form_error('ID_GROUPE_SANGUIN', '<div class="text-danger">', '</div>'); ?>
                       </div>
                       <div class="form-group col-md-3">
                          <label for="TELEPHONE">
                             Téléphone
                             <i class="text-danger"> *</i>
                          </label>
                          <input type="number" name="TELEPHONE" class="form-control" value="<?=set_value('TELEPHONE')?>" id="TELEPHONE">
                          <?php echo form_error('TELEPHONE', '<div class="text-danger">', '</div>'); ?>
                       </div>
                       <div class="form-group col-md-3">
                          <label for="PROVINCE_ID">
                             Province de résidence
                             <i class="text-danger"> *</i>
                          </label>
                          <select class="form-control"  onchange="province(this)" name="PROVINCE_ID" id="PROVINCE_ID">
                          <option value="">-- Sélectionner --</option>
                          <?php
                          foreach ($province as $key => $value) { 
                              ?>
                              <option value="<?=$value['PROVINCE_ID']?>"><?=$value['PROVINCE_NAME']?></option>
                              <?php
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
                              ?>
                              <option value="<?=$value['COMMUNE_ID']?>"><?=$value['COMMUNE_NAME']?></option>
                              <?php
                           } 
                           ?>
                          </select>
                          <?php echo form_error('COMMUNE_ID', '<div class="text-danger">', '</div>'); ?>
                       </div>

                       <div class="form-group col-md-3">
                          <label for="ADRESSE">
                              Adresse de residence actuelle
                             <i class="text-danger"> *</i>
                          </label>
                          <input type="text" name="ADRESSE" class="form-control" value="<?=set_value('ADRESSE')?>" id="ADRESSE">
                          <?php echo form_error('ADRESSE', '<div class="text-danger">', '</div>'); ?>
                       </div>
                       
                       <div class="form-group col-md-3">
                          <label for="ID_EMPLOI">
                              Emploi 

                
                             <i class="text-danger"> *</i>
                             <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modalsm">
                  (Ajout nouveau emploi)
                </button>
                             
                          </label>
                          <select class="form-control" name="ID_EMPLOI" id="ID_EMPLOI">
                          <option value="" >-- Sélectionner --</option>
                          <?php
                          foreach ($emploi as $key => $value) {
                              ?>
                              <option value="<?=$value['ID_EMPLOI']?>"><?=$value['DESCRIPTION']?></option>
                              <?php
                           } ?>
                          </select>
                          <?php echo form_error('ID_EMPLOI', '<div class="text-danger">', '</div>'); ?>
                       </div>

                       

                       

                       

                       

                       

                       

                       

                       <input type="hidden" readonly="readonly" name="ID_AGENCE" class="form-control" value="<?php echo $agence['ID_AGENCE']?>" id="ID_AGENCE">
                       <input type="hidden" readonly="readonly" name="CODE_AFILIATION" class="form-control" value="" id="CODE_AFILIATION">
                       <input type="hidden" name="DATE_ADHESION" class="form-control" value="<?php echo date('Y-m-d')?>" readonly="readonly" id="DATE_ADHESION">
                       <!-- <input type="hidden" name="ID_REGIME_ASSURANCE" class="form-control" value="1" readonly="readonly" id="ID_REGIME_ASSURANCE"> -->

                       
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                          <h4>Enregistrer son assurance</h4>
                        </div>
                        <div class="col-md-2">
                          
                          <label for="ID_REGIME_ASSURANCE">
                              Regime d'assurance
                             <i class="text-danger"> *</i>
                          </label>
                        </div>
                        <div class="col-md-6">
                          <select  name="ID_REGIME_ASSURANCE" onchange="changeassurance()" id="ID_REGIME_ASSURANCE" class="form-control">
                          <option value="" >-- Sélectionner --</option>
                          <?php
                          foreach ($aregime as $key => $value) {
                              ?>
                              <option value="<?=$value['ID_REGIME_ASSURANCE']?>"><?=$value['DESCRIPTION']?></option>
                              <?php
                           } ?>
                          </select>
                          <?php echo form_error('ID_REGIME_ASSURANCE', '<div class="text-danger">', '</div>'); ?>
                       
                        </div>
                        <div class="col-md-4">
                          <!-- <input type="text" id="DATE_NAISSANCE" name="birthday" value="10/24/1984" /> -->
                        </div>

                        

                    </div>
                    <div class="row" id="ASSURANCES">
                      
                    </div>
                              <div class="row"><br>
                                  <div class="col-12 text-center" id="divdata" style="margin-top: 10px">
                                        <input type="submit" value="Enregistrer" class="btn btn-primary"/>
                                  </div>
                              </div>
                                    </form>
          </div> 
            </div>


            <div class="modal fade" id="modalsm">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Ajout d'un emploi</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form id="myformsassuree" method="POST" onsubmit="addmetier();return false" accept-charset="utf-8" enctype="multipart/form-data">
                      <div class="row">
                         <div class="form-group col-md-12">
                          <label for="NOMMETIER">
                             Emploi
                             <i class="text-danger"> *</i>
                          </label>
                          <input type="text" name="NOMMETIER" class="form-control" value="" id="NOMMETIER">
                          <?php echo form_error('NOMMETIER', '<div class="text-danger">', '</div>'); ?>
                      </div>
                  

                       
                    </div>                                    
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
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

     <script>

function addmetier(val){
var DESCRIPTION= $('#NOMMETIER').val();

$.post('<?php echo base_url('membre/Membre/addEmploi')?>',
          {
            DESCRIPTION:DESCRIPTION
          },
          function(data){
            // alert(data);
            $('#ID_EMPLOI').html(data); 
            $('#ID_EMPLOI').selectpicker('refresh');
          });
            $('#modalsm').modal('hide');

}

    </script>

    <script>
  function changegroupe(){
  if(document.getElementById('mgr1').checked) {
        $('#ID_GROUPE')
        .attr('disabled', true)
        }
  if(document.getElementById('mgr2').checked) {
        $('#ID_GROUPE')
        .attr('disabled', false)
          
        }

    }
</script>

<script>
  function countmembre(){
    var ID_GROUPE= $('#ID_GROUPE').val();
    if(document.getElementById('etud1').checked) {
      var ETUDIANT= 0;
        }
        else{
      var ETUDIANT= 1;   
        }
    $.post('<?php echo base_url('membre/Membre/countmembre')?>',
          {
            ID_GROUPE:ID_GROUPE,
            ETUDIANT:ETUDIANT
          },
          function(data){
            $('#ID_CATEGORIE_ASSURANCE').html(data);
          });
    }
</script>


<script type="text/javascript">
  function changeassurance() {
    var ID_REGIME_ASSURANCE= $('#ID_REGIME_ASSURANCE').val();
    // alert(ID_REGIME_ASSURANCE);
    if (ID_REGIME_ASSURANCE == 1) {
      $('#ASSURANCES').html('<div class="form-group col-md-3"><label for="MGROUPE">Membre d\'un groupe <i class="text-danger"> *</i></label><br><label class="radio-inline"><input type="radio" name="MGROUPE" id="mgr1" value="1" checked="checked" onchange="changegroupe()"> Non &nbsp;&nbsp;&nbsp;&nbsp;</label><label class="radio-inline"><input type="radio" name="MGROUPE" id="mgr2" onchange="changegroupe()" value="2"> Oui</label> <?php echo form_error('MGROUPE', '<div class="text-danger">', '</div>'); ?></div><div class="form-group col-md-3"> <label for="ID_GROUPE"> Groupe <i class="text-danger"> *</i> </label> <select class="form-control" name="ID_GROUPE" id="ID_GROUPE" disabled="true"> <option value="" >-- Sélectionner --</option> <?php foreach ($agroupe as $key => $groupe) { ?> <option value="<?=$groupe['ID_GROUPE']?>"><?=$groupe['NOM_GROUPE']?></option> <?php } ?> </select> <?php echo form_error('ID_GROUPE', '<div class="text-danger">', '</div>'); ?> </div><div class="form-group col-md-3"> <label for="ESTETUDIANT"> Est étudiants, célibataires ou assimilé? <i class="text-danger"> *</i> </label><br> <label class="radio-inline"><input type="radio" name="ESTETUDIANT" id="etud1" value="1" onchange="countmembre()"> Non &nbsp;&nbsp;&nbsp;&nbsp; </label> <label class="radio-inline"> <input type="radio" name="ESTETUDIANT" id="etud2" value="2" onchange="countmembre()"> Oui </label> <?php echo form_error('ESTETUDIANT', '<div class="text-danger">', '</div>'); ?> </div><div class="form-group col-md-3"> <label for="ID_CATEGORIE_ASSURANCE"> Assurance <i class="text-danger"> *</i> </label> <select class="form-control" name="ID_CATEGORIE_ASSURANCE" id="ID_CATEGORIE_ASSURANCE"> <option value="" >-- Sélectionner --</option> </select> <?php echo form_error('ID_CATEGORIE_ASSURANCE', '<div class="text-danger">', '</div>'); ?> </div>');


                         
                            
    }
    else{
      // alert('KK');
      $('#ASSURANCES').html('<div class="form-group col-md-3"> <label for="ID_CATEGORIE_ASSURANCE"> Assurance <i class="text-danger"> *</i> </label> <select class="form-control" name="ID_CATEGORIE_ASSURANCE" id="ID_CATEGORIE_ASSURANCE"> <option value="" >-- Sélectionner --</option> <?php foreach ($acategorie as $key => $categorie) {  ?> <option value="<?=$categorie['ID_CATEGORIE_ASSURANCE']?>"><?=$categorie['DESCRIPTION']?></option> <?php } ?> </select> <?php echo form_error('ID_CATEGORIE_ASSURANCE', '<div class="text-danger">', '</div>'); ?> </div>');
    }
    

  }
  
</script>

<script>
$('#DATE_NAISSANC').daterangepicker({
    "singleDatePicker": true,
    "showDropdowns": true,
    "startDate": "<?php echo $datemin;?>",
    // "endDate": "12/06/2020",
    // "minDate": "<?php echo $datemin;?>",
    "maxDate": "<?php echo $datemin;?>",
    "opens": "center",
    "drops": "auto"
}, function(start, end, label) {
  console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
});
</script>