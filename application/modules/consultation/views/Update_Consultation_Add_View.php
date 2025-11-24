  <?php
  include VIEWPATH.'includes/new_header.php';
  include VIEWPATH.'includes/new_top_menu.php';
  include VIEWPATH.'includes/new_menu_principal.php';
  ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php
    include 'includes/Menu_Liste_Consultation.php';
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
               <form id="FormData" action="<?php echo base_url()?>consultation/Liste_Consultation/update" method="POST" enctype="multipart/form-data">
                      <div class="row">
                        <!-- <div class="col-md-12">
                          <h4>Enregistrement d'une consultation</h4>
                        </div> -->
                        <div class="form-group col-md-12">
                          <label for="ID_CONSULTATION_TYPE">
                             Type de consultation
                             <i class="text-danger"> *</i> 
                             
                          </label>
                          
                          <input type="hidden"  max=""  class="form-control" id="ID_CONSULTATION" name="ID_CONSULTATION" value="<?php echo $selected['ID_CONSULTATION'];?>">
                          <select class="form-control" name="ID_CONSULTATION_TYPE" id="ID_CONSULTATION_TYPE" onchange="typeconsul(this)">
                            <option value="">-- Sélectionner --</option>
                            <?php
                          foreach ($tconsultation as $key => $value) { 
                            if ($value['ID_CONSULTATION_TYPE']== $selected['ID_CONSULTATION_TYPE']) {
                              ?>
                              <option value="<?=$value['ID_CONSULTATION_TYPE']?>" selected><?=$value['DESCRIPTION']?></option>
                              
                              <?php }
                            else{
                              ?>
                              <option value="<?=$value['ID_CONSULTATION_TYPE']?>"><?=$value['DESCRIPTION']?></option>

                            <?php }
                              ?>
                              
                              
                              <?php
                           } 
                           ?>
                          </select>
                          <?php echo form_error('ID_CONSULTATION_TYPE', '<div class="text-danger">', '</div>'); ?>
                       </div>

                  <div class="form-group col-md-12">
                    <label for="">Centre optique <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modalcoar">
                  (Ajout nouveau centre optique)
                </button>
                  </label>
                     <select class="form-control select2" name="ID_CENTRE_OPTIQUE" id="ID_CENTRE_OPTIQUE">
                            <option value="">-- Sélectionner --</option>
                            <?php
                            if ($selected['ID_CONSULTATION_TYPE'] == 3) {

                              foreach ($coptique as $value) { 
                                if ($selected['ID_STRUCTURE'] == $value['ID_CENTRE_OPTIQUE']) {
                                 ?>
                                 <option value="<?=$value['ID_CENTRE_OPTIQUE']?>" selected><?=$value['DESCRIPTION']?></option>
                                 <?php
                                }
                                else{
                                  ?>
                                  <option value="<?=$value['ID_CENTRE_OPTIQUE']?>"><?=$value['DESCRIPTION']?></option>
                                  <?php
                                }
                                ?>
                                
                                <?php
                             }  
                             
                            }
                            else{
                              ?>
                              <option value="<?=$value['ID_CENTRE_OPTIQUE']?>"><?=$value['DESCRIPTION']?></option>
                              <?php
                            }                          
                           ?>
                            
                          </select>

                          <?php echo form_error('ID_CENTRE_OPTIQUE', '<div class="text-danger">', '</div>'); ?>
                  </div>

                  <div class="form-group col-md-6">
                          <label for="ID_TYPE_STRUCTURE">
                             Categorie Structure
                             
                             
                          </label>
                          <select class="form-control" name="ID_TYPE_STRUCTURE" id="ID_TYPE_STRUCTURE" onchange="getstructure(this)">
                            <option value="">-- Sélectionner --</option>
                            <?php
                          foreach ($periode as $key => $value) { 
                            if ($value['ID_TYPE_STRUCTURE'] == $selected['ID_TYPE_STRUCTURE'] ) {
                              ?>
                              <option value="<?=$value['ID_TYPE_STRUCTURE']?>" selected><?=$value['DESCRIPTION']?></option>
                              <?php
                            }
                            else{
                              ?>
                              <option value="<?=$value['ID_TYPE_STRUCTURE']?>"><?=$value['DESCRIPTION']?></option>
                              <?php
                            }
                              ?>
                              
                              <?php
                           } 
                           ?>
                          </select>
                          <?php echo form_error('ID_TYPE_STRUCTURE', '<div class="text-danger">', '</div>'); ?>
                       </div>
                       <div class="form-group col-md-6">
                    <label for="">Structure sanitaire  <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modalsm">
                  (Ajout nouveau Structure sanitaire)
                </button>
                   
              </label>
                     <select class="form-control select2" name="ID_STRUCTURE" id="ID_STRUCTURE">
                            <option value="">-- Sélectionner --</option>
                            <?php
                            if ($selected['ID_CONSULTATION_TYPE'] != 3) {
                              // print_r($struct);
                              
                              foreach ($struct as $key => $value) { 
                                if ($value['ID_STRUCTURE'] == $selected['ID_STRUCTURE']) {
                                  ?>
                                  <option value="<?=$value['ID_STRUCTURE']?>" selected><?=$value['DESCRIPTION']?></option>
                                  <?php
                                }
                                else{
                                  ?>
                                  <option value="<?=$value['ID_STRUCTURE']?>"><?=$value['DESCRIPTION']?></option>
                                  <?php
                                }
                             } 
                              ?>
                              
                              <?php
                            }
                            
                            ?>
                            
                          </select>

                          <?php echo form_error('ID_STRUCTURE', '<div class="text-danger">', '</div>'); ?>
                  </div>

                  <div class="form-group col-md-6">
                    <label for="">Affili&eacute; <i class="text-danger"> *</i>
                   
              </label>
              
                    <select class="form-control select2" name="TYPE_AFFILIE" id="TYPE_AFFILIE" onchange="getaffilie(this)">
                            <option value="">-- Sélectionner --</option>
                            <?php
                          foreach ($affilie as $key => $value) { 
                            if ($value['ID_MEMBRE'] == $selected['TYPE_AFFILIE']) {
                              ?>
                              <option value="<?=$value['ID_MEMBRE']?>" selected><?=$value['NOM']?> <?=$value['PRENOM']?></option>
                              <?php
                            }
                            else{
                              ?>
                              <option value="<?=$value['ID_MEMBRE']?>"><?=$value['NOM']?> <?=$value['PRENOM']?></option>
                              <?php
                            }
                              ?>
                              
                              <?php
                           } 
                           ?>
                          </select>

                          <?php echo form_error('TYPE_AFFILIE', '<div class="text-danger">', '</div>'); ?>
                  </div>

                  <!-- <div class="form-group col-md-6">
                    <label for="">Affilie ou ayant droit <i class="text-danger"> *</i>
                   
              </label>
                    <select class="form-control" name="TYPE_AFFILIE" id="TYPE_AFFILIE" onchange="getaffilie(this)">
                            <option value="">-- Sélectionner --</option>
                            <option value="0">Affilie</option>
                            <option value="1">Ayant droit</option>
                          </select>

                          <?php echo form_error('TYPE_AFFILIE', '<div class="text-danger">', '</div>'); ?>
                  </div> -->

                  <div class="form-group col-md-6">
                    <label for="" id="AFFILIE"> Personne soigné <i class="text-danger"> *</i></label>
                     <select class="form-control select2" name="ID_MEMBRE" id="ID_MEMBRE" onchange="getpourcentage(this)">
                            <option value="">-- Sélectionner --</option>
                            <?php echo $affilies; ?>
                            
                          </select>

                          <?php echo form_error('ID_MEMBRE', '<div class="text-danger">', '</div>'); ?>
                  </div>

                  <div class="form-group col-md-3">
                    <label for="DATE_CONSULTATION"> Date consultation <i class="text-danger"> *</i></label>
                    <input type="date"  max=""  class="form-control" id="DATE_CONSULTATION" name="DATE_CONSULTATION" value="<?php echo $selected['DATE_CONSULTATION']; ?>">

                          <?php echo form_error('DATE_CONSULTATION', '<div class="text-danger">', '</div>'); ?>
                  </div>

                  <div class="form-group col-md-3">
                    <label for="NUM_BORDERAUX"> Numero borderaux <i class="text-danger"> *</i></label>
                    <input type="text"  max=""  class="form-control" id="NUM_BORDERAUX" name="NUM_BORDERAUX" value="<?php echo $selected['NUM_BORDERAUX']; ?>">

                          <?php echo form_error('NUM_BORDERAUX', '<div class="text-danger">', '</div>'); ?>
                  </div>

                  <div class="form-group col-md-3">
                    <label for="MONTANT_CONSULTATION"> Montant Consultation <i class="text-danger"> *</i></label>
                    <input type="number"  max=""  class="form-control" id="MONTANT_CONSULTATION" name="MONTANT_CONSULTATION" value="<?php echo $selected['MONTANT_CONSULTATION']; ?>">

                          <?php echo form_error('MONTANT_CONSULTATION', '<div class="text-danger">', '</div>'); ?>
                  </div>

                  

                  <div class="form-group col-md-3">
                    <label for="POURCENTAGE_C"> Pourcentage categorie <i class="text-danger"> *</i></label>
                    <input type="text"  max=""  class="form-control" id="POURCENTAGE_C" name="POURCENTAGE_C" value="<?php echo $selected['POURCENTAGE_C']; ?>" readonly="readonly">

                          <?php echo form_error('POURCENTAGE_C', '<div class="text-danger">', '</div>'); ?>
                  </div>

                  <div class="form-group col-md-3">
                    <label for="POURCENTAGE_A"> Pourcentage applique <i class="text-danger"> *</i></label>
                    <input type="text"  max=""  class="form-control" id="POURCENTAGE_A" name="POURCENTAGE_A" value="<?php echo $selected['POURCENTAGE_A']; ?>" onchange="calmontant()">

                          <?php echo form_error('POURCENTAGE_A', '<div class="text-danger">', '</div>'); ?>
                  </div>

                  <div class="form-group col-md-3">
                    <label for="MONTANT_A_PAYER"> Montant a pay&eacute; <i class="text-danger"> *</i></label>
                    <input type="text"  max=""  class="form-control" id="MONTANT_A_PAYER" name="MONTANT_A_PAYER" value="<?php echo $selected['MONTANT_A_PAYER']; ?>" readonly="readonly">

                          <?php echo form_error('MONTANT_A_PAYER', '<div class="text-danger">', '</div>'); ?>
                  </div>

                  <div class="form-group col-md-6">
                    <label for="MEDECIN"> Medecin <i class="text-danger"> *</i></label>
                    <input type="text"  max=""  class="form-control" id="MEDECIN" name="MEDECIN" value="<?php echo $selected['MEDECIN']; ?>">

                          <?php echo form_error('MEDECIN', '<div class="text-danger">', '</div>'); ?>
                  </div>

                  <div class="form-group col-md-12">
                    <label for="EXAMEN"> Examen </label>
                    <textarea class="form-control" id="EXAMEN" name="EXAMEN" rows="3"><?php echo $selected['EXAMEN']; ?></textarea>

                          <?php echo form_error('EXAMEN', '<div class="text-danger">', '</div>'); ?>
                  </div>

                       
                      
                       

                     
                       
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
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Ajout nouveau structure sanitaire</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form id="myformsassuree" method="POST" onsubmit="addstucture();return false" accept-charset="utf-8" enctype="multipart/form-data">
                      <div class="row">
                      <div class="form-group col-md-12">
                          <label for="ID_TYPE_STRUCTURE_NEW">
                             Categorie
                             <i class="text-danger"> *</i>
                          </label>
                          
                          <input type="hidden" name="ID_TYPE_STRUCTURE_ID" class="form-control" value="" id="ID_TYPE_STRUCTURE_ID" readonly="readonly">
                          
                          <input type="text" name="ID_TYPE_STRUCTURE_NEW" class="form-control" value="" id="ID_TYPE_STRUCTURE_NEW" readonly="readonly">
                          
                          <?php echo form_error('ID_TYPE_STRUCTURE_NEW', '<div class="text-danger">', '</div>'); ?>
                      </div>
                         <div class="form-group col-md-12">
                          <label for="NOMSTRUCTURE">
                             Structure Sanitaire
                             <i class="text-danger"> *</i>
                          </label>
                          <input type="text" name="NOMSTRUCTURE" class="form-control" value="" id="NOMSTRUCTURE">
                          <?php echo form_error('NOMSTRUCTURE', '<div class="text-danger">', '</div>'); ?>
                      </div>
                      <div class="form-group col-md-6">
                          <label for="PROVINCE_ID">
                             Province
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
                      <div class="form-group col-md-6">
                          <label for="COMMUNE_ID">
                             Commune
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


      <div class="modal fade" id="modalcoar">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Ajout nouveau Centre Optique</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form id="myformsassuree" method="POST" onsubmit="addcentreoptique();return false" accept-charset="utf-8" enctype="multipart/form-data">
                      <div class="row">
                      
                         <div class="form-group col-md-12">
                          <label for="DESCRIPTION">
                             Centre optique
                             <i class="text-danger"> *</i>
                          </label>
                          <input type="text" name="DESCRIPTION" class="form-control" value="" id="DESCRIPTION">
                          <?php echo form_error('DESCRIPTION', '<div class="text-danger">', '</div>'); ?>
                      </div>
                      <div class="form-group col-md-6">
                          <label for="PROVINCE_ID">
                             Province
                             <i class="text-danger"> *</i>
                          </label>
                          <select class="form-control"  onchange="provinces(this)" name="PROVINCE_IDCO" id="PROVINCE_IDCO">
                          <option value="">-- Sélectionner --</option>
                          <?php
                          foreach ($province as $key => $value) { 
                              ?>
                              <option value="<?=$value['PROVINCE_ID']?>"><?=$value['PROVINCE_NAME']?></option>
                              <?php
                           } 
                           ?>
                          </select>
                          <?php echo form_error('PROVINCE_IDCO', '<div class="text-danger">', '</div>'); ?>
                      </div>
                      <div class="form-group col-md-6">
                          <label for="COMMUNE_ID">
                             Commune
                             <i class="text-danger"> *</i>
                          </label>
                          <select class="form-control"  aria-describedby="emailHelp" name="COMMUNE_IDCO" id="COMMUNE_IDCO">
                            <option value="">-- Sélectionner --</option>
                            <?php
                          foreach ($commune as $key => $value) { 
                              ?>
                              <option value="<?=$value['COMMUNE_ID']?>"><?=$value['COMMUNE_NAME']?></option>
                              <?php
                           } 
                           ?>
                          </select>
                          <?php echo form_error('COMMUNE_IDCO', '<div class="text-danger">', '</div>'); ?>
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

     function typeconsul(va){
      var ID_CONSULTATION_TYPE= $(va).val();
      // $('#ID_CONSULTATION_TYPE').val(ID_TYPE_STRUCTURE);

      // alert(ID_CONSULTATION_TYPE);

     }
     </script>

    
