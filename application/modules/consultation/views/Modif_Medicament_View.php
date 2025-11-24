<?php
  include VIEWPATH.'includes/new_header.php';
  include VIEWPATH.'includes/new_top_menu.php';
  include VIEWPATH.'includes/new_menu_principal.php';
  ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php
    include 'includes/Menu_Enregistrer_Consultation.php';
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
               <form id="FormData" action="<?php echo base_url()?>consultation/Enregistrer_Medicament/update" method="POST" enctype="multipart/form-data">
                      <div class="row">

              <input type="hidden" value="<?=$one['ID_CONSULTATION_MEDICAMENT_DETAILS']?>" name="ID_CONSULTATION_MEDICAMENT_DETAILS" id="ID_CONSULTATION_MEDICAMENT_DETAILS">
                        <!-- <div class="col-md-12">
                          <h4>Enregistrement d'une consultation</h4>
                        </div> -->
                     <!--     
                       <div class="form-group col-md-4">
                    <label for="">Pharmacie  <i class="text-danger"> *</i> <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modalsm">
                  (Ajout nouveau Pharmacie)
                </button>
                   
              </label>
                     <select  class="form-control select2" name="ID_PHARMACIE" id="ID_PHARMACIE">
                            <option value="">-- Sélectionner --</option>
                            <?php
                          foreach ($periode as $key => $value) { 
                            $select='';

                            if ($value['ID_PHARMACIE']==$one['ID_PHARMACIE']) {
                            $select='selected';
                            }
                              ?>
                              <option value="<?=$value['ID_PHARMACIE']?>" <?=$select?>><?=$value['DESCRIPTION']?></option>
                              <?php
                           } 
                           ?>
                          </select>

                          <?php echo form_error('ID_PHARMACIE', '<div class="text-danger">', '</div>'); ?>
                  </div>
 -->
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
             <!--        <div class="form-group col-md-4">
                    <label for="">Groupe <i class="text-danger"> *</i>
                   
              </label>
              
                    <select class="form-control select2" name="ID_GROUPE" id="ID_GROUPE" onchange="getaffilie_by_group(this)">
                            <option value="">-- Sélectionner --</option>
                            <?php
                          foreach ($groupe as $key => $value) { 
                             $select='';

                            if ($value['ID_GROUPE']==$one['ID_GROUPE']) {
                            $select='selected';
                            }
                              ?>
                              <option <?=$select?> value="<?=$value['ID_GROUPE']?>"><?=$value['NOM_GROUPE']?></option>
                              <?php
                           } 
                           ?>
                          </select>

                          <?php echo form_error('ID_GROUPE', '<div class="text-danger">', '</div>'); ?>
                  </div>
 -->
                 <!--  <div class="form-group col-md-4">
                    <label for="">Affili&eacute; <i class="text-danger"> *</i>
                   
              </label>
              
                    <select class="form-control select2" name="TYPE_AFFILIE" id="TYPE_AFFILIE" onchange="getaffilie(this)">
                            <option value="">-- Sélectionner --</option>
                             <?php
                          foreach ($affilie as $key => $value) { 
                              $select='';

                            if ($value['ID_MEMBRE']==$one['CODE_PARENT']) {
                            $select='selected';
                            }
                              ?>
                              <option <?=$select?> value="<?=$value['ID_MEMBRE']?>"><?=$value['NOM']?> <?=$value['PRENOM']?></option>
                              <?php
                           } 
                           ?>
                          </select> 

                          <?php echo form_error('TYPE_AFFILIE', '<div class="text-danger">', '</div>'); ?>
                  </div>
 -->
  <!--                 <div class="form-group col-md-4">
                    <label for="" id="AFFILIE"> Personne soigné <i class="text-danger"> *</i></label>
                     <select class="form-control select2" name="ID_MEMBRE" id="ID_MEMBRE">
                            <option value="">-- Sélectionner --</option>
                               <?php
                          foreach ($affilie2 as $key => $value) { 
                            $select='';

                            if ($value['ID_MEMBRE']==$one['ID_MEMBRE']) {
                            $select='selected';
                            }
                              ?>
                              <option <?=$select?> value="<?=$value['ID_MEMBRE']?>"><?=$value['NOM']?> <?=$value['PRENOM']?></option>
                              <?php
                           } 
                           ?>
                            
                          </select>

                          <?php echo form_error('ID_MEMBRE', '<div class="text-danger">', '</div>'); ?>
                  </div>
 -->
