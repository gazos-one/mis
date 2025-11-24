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
                <h3 class="card-title">Ajouter ou enlever les assurances aux ayant droits et a l'affili&eacute;</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->

         <div class="card-body">
               <?php
               if ($selected['URL_PHOTO'] == null) {
                 $nimag = 'default.jpg';
               }
               else{
                 $nimag = $selected['URL_PHOTO'];
               }
               ?>
          
                      <div class="row">
                        <div class="form-group col-md-6">
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
                              <td><b>CNI/PASSPORT</b></td>
                              <td><?php echo $selected['DATE_NAISSANCE']?></td>
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
                              <td><?php echo $selected['DATE_ADHESION']?></td><td><b>Code d'afiliation</b></td>
                              <td><?php echo $selected['CODE_AFILIATION']?></td>
                            </tr>
                            <tr>
                              <td><b>Agence</b></td>
                              <td colspan="3"><?php 
                              $AGEN = $this->Model->getOne('masque_agence_msi',array('ID_AGENCE'=>$selected['ID_AGENCE']));
                              echo $AGEN['DESCRIPTION']?></td>
                            </tr>
                          </table>
                      </div>
                      <div class="form-group col-md-6">
                          
                        <!-- <form id="FormData" action="#" method="POST"> -->
               <!-- <form id="FormData" action="<?php echo base_url()?>membre/Membre/update" method="POST"> -->
                
                <table class="table">
                  <tr>
                    <td class="text-center" colspan="4"><b>Ayant droit enregistr&eacute;</b></td>
                  </tr>
                  <tr>
                    <td><b>Nom & Prenom</b></td>
                    <td><b>Naissance</b></td>
                    <td><b>GS</b></td>
                    <td><b>Action</b></td>
                  </tr>
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
                    echo "<tr>
                    <td>".$keys['NOM']." ".$keys['PRENOM']."</td>
                    <td>".$keys['DATE_NAISSANCE']."</td>
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

                              echo $DSEX['DESCRIPTION'].'</td>
                            </tr>
                            <tr>
                              <td><b>CNI/PASSPORT</b></td>
                              <td>'.$details['DATE_NAISSANCE'].'</td>
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
                              echo $EMP['DESCRIPTION'].'</td>
                              <td><b>Adresse</b></td>
                              <td>'.$details['ADRESSE'].'</td>
                              </tr>
                            <tr>
                              <td><b>Date d\'adhesion</b></td>
                              <td>'.$details['DATE_ADHESION'].'</td><td><b>Code d\'afiliation</b></td>
                              <td>'.$details['CODE_AFILIATION'].'</td>
                            </tr>
                            <tr>
                              <td><b>Agence</b></td>
                              <td colspan="3">';
                              $AGEN = $this->Model->getOne('masque_agence_msi',array('ID_AGENCE'=>$details['ID_AGENCE']));
                              echo $AGEN['DESCRIPTION'].'</td>
                            </tr>
                          </table>


            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
            </div>
          </div>
        </div>
      </div>
      </div>
                    </td>
                  </tr>';
                   } 
                  ?>
                               
                </table>
                <table class="table">
                  
                  <tr>
                    <td class="text-center" colspan="2"><b>Assurance enregistr&eacute;</b></td>
                  </tr>

                  <?php
                  foreach ($aassurances as $value) {
                    echo'<tr>
                                        <td>'.$value['DESCRIPTION'].'</td>
                                        <td>
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete'.$value['ID_MEMBRE_ASSURANCE'].'"><i class="fas fa-sync"></i></button>

                                        <div class="modal fade" id="delete'.$value['ID_MEMBRE_ASSURANCE'].'">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Modification de l\'assurances</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="FormData" action="'.base_url().'membre/Membre/update_assurances" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
            <table class="table">
            <tr>
            <td>Actuellement:</td>
            <td colspan="2">Assurance <b>'.$value['DESCRIPTION'].'</b> valide depuis '.$value['DATE_DEBUT'].'</td>
            </tr>
            <tr>
            <td rowspan="2">Nouvelle assurances:</td>
            <td>Categorie assurance</td>
            <td>Debut validit&eacute; assurances:</td>
            </tr>
            <tr>
            <td>
            <input type="hidden" name="ID_MEMBRE_ASSURANCE" class="form-control" value="'.$value['ID_MEMBRE_ASSURANCE'].'" id="ID_MEMBRE_ASSURANCE">
            <input type="hidden" name="ID_MEMBRE" class="form-control" value="'.$value['ID_MEMBRE'].'" id="ID_MEMBRE">
            <select class="form-control" name="ID_CATEGORIE_ASSURANCE" id="ID_CATEGORIE_ASSURANCE">
                          <option value="" >-- Sélectionner --</option>';
                          foreach ($acategorie as $key) {                              
                              echo '<option value="'.$key['ID_CATEGORIE_ASSURANCE'].'">'.$key['DESCRIPTION'].'</option>';
                           }
                          echo'</select>
                          </td>
            <td></td>
            </tr>
            </table>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
              <input type="submit" value="Enregistrer" class="btn btn-danger btn-sm"/>
            </div>
            </form>
          </div>
        </div>
      </div>
                                        </td>
                                      </tr>';
                  }

                  ?>

                </table>

                 
                
               
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
$('#DATE_DEBUTS').daterangepicker({
    "singleDatePicker": true,
    "showDropdowns": true,
    "opens": "center",
    "drops": "auto"
}, function(start, end, label) {
  console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
});
</script>