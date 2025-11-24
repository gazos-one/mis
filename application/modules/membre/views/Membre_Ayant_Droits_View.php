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
                <h3 class="card-title">Ajouter ou enlever les ayants droits d'affili&eacute;</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->

         <div class="card-body">
               <?php
                $nimag = 'default.jpg';
               if (!empty($selected)) {
                 # code...
               
               if ($selected['URL_PHOTO'] == null) {
                 $nimag = 'default.jpg';
               }
               else{
                 $nimag = $selected['URL_PHOTO'];
               }

               }
               ?>
          
                      <div class="row">
                        <div class="form-group col-md-6">
                      <?php   if (!empty($selected)) { ?>
                          <table class="table">
                            <tr>
                              <td rowspan="4">
                                <img src="<?php echo base_url()?>/uploads/image_membre/<?php echo $nimag?>" style="max-height: 150px;" >
                              </td>
                            </tr>
                            <tr>
                              <td><b>Nom & Pr&eacute;nom</b></td>
                              <td colspan="2"><?php echo $selected['NOM'].' '.$selected['PRENOM']?></td>
                              
                            </tr>
                            <tr>
                              <td><b>CNI/PASSPORT</b></td>
                              <td colspan="2"><?php echo $selected['CNI']?></td>
                              
                            </tr>
                            <tr>
                              <td><b>Sexe</b></td>
                              <td colspan="2"><?php 
                              $DSEX = $this->Model->getOne('syst_sexe',array('ID_SEXE'=>$selected['ID_SEXE']));

                              echo $DSEX['DESCRIPTION']?></td>
                              
                            </tr>
                            <tr>
                              <td><b>Date de naissance</b></td>
                              <td><?php 
                              $newNAIs = date("d-m-Y", strtotime($selected['DATE_NAISSANCE']));
                              echo $newNAIs?></td>
                              <td><b>Groupe Sanguin</b></td>
                              <td><?php 
                              $GSANGUIN = $this->Model->getOne('syst_groupe_sanguin',array('ID_GROUPE_SANGUIN'=>$selected['ID_GROUPE_SANGUIN']));
                              echo $GSANGUIN['DESCRIPTION']?></td>
                            </tr>
                            <tr>
                              <td><b>Naissance</b></td>
                              <td><?php
                              $PRO = $this->Model->getOne('syst_provinces',array('PROVINCE_ID'=>$selected['PROVINCE_ID']));
                              $CO = $this->Model->getOne('syst_communes',array('COMMUNE_ID'=>$selected['COMMUNE_ID']));
                              echo $PRO['PROVINCE_NAME'].' - '.$CO['COMMUNE_NAME']?></td>
                              
                              <td><b>T&eacute;l&eacute;phone</b></td>
                              <td><?php echo $selected['TELEPHONE']?></td>
                              </tr>
                            <tr>
                              <td><b>Emploi</b></td>
                              <td><?php
                              $EMP = $this->Model->getOne('masque_emploi',array('ID_EMPLOI'=>$selected['ID_EMPLOI']));
                              echo $EMP['DESCRIPTION']?></td>
                              <td><b>Adresse</b></td>
                              <td><?php echo $selected['ADRESSE']?></td>
                              </tr>
                            <tr>
                              <td><b>Date d'adhesion</b></td>
                              <td><?php  
                              $newAdh = date("d-m-Y", strtotime($selected['DATE_ADHESION']));
                              echo $newAdh;
                              ?></td><td><b>Code d'afiliation</b></td>
                              <td><?php echo $selected['CODE_AFILIATION']?></td>
                            </tr>
                            <tr>
                              <td><b>Agence</b></td>
                              <td colspan="3"><?php 
                              $AGEN = $this->Model->getOne('masque_agence_msi',array('ID_AGENCE'=>$selected['ID_AGENCE']));
                              echo $AGEN['DESCRIPTION']?></td>
                            </tr>
                          
                          </table>
                        <?php } ?>
                      </div>
                      <div class="form-group col-md-6">
                          
                        <!-- <form id="FormData" action="#" method="POST"> -->
               <!-- <form id="FormData" action="<?php echo base_url()?>membre/Membre/update" method="POST"> -->
                
             <table class="table table-responsive" id="affiliee">
                  <thead>
                  <tr>
                    <td class="text-center" colspan="4"><b>Ayant droit d&eacute;j&agrave; enregistr&eacute;</b></td>
                  </tr>
                  <tr>
                    <th><b>Nom & Prenom</b></th>
                    <th><b>Naissance</b></th>
                    <th><b>GS</b></th>
                    <th><b>Action</b></th>
                  </tr>
                  </thead>
                     <tbody>
                  <?php
                    
                  // $groupmembre = $this->Model->getList('groupmembre');
                  foreach ($groupmembre as $keys) {
                    $groups = $this->Model->getOne('syst_groupe_sanguin',array('ID_GROUPE_SANGUIN'=>$keys['ID_GROUPE_SANGUIN']));
                    $details = $this->Model->getOne('membre_membre',array('ID_MEMBRE'=>$keys['ID_MEMBRE']));
                    if ($details['URL_PHOTO'] == null) {
                    $nimagd = 'default.jpg';
                      }
                    else{
                     $nimagd = $details['URL_PHOTO'];
                     }

                     if ($keys['STATUS']==1) {
                      $buttontext = 'Désactiver';
                      $buttoncolor = 'btn-danger';
                      $fonctions = 'desactiver_ayant_droit';
                      $textheader = 'Désactiver l\'ayant droit';
                      $textnormal = 'Monsieur/Madame;<br>Voulez-vous désactiver l\' ayant droit ';
                     }
                     else{
                      $buttontext = 'Réactiver';
                      $buttoncolor = 'btn-success';
                      $fonctions = 'reactiver_ayant_droit';
                      $textheader = 'Réactiver l\'ayant droit';
                      $textnormal = 'Monsieur/Madame;<br>Voulez-vous réactiver l\' ayant droit ';
                     }
                     $newAdh1 = date("d-m-Y", strtotime($keys['DATE_NAISSANCE']));
                     $ajout_affilie='</tr>';
                     $a='<td colspan="3">';
                    if (!empty($keys['NOM_DOCUMENT'])) { 
                     $a='<td>';
                       $ajout_affilie='<td><b>Nom du document</b></td>
                              <td>'.$keys['NOM_DOCUMENT'].'</td></tr><tr>
                              <td><b>Document scolaire</b></td>
                              <td><a href="'.base_url('uploads/image_membre/'.$details['ATT_DOCUMENT'].'').'"><i class=" nav-icon fas fa-file"></i></a></td>
                              <td><b>Date du document</b></td>
                              <td>'.$keys['DATE_DOCUMENT'].'</td>
                            </tr>';     
                            
                          } 
                    echo "<tr>
                    <td>".$keys['NOM']." ".$keys['PRENOM']."</td>
                    <td>".$newAdh1."</td>
                    <td>".$groups['DESCRIPTION']."</td>
                    <td>";
        echo '<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#details'.$keys['ID_MEMBRE'].'"><i class="far fa-eye"></i></button>
                        <div class="modal fade" id="details'.$keys['ID_MEMBRE'].'">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Details d\'un ayant droits</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                          <table class="table">
                            <tr>
                              <td rowspan="4">
                                <img src="'.base_url().'/uploads/image_membre/'.$nimagd.'" style="max-height: 150px;" >
                              </td>
                            </tr>
                            <tr>
                              <td><b>Nom & Pr&eacute;nom</b></td>
                              <td colspan="2">'.$details['NOM'].' '.$details['PRENOM'].'</td>
                              
                            </tr>
                            <tr>
                              <td><b>CNI/PASSPORT</b></td>
                              <td colspan="2">'.$details['CNI'].'</td>
                              
                            </tr>
                            <tr>
                              <td><b>Sexe</b></td>
                              <td colspan="2">';
                              $DSEX = $this->Model->getOne('syst_sexe',array('ID_SEXE'=>$details['ID_SEXE']));

                              $newAdh2 = date("d-m-Y", strtotime($details['DATE_NAISSANCE']));
                              // echo $newAdh2;

                              echo $DSEX['DESCRIPTION'].'</td>
                            </tr>
                            <tr>
                              <td><b>CNI/PASSPORT</b></td>
                              <td>'.$newAdh2.'</td>
                              <td><b>Groupe Sanguin</b></td>
                              <td>'; 
                              $GSANGUIN = $this->Model->getOne('syst_groupe_sanguin',array('ID_GROUPE_SANGUIN'=>$details['ID_GROUPE_SANGUIN']));
                              echo $GSANGUIN['DESCRIPTION'].'</td>
                            </tr>
                            <tr>
                              <td><b>Naissance</b></td>
                              <td>';
                              $PRO = $this->Model->getOne('syst_provinces',array('PROVINCE_ID'=>$details['PROVINCE_ID']));
                              $CO = $this->Model->getOne('syst_communes',array('COMMUNE_ID'=>$details['COMMUNE_ID']));
                              echo $PRO['PROVINCE_NAME'].' - '.$CO['COMMUNE_NAME'].'</td>
                              
                              <td><b>T&eacute;l&eacute;phone</b></td>
                              <td>'.$details['TELEPHONE'].'</td>
                              </tr>
                            <tr>
                              <td><b>Emploi</b></td>
                              <td>';
                              $EMP = $this->Model->getOne('masque_emploi',array('ID_EMPLOI'=>$details['ID_EMPLOI']));

                              $newAdh3 = date("d-m-Y", strtotime($details['DATE_ADHESION']));

                              echo $EMP['DESCRIPTION'].'</td>
                              <td><b>Adresse</b></td>
                              <td>'.$details['ADRESSE'].'</td>
                              </tr>
                            <tr>
                              <td><b>Date d\'adhesion</b></td>
                              <td>'.$newAdh3.'</td><td><b>Code d\'afiliation</b></td>
                              <td>'.$details['CODE_AFILIATION'].'</td>
                            </tr>
                            <tr>
                              <td><b>Agence</b></td>
                              '.$a.'';
                              $AGEN = $this->Model->getOne('masque_agence_msi',array('ID_AGENCE'=>$details['ID_AGENCE']));
                              echo $AGEN['DESCRIPTION'].'</td>
                              '.$ajout_affilie.'

              </table>


            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
            </div>
          </div>
        </div>
      </div>
      <a class="btn btn-primary btn-sm" href="'.base_url('membre/Membre/index_update_ayant/'.$keys['ID_MEMBRE']).'" role="button"><i class="far fa-edit"></i></a>
      <button type="button" class="btn '.$buttoncolor.' btn-sm" data-toggle="modal" data-target="#delete'.$keys['ID_MEMBRE'].'"><i class="fas fa-minus-circle"></i></button>

      <button type="button" class="btn '.$buttoncolor.' btn-sm"   onclick="get_membre('.$keys['ID_MEMBRE'].')"><i class="fas fa-times-circle" title="Changer la date fin"></i></button>
      <div class="modal fade" id="delete'.$keys['ID_MEMBRE'].'">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">'.$textheader.'</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              '.$textnormal.' '.$keys['NOM'].' '.$keys['PRENOM'].'?
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <a class="btn '.$buttoncolor.' btn-sm" href="'.base_url('membre/Membre/'.$fonctions.'/'.$keys['ID_MEMBRE']).'" role="button">'.$buttontext.'</a>
            </div>
          </div>
        </div>
      </div>
                    </td>
                  </tr>';
                   } 
                  ?>
                  <tr>
                    <td class="text-center" colspan="3">
                     <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-lg">
                  Ajout ayants droits
                </button>  
                    </td>
                  </tr>
                 </tbody>    
                </table>

      
                <div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Ajouter un ayant droits</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <form id="FormData" action="<?php echo base_url()?>membre/Membre/ayant_droits_add" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="ID_MEMBRE" class="form-control" value="<?php echo $selected['ID_MEMBRE']?>" id="ID_MEMBRE">
                      <div class="row">
                         <div class="form-group col-md-4">
                          <label for="NOM">
                             Nom
                             <i class="text-danger"> *</i>
                          </label>
                          <input type="text" name="NOM" class="form-control" value="" id="NOM">
                          <?php echo form_error('NOM', '<div class="text-danger">', '</div>'); ?>
                      </div>
                      <div class="form-group col-md-4">
                          <label for="ID_TYPE_STRUCTURE">
                             Pr&eacute;nom
                             <i class="text-danger"> *</i>
                          </label>
                          <input type="text" name="PRENOM" class="form-control" value="" id="PRENOM">
                          <?php echo form_error('PRENOM', '<div class="text-danger">', '</div>'); ?>
                       </div>
                       <div class="form-group col-md-4">
                    <label for="">Photo Passport</label>
                     <input type="file" name="URL_PHOTO" value="<?=set_value('URL_PHOTO')?>" required="required" class="form-control" id="URL_PHOTO" accept="image/*">
                          <?php echo form_error('URL_PHOTO', '<div class="text-danger">', '</div>'); ?>
                  </div>
                       <div class="form-group col-md-4">
                          <label for="CNI">
                             CNI/PASSPORT
                             <!-- <i class="text-danger"> *</i> -->
                          </label>
                          <input type="text" name="CNI" class="form-control" value="" id="CNI">
                          <?php echo form_error('CNI', '<div class="text-danger">', '</div>'); ?>
                       </div>
                       <div class="form-group col-md-4">
                          <label for="ID_SEXE">
                             Sexe
                             <i class="text-danger"> *</i>
                          </label><br>
                          <label class="radio-inline">
                            <input type="radio" name="ID_SEXE" id="inlineRadio1" value="1"> Homme &nbsp;&nbsp;&nbsp;&nbsp;
                          </label>
                          <label class="radio-inline">
                            <input type="radio" name="ID_SEXE" id="inlineRadio2" value="2"> Femme
                          </label>
                          <?php echo form_error('ID_SEXE', '<div class="text-danger">', '</div>'); ?>
                       </div>
                       <div class="form-group col-md-4">
                          <label for="DATE_NAISSANCE">
                              Date Naissance
                             <i class="text-danger"> *</i>
                          </label>
                          
                          <input type="date" name="DATE_NAISSANCE" id="DATE_NAISSANCE"  class="form-control" onchange="get_input()" value="<?=set_value('DATE_NAISSANCE')?>" id="DATE_NAISSANCE">
                          <?php echo form_error('DATE_NAISSANCE', '<div class="text-danger">', '</div>'); ?>
                       </div>
                       <div class="form-group col-md-4">
                          <label for="ID_GROUPE_SANGUIN">
                             Groupe Sanguin
                             <i class="text-danger"> *</i>
                          </label>
                          <select class="form-control" name="ID_GROUPE_SANGUIN" id="ID_GROUPE_SANGUIN">
                          <option value="" >-- Sélectionner --</option>
                          <?php
                          foreach ($groupesanguin as $key => $value) { ?>
                          <option value="<?=$value['ID_GROUPE_SANGUIN']?>" ><?=$value['DESCRIPTION']?></option>
                          <?php
                           } ?>
                          </select>
                          <?php echo form_error('ID_GROUPE_SANGUIN', '<div class="text-danger">', '</div>'); ?>
                       </div>
                       
                       
                       <div class="form-group col-md-4">
                          <label for="TELEPHONE">
                             Téléphone
                             <!-- <i class="text-danger"> *</i> -->
                          </label>
                          <input type="number" name="TELEPHONE" class="form-control" value="" id="TELEPHONE">
                          <?php echo form_error('TELEPHONE', '<div class="text-danger">', '</div>'); ?>
                       </div>
                       <input type="hidden" name="DATE_ADHESION" class="form-control" value="<?php echo date('Y-m-d') ?>" readonly="readonly" id="DATE_ADHESION">
                       <input type="hidden" readonly="readonly" name="CODE_AFILIATION" class="form-control" value="" id="CODE_AFILIATION">
                       <!-- <div class="form-group col-md-3">
                          <label for="DATE_ADHESION">
                             Date d'adhesion
                             <i class="text-danger"> *</i>
                          </label>
                          <input type="date" name="DATE_ADHESION" class="form-control" value="<?php echo date('Y-m-d') ?>" readonly="readonly" id="DATE_ADHESION">
                          <?php echo form_error('DATE_ADHESION', '<div class="text-danger">', '</div>'); ?>
                       </div> -->
                       <!-- <div class="form-group col-md-3">
                          <label for="CODE_AFILIATION">
                             Code d'afiliation
                             <i class="text-danger"> *</i>
                          </label>
                          
                          <?php echo form_error('CODE_AFILIATION', '<div class="text-danger">', '</div>'); ?>
                       </div>   -->           
                       <div class="form-group col-md-4">
                          <label for="TELEPHONE">
                             Est Conjoint de l'affilié? 
                             <i class="text-danger"> *</i>
                          </label>
                          <br>
                          <label class="radio-inline">
                            <input type="radio" name="IS_CONJOINT" id="oui" value="1"> OUI &nbsp;&nbsp;&nbsp;&nbsp;
                          </label>
                          <label class="radio-inline">
                            <input type="radio" id="non" name="IS_CONJOINT" value="0"> NON
                          </label>
                          <!-- <input type="number" name="TELEPHONE" class="form-control" value="" id="TELEPHONE"> -->
                          <?php echo form_error('IS_CONJOINT', '<div class="text-danger">', '</div>'); ?>
                       </div> 

                      <div class="form-group col-md-4" id="DIV_ATT_DOCUMENT" style="display: none;">
          
                <label for="ATT_DOCUMENT">Document scolaire <i class="text-danger"> *</i></label>
                <input type="file" name="ATT_DOCUMENT" id="ATT_DOCUMENT" class="form-control" accept="application/pdf">
                <?php echo form_error('ATT_DOCUMENT', '<div class="text-danger">', '</div>'); ?>
         
        </div>   

      
            <div class="form-group col-md-4"  id="DIV_NOM_DOCUMENT" style="display: none;">
                <label for="NOM_DOCUMENT">Nom du document <i class="text-danger"> *</i></label>
                <input type="text" name="NOM_DOCUMENT" id="NOM_DOCUMENT" class="form-control">
                <?php echo form_error('NOM_DOCUMENT', '<div class="text-danger">', '</div>'); ?>
         </div> 

      
            <div class="form-group col-md-4" id="DIV_DATE_DOCUMENT" style="display: none;">
                <label for="DATE_DOCUMENT">Date de délivrance du document <i class="text-danger"> *</i></label>
                <input type="date" name="DATE_DOCUMENT" id="DATE_DOCUMENT" class="form-control">
                <?php echo form_error('DATE_DOCUMENT', '<div class="text-danger">', '</div>'); ?>
            </div>         
                     </div>

                 
        
                

                     


                    <div class="row" style="margin-top: 5px">
                            <div class="col-10" id="divdata" class="text-center">
                                <input type="submit" value="Enregistrer" class="btn btn-primary"/>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                            </div>
                    </div>
                   </form>












            </div>
            <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button> -->
            <!-- <div class="modal-footer justify-content-between">
              
              <button type="button" class="btn btn-primary">Save changes</button>
            </div> -->
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
                <!-- <input type="hidden" name="ID_MEMBRE" class="form-control" value="<?php echo $selected['ID_MEMBRE']?>" id="ID_MEMBRE"> -->
                          <!-- <div class="row" style="margin-top: 5px">
                                            <div class="col-10" id="divdata" class="text-center">
                                                <input type="submit" value="Enregistrer" class="btn btn-primary"/>
                                            </div>
                                        </div> -->
                                    <!-- </form> -->
                      </div>   

                    </div>
                                        
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