<!--                   <div class="form-group col-md-4">
                    <label for="DATE_CONSULTATION"> Date <i class="text-danger"> *</i></label>
                    <input type="date"  max=""  class="form-control" id="DATE_CONSULTATION" name="DATE_CONSULTATION" value="<?=$one['DATE_CONSULTATION'] ?>">

                          <?php echo form_error('DATE_CONSULTATION', '<div class="text-danger">', '</div>'); ?>
                  </div>
 -->
                  <div class="form-group col-md-12">
                    <label for="NUM_BORDERAUX"> Numero borderaux <i class="text-danger"> *</i></label>
                    <input type="text"  max=""  class="form-control" id="NUM_BORDERAUX" readonly="" name="NUM_BORDERAUX" value="<?=$one['NUM_BORDERAUX'] ?>">

                          <?php echo form_error('NUM_BORDERAUX', '<div class="text-danger">', '</div>'); ?>
                  </div>    
                 <!--  <div class="form-group col-md-12">
                    <label for="MEDECIN"> Medecin <i class="text-danger"> *</i></label>
                    <input type="text"  max=""  class="form-control" id="MEDECIN" name="MEDECIN" value="<?=$one['MEDECIN'] ?>">

                          <?php echo form_error('MEDECIN', '<div class="text-danger">', '</div>'); ?>
                  </div>   -->          
                  
                  <div class="col-md-12"><h4><lead>Medicaments servie</lead></h4></div>
                  <div class="form-group col-md-2">
                    <label for="ID_COUVERTURE_MEDICAMENT"> Categorie <i class="text-danger"> *</i></label>
                   
                    <select class="form-control" name="ID_COUVERTURE_MEDICAMENT" id="ID_COUVERTURE_MEDICAMENT" onchange="getpourcentage(this)">
                          <option value="" >-- Chosir--</option>
                          <?php
                          foreach ($type_med as $key => $value) {

                            $select='';

                            if ($value['ID_COUVERTURE_MEDICAMENT']==$one['ID_COUVERTURE_MEDICAMENT']) {
                            $select='selected';
                            }
                           ?>
                          <option <?=$select?> value="<?=$value['ID_COUVERTURE_MEDICAMENT']?>" ><?=$value['DESCRIPTION']?></option>
                          <?php
                           } ?>
                          </select>

                          <?php echo form_error('ID_COUVERTURE_MEDICAMENT', '<div class="text-danger">', '</div>'); ?>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="ID_MEDICAMENT"> Medicament <i class="text-danger"> *</i><button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modalmed">
                  (Ajout nouveau medicament)
                </button>
                  
                  </label>
                    <select class="form-control select2" name="ID_MEDICAMENT" id="ID_MEDICAMENT">
                          <option value="" >-- Choisir--</option>

                           <?php
                          foreach ($medicament as $key => $value) {
                         
                           $select='';

                            if ($value['ID_MEDICAMENT']==$one['ID_MEDICAMENT']) {
                            $select='selected';
                          }


                           ?>
                          <option <?=$select?> value="<?=$value['ID_MEDICAMENT']?>" ><?=$value['DESCRIPTION']?></option>
                          <?php
                           } ?>
                         
                          </select>


                          <?php echo form_error('ID_MEDICAMENT', '<div class="text-danger">', '</div>'); ?>
                  </div>
                  <div class="form-group col-md-2">
                    <label for="MONTANT_UNITAIRE_SANS_TAUX"> Prix unitaire brut <i class="text-danger"> *</i></label>
                    <input type="text"  max=""  class="form-control" id="MONTANT_UNITAIRE_SANS_TAUX" name="MONTANT_UNITAIRE_SANS_TAUX" value="<?=$one['MONTANT_UNITAIRE_SANS_TAUX'] ?>">

                          <?php echo form_error('MONTANT_UNITAIRE_SANS_TAUX', '<div class="text-danger">', '</div>'); ?>
                  </div>

                  <div class="form-group col-md-1">
                    <label for="QUANTITE"> Quantite <i class="text-danger"> *</i></label>
                    <input type="text"  max=""  class="form-control" id="QUANTITE" name="QUANTITE" value="<?=$one['QUANTITE'] ?>">

                          <?php echo form_error('QUANTITE', '<div class="text-danger">', '</div>'); ?>
                  </div>

                  <div class="form-group col-md-2">
                    <label for="POURCENTAGE"> % applique <i class="text-danger"> *</i></label>
                    <input type="text"  max=""  class="form-control" id="POURCENTAGE" name="POURCENTAGE" value="<?=$one['POURCENTAGE'] ?>">

                          <?php echo form_error('POURCENTAGE', '<div class="text-danger">', '</div>'); ?>
                  </div>

                 <!--  <div class="form-group col-md-1">  <br>                          
                            <button type="button" class="btn btn-primary btn-lg" onclick="add_ingredient()">
                              <i class="nav-icon fas fa-plus"></i>
                            </button>
                  </div> -->

                  
                  
                  
                  <div class="form-group col-md-12" id="RESULTATS"></div>
                
                  
                  

                  
                  
                  

                       
                      
                       

                     
                       
                    </div>
                    
                    
                              <div class="row"><br>
                                  <div class="col-12 text-center" id="divdata" style="margin-top: 10px">
                                        <input type="submit" value="Modifier" class="btn btn-primary"/>
                                  </div>
                              </div>
                                    </form>
          </div> 
            </div>


            


            <div class="modal fade" id="modalsm">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Ajout nouveau pharmacie</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form id="myformsassuree" method="POST" onsubmit="addstucture();return false" accept-charset="utf-8" enctype="multipart/form-data">
                      <div class="row">
                      
                         <div class="form-group col-md-12">
                          <label for="DESCRIPTION">
                             Pharmacie
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
                          <select class="form-control"  onchange="province(this)" name="PROVINCE_ID" id="PROVINCE_ID">
                          <option value="" >-- Sélectionner --</option>
                          <?php
                          foreach ($province as $key => $value) { ?>
                          <option value="<?=$value['PROVINCE_ID']?>" ><?=$value['PROVINCE_NAME']?></option>
                          <?php
                           } ?>
                          </select>
                          <?php echo form_error('PROVINCE_ID', '<div class="text-danger">', '</div>'); ?>
                      </div>

                      <div class="form-group col-md-6">
                          <label for="COMMUNE_ID">
                             Commune
                             <i class="text-danger"> *</i>
                          </label>
                          <select class="form-control"  aria-describedby="emailHelp" name="COMMUNE_ID" id="COMMUNE_ID">
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
    

      <div class="modal fade" id="modalmed">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Ajout nouveau medicament</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form id="myformsassuree" method="POST" onsubmit="addmedicament();return false" accept-charset="utf-8" enctype="multipart/form-data">
                      <div class="row">
                      
                         <div class="form-group col-md-12">
                          <label for="DESCRIPTIONS">
                             Medicament
                             <i class="text-danger"> *</i>
                          </label>
                          <input type="text" name="DESCRIPTIONS" class="form-control" value="" id="DESCRIPTIONS">
                          <?php echo form_error('DESCRIPTIONS', '<div class="text-danger">', '</div>'); ?>
                      </div>


                      <div class="form-group col-md-12">
                          <label for="ID_COUVERTURE_MEDICAMENTS">
                             Couverture
                             <i class="text-danger"> *</i>
                          </label>
                          <select class="form-control"  name="ID_COUVERTURE_MEDICAMENTS" id="ID_COUVERTURE_MEDICAMENTS">
                          <option value="" >-- Sélectionner --</option>
                          
                           <?php
                          foreach ($type_med as $key => $value) { ?>
                          <option value="<?=$value['ID_COUVERTURE_MEDICAMENT']?>" ><?=$value['DESCRIPTION']?></option>
                          <?php
                           } ?>
                          </select>
                          <?php echo form_error('ID_COUVERTURE_MEDICAMENTS', '<div class="text-danger">', '</div>'); ?>
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

    
<!-- <script>

     function getstructure(va){
      var ID_PHARMACIE= $(va).val();
      $.post('<?php echo base_url('consultation/Enregistrer_Medicament/getstructure')?>',
          {ID_PHARMACIE:ID_PHARMACIE},
          function(data){
            $('#ID_PHARMACIE').html(data);
          });
     }
     </script> -->