<script>

     function getstructure(va){
      var ID_TYPE_STRUCTURE= $(va).val();
      $('#ID_TYPE_STRUCTURE_ID').val(ID_TYPE_STRUCTURE);



      var selectElement = document.getElementById("ID_TYPE_STRUCTURE");
      var selectedOption = selectElement.options[selectElement.selectedIndex];
      var selectedText = selectedOption.textContent;
      $('#ID_TYPE_STRUCTURE_NEW').val(selectedText);


      $.post('<?php echo base_url('consultation/Enregistrer_Consultation/getstructure')?>',
          {ID_TYPE_STRUCTURE:ID_TYPE_STRUCTURE},
          function(data){
            $('#ID_STRUCTURE').html(data);
          });
     }
     </script>

<script>

     function getaffilie(va){
      var TYPE_AFFILIE= $(va).val();
      $.post('<?php echo base_url('consultation/Enregistrer_Consultation/getaffilie')?>',
          {TYPE_AFFILIE:TYPE_AFFILIE},
          function(data){
            // alert(data);
            $('#ID_MEMBRE').html(data);
          });
     }
     </script>

<script>

     function getpourcentage(va){
      var ID_MEMBRE= $(va).val();
      var ID_TYPE_STRUCTURE= $('#ID_TYPE_STRUCTURE').val();
      $.post('<?php echo base_url('consultation/Enregistrer_Consultation/getpourcentage')?>',
          {
            ID_MEMBRE:ID_MEMBRE,
            ID_TYPE_STRUCTURE:ID_TYPE_STRUCTURE
          },
          function(data){
            // alert(data);
            $('#POURCENTAGE_C').val(data);
          });
     }
     </script>


<script>

     function calmontant(va){
      // var POURCENTAGE_A= $(va).val();
      var POURCENTAGE_A= $('#POURCENTAGE_A').val();
      var MONTANT_CONSULTATION= $('#MONTANT_CONSULTATION').val();
      var MONTANT_A_PAYERC = MONTANT_CONSULTATION - ((MONTANT_CONSULTATION * POURCENTAGE_A)/100);
      var MONTANT_A_PAYER = MONTANT_CONSULTATION - MONTANT_A_PAYERC;
      $('#MONTANT_A_PAYER').val(MONTANT_A_PAYER);
      // $.post('<?php echo base_url('consultation/Enregistrer_Consultation/getpourcentage')?>',
      //     {
      //       ID_MEMBRE:ID_MEMBRE,
      //       ID_TYPE_STRUCTURE:ID_TYPE_STRUCTURE
      //     },
      //     function(data){
      //       // alert(data);
      //       $('#POURCENTAGE_C').val(data);
      //     });
     }
     </script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
  })
</script>

<script>

function addstucture(val){
var ID_TYPE_STRUCTURE_NEW= $('#ID_TYPE_STRUCTURE_ID').val();
var NOMSTRUCTURE= $('#NOMSTRUCTURE').val();
var PROVINCE_ID= $('#PROVINCE_ID').val();
var COMMUNE_ID= $('#COMMUNE_ID').val();
   
$.post('<?php echo base_url('consultation/Enregistrer_Consultation/addStructure')?>',
          {
            ID_TYPE_STRUCTURE_NEW:ID_TYPE_STRUCTURE_NEW,
            NOMSTRUCTURE:NOMSTRUCTURE,
            PROVINCE_ID:PROVINCE_ID,
            COMMUNE_ID:COMMUNE_ID
          },
          function(data){
            // alert(data);
            $('#ID_STRUCTURE').html(data); 
            $('#ID_STRUCTURE').selectpicker('refresh');
          });
            $('#modalsm').modal('hide');

}

    </script>


<script>

function addcentreoptique(val){
var DESCRIPTION= $('#DESCRIPTION').val();
var PROVINCE_IDCO= $('#PROVINCE_IDCO').val();
var COMMUNE_IDCO= $('#COMMUNE_IDCO').val();
   
$.post('<?php echo base_url('consultation/Enregistrer_Consultation/addCentreOp')?>',
          {
            DESCRIPTION:DESCRIPTION,
            PROVINCE_IDCO:PROVINCE_IDCO,
            COMMUNE_IDCO:COMMUNE_IDCO
          },
          function(data){
            // alert(data);
            $('#ID_CENTRE_OPTIQUE').html(data); 
            $('#ID_CENTRE_OPTIQUE').selectpicker('refresh');
          });
            $('#modalcoar').modal('hide');

}

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

function provinces(va){
 var provine_id= $(va).val();
 $.post('<?php echo base_url('membre/Membre/get_commune')?>',
     {provine_id:provine_id},
     function(data){
       $('#COMMUNE_IDCO').html(data);
     });
}
</script>