<div class="modal" id="modificationdateaffilie_modal" role="dialog">
    <div class="modal-dialog modal-lg ">
      <div class="modal-content">
        <div class="modal-header">
         <h5> Modification de la date fin pour un affilie</h5>
         <div >    
          <i class="close fa fa-remove float-left text-primary" data-dismiss="modal"></i>  
          <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
          </button>

        </div>
      </div>
      <div class="modal-body">
        <div class="table-responsive" id="resultatmodif">
         
        </div>

      </div>
    </div>
  </div>
</div>
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
<script type="text/javascript">
    function send_modif() {
        var date1 = $('#DATE_ADHESION2').val().trim();
        var date2 = $('#DATE_FIN').val().trim();
        var statut = 1;

        if (date1 === '') {
            statut = 0;
            $('#erDATE_ADHESION').html("Champ obligatoire");
        } else {
            $('#erDATE_ADHESION').html("");
        }

        if (date2 === '') {
            statut = 0;
            $('#erDATE_FIN2').html("Champ obligatoire");
        } else {
            $('#erDATE_FIN2').html("");
        }

        if (statut === 0) return; // Stop execution if required fields are missing
       
        // Convert to Date Objects with explicit format handling
        var parts1 = date1.split('-'); // Expecting format YYYY-MM-DD
        var parts2 = date2.split('-');

        var dateStart = new Date(parts1[0], parts1[1] - 1, parts1[2]); // Month is 0-based
        var dateEnd = new Date(parts2[0], parts2[1] - 1, parts2[2]);

        // Date comparison
        if (dateEnd < dateStart) {
            statut = 0;
            $('#erDATE_FIN2').html("La date fin doit être supérieure à la date début.");
        } else {
            $('#erDATE_FIN2').html("");
        }

        if (statut === 1) {
            document.getElementById('FormDatachange').submit();
        }
    }