<script>

     function getaffilie(va){
      var TYPE_AFFILIE= $(va).val();
      $.post('<?php echo base_url('consultation/Enregistrer_Medicament/getaffilie')?>',
          {TYPE_AFFILIE:TYPE_AFFILIE},
          function(data){
            // alert(data);
            $('#ID_MEMBRE').html(data);
          });
     }
     </script>

<script>

     function getpourcentage(){
      var ID_CONSULTATION_MEDICAMENT_DETAILS= $('#ID_CONSULTATION_MEDICAMENT_DETAILS').val();
      var ID_COUVERTURE_MEDICAMENT= $('#ID_COUVERTURE_MEDICAMENT').val();
      
      $.post('<?php echo base_url('consultation/Enregistrer_Medicament/getpourcentage2')?>',
          {
            ID_CONSULTATION_MEDICAMENT_DETAILS:ID_CONSULTATION_MEDICAMENT_DETAILS,
            ID_COUVERTURE_MEDICAMENT:ID_COUVERTURE_MEDICAMENT
          },
          function(data){
            // alert(data);
            $('#POURCENTAGE').val(data);
          });
          // alert(ID_COUVERTURE_MEDICAMENT);
          $.post('<?php echo base_url('consultation/Enregistrer_Medicament/getmedoc')?>',
          {
            ID_COUVERTURE_MEDICAMENT:ID_COUVERTURE_MEDICAMENT
          },
          function(data){
            // alert(data);
            $('#ID_MEDICAMENT').html(data);
          });
     }
     </script>