</script>

 <!--  <script type="text/javascript">
    function send_modif(argument) {
    
    var date1=$('#DATE_ADHESION').val();
    var date2=$('#DATE_FIN').val();
    
 
    var statut=1;

   
    if (date1.trim() ==='') {
    statut=0;
    $('#erDATE_ADHESION').html("Champ obligatoire");

    }else{
  
    $('#erDATE_ADHESION').html("");
 
    }

    if (date2.trim() ==='') {
    statut=0;
      
    $('#erDATE_FIN2').html("Champ obligatoire");

    }else{
   
    $('#erDATE_FIN2').html("");
 
    }

    var date3 = new Date($('#DATE_ADHESION').val());
    var date4 = new Date($('#DATE_FIN').val());
   
   if (date4 < date3) {
   statut=0;
   $('#erDATE_FIN2').html("La date fin doit etre superieur a la date debut.");
   } else {
  
   $('#erDATE_FIN2').html("");
   }
   


    var myform=document.getElementById('FormDatachange');
    if (statut==1) {
    myform.submit();
    }



    }
    
  </script> -->


<script type="text/javascript">
  function get_membre(id) 
  {
    // alert(id)
     $("#modificationdateaffilie_modal").modal("show");

      $.post('<?php echo base_url('membre/Membre/modif_date')?>',
          {id:id},
          function(data){
            $('#resultatmodif').html(data);
          }); 
  }
</script>
<script>
  $(document).ready(function(){ 
    $('#message').delay(5000).hide('slow');
     // $("#oui").click(function(){
     //            $("input[name='IS_CONJOINT'][value='1']").prop("checked", true);
     //        });

     //        // Set the value to Female when the button is clicked
     //        $("#non").click(function(){
     //            $("input[name='IS_CONJOINT'][value='0']").prop("checked", true);
     //        });
    // get_input();

    <?php if ($display_modal==1) {  ?>

        

             $("#modal-lg").modal('show');

       
        
      
  <?php } ?>
    });
</script>


<script type="text/javascript">
   
        // Select all radio buttons with the name "radioGroup"
        const radioButtons = document.getElementsByName('IS_CONJOINT');

        // Function to handle the radio button change event
        function handleRadioButtonChange(event) {
            // Get the selected value
           get_input();
        }

        // Add an event listener to each radio button
        radioButtons.forEach(radioButton => {
            radioButton.addEventListener('change', handleRadioButtonChange);
        });
 
</script>

<script type="text/javascript">
  function isOver18YearsOld(dateInput) {
    // Get the current date
    const currentDate = new Date();

    // Get the date from the input (assuming the input is a valid date string)
    const inputDate = new Date(dateInput);

    // Calculate the difference in years
    let age = currentDate.getFullYear() - inputDate.getFullYear();

    // Adjust the age if the birthday hasn't occurred yet this year
    const monthDifference = currentDate.getMonth() - inputDate.getMonth();
    if (monthDifference < 0 || (monthDifference === 0 && currentDate.getDate() < inputDate.getDate())) {
        age--;
    }

    // Check if the age is 18 or older
    return age >= 18;
}
  function get_input(argument) {
    // Get the date input element
    const dateInput = document.getElementById('DATE_NAISSANCE').value;

    const radioButtons = document.getElementsByName('IS_CONJOINT');

    // Variable to store the selected value
    let selectedValue = null;

    // Loop through the radio buttons to find the selected one
    for (const radioButton of radioButtons) {
        if (radioButton.checked) {
            selectedValue = radioButton.value;
            break;
        }
    }

    

    // Check if the input is valid
    if (!dateInput) {
        alert("Please enter a valid date.");
        return;
    }

    // Verify if the user is over 18
    if (isOver18YearsOld(dateInput) &&  selectedValue === '0') {
      document.getElementById('DIV_ATT_DOCUMENT').style.display="block";
      document.getElementById('DIV_NOM_DOCUMENT').style.display="block";
      document.getElementById('DIV_DATE_DOCUMENT').style.display="block";

   } else {
       document.getElementById('DIV_ATT_DOCUMENT').style.display="none";
      document.getElementById('DIV_NOM_DOCUMENT').style.display="none";
      document.getElementById('DIV_DATE_DOCUMENT').style.display="none";
    }
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
$('#DATE_NAISSANC').daterangepicker({
    "singleDatePicker": true,
    "showDropdowns": true,
    "opens": "center",
    "drops": "auto"
}, function(start, end, label) {
  console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
});
</script>