<script>
  function add_ingredient(){
        var ID_COUVERTURE_MEDICAMENT=$('#ID_COUVERTURE_MEDICAMENT').val();
        var ID_MEDICAMENT=$('#ID_MEDICAMENT').val();
        var MONTANT_UNITAIRE_SANS_TAUX=$('#MONTANT_UNITAIRE_SANS_TAUX').val();
        var QUANTITE=$('#QUANTITE').val();
        var POURCENTAGE=$('#POURCENTAGE').val();
        var ID_MEMBRE=$('#ID_MEMBRE').val();
        var NUM_BORDERAUX=$('#NUM_BORDERAUX').val();

        // alert(NUM_BORDERAUX);
        
        
        $.post('<?php echo base_url();?>consultation/Enregistrer_Medicament/add_tocart',
                {
                  ID_COUVERTURE_MEDICAMENT:ID_COUVERTURE_MEDICAMENT,
                  ID_MEDICAMENT:ID_MEDICAMENT,
                  MONTANT_UNITAIRE_SANS_TAUX:MONTANT_UNITAIRE_SANS_TAUX,
                  QUANTITE:QUANTITE,
                  POURCENTAGE:POURCENTAGE,
                  ID_MEMBRE:ID_MEMBRE,
                  NUM_BORDERAUX:NUM_BORDERAUX
                },
                function(data) 
                { 
                    RESULTATS.innerHTML = data;  
                    $('#RESULTATS').html(data);
                }
            ); 
}
</script>

<script>
  
  function remove_cart(id){
    // alert(id);
        // var ID_CONSULTATION_MEDICAMENT_DETAILS= $(id).val();
        // alert(ID_CONSULTATION_MEDICAMENT_DETAILS);
        $.post('<?php echo base_url();?>consultation/Enregistrer_Medicament/remove_cart',
                {
                  ID_CONSULTATION_MEDICAMENT_DETAILS:id
                },
                function(data) 
                { 
                    RESULTATS.innerHTML = data;  
                    $('#RESULTATS').html(data);
                }
            ); 
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
var DESCRIPTION= $('#DESCRIPTION').val();
var PROVINCE_ID= $('#PROVINCE_ID').val();
var COMMUNE_ID= $('#COMMUNE_ID').val();
   
$.post('<?php echo base_url('consultation/Enregistrer_Medicament/addStructure')?>',
          {
            DESCRIPTION:DESCRIPTION,
            COMMUNE_ID:COMMUNE_ID,
            PROVINCE_ID:PROVINCE_ID
          },
          function(data){
            // alert(data);
            $('#ID_PHARMACIE').html(data); 
            $('#ID_PHARMACIE').selectpicker('refresh');
          });
            $('#modalsm').modal('hide');

}

    </script>


<script>

function addmedicament(val){
var DESCRIPTIONS= $('#DESCRIPTIONS').val();
var ID_COUVERTURE_MEDICAMENTS= $('#ID_COUVERTURE_MEDICAMENTS').val();
   
$.post('<?php echo base_url('consultation/Enregistrer_Medicament/addMedicament')?>',
          {
            DESCRIPTIONS:DESCRIPTIONS,
            ID_COUVERTURE_MEDICAMENTS:ID_COUVERTURE_MEDICAMENTS
          },
          function(data){
            alert(data);
            $('#ID_MEDICAMENT').html(data); 
            $('#ID_MEDICAMENT').selectpicker('refresh');
          });
            $('#modalmed').modal('hide');

}

    </script>

<script>

function province(va){
 var provine_id= $(va).val();
 $.post('<?php echo base_url('saisie/Pharmacie/get_commune')?>',
     {provine_id:provine_id},
     function(data){
       $('#COMMUNE_ID').html(data);
     });
}
</script>

<script>

     function getaffilie_by_group(va){
      var ID_GROUPE= $('#ID_GROUPE').val();
      $.post('<?php echo base_url('consultation/Enregistrer_Medicament/getaffilie_by_group')?>',
          {ID_GROUPE:ID_GROUPE},
          function(data){
            // alert(data);
            $('#TYPE_AFFILIE').html(data);
          });
     }
     </script>