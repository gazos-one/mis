  <?php
  include VIEWPATH.'includes/new_header.php';
  include VIEWPATH.'includes/new_top_menu.php';
  include VIEWPATH.'includes/new_menu_principal.php';
  ?>
  <link href="http://fonts.cdnfonts.com/css/myriad-pro" rel="stylesheet">
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php
    include 'includes/Menu_Membre.php';
    ?>
    <style type="text/css">
      @media print {
    * {
        -webkit-print-color-adjust: exact;
    }
}
     
    </style>

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
            <div class="card card-primary card-tabs">
              <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Details de l'affili&eacute;</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Consomation de l'affili&eacute; et de ses ayants droits</a>
                  </li>
                  
                  
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-one-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">

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
                              <td colspan="3"><?php
                              $PRO = $this->Model->getOne('syst_provinces',array('PROVINCE_ID'=>$selected['PROVINCE_ID']));
                              $CO = $this->Model->getOne('syst_communes',array('COMMUNE_ID'=>$selected['COMMUNE_ID']));
                              echo $PRO['PROVINCE_NAME'].' - '.$CO['COMMUNE_NAME']?></td>
                              
                              
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
                              echo $newAdh?></td><td><b>Code d'afiliation</b></td>
                              <td><?php echo $selected['CODE_AFILIATION']?></td>
                            </tr>
                            <tr>
                              <td><b>Agence</b></td>
                              <td><?php 
                              $AGEN = $this->Model->getOne('masque_agence_msi',array('ID_AGENCE'=>$selected['ID_AGENCE']));
                              echo $AGEN['DESCRIPTION']?></td>
                              <td><b>T&eacute;l&eacute;phone</b></td>
                              <td><?php echo $selected['TELEPHONE']?></td>
                            </tr>
                          </table>
                          
<button class="btn btn-primary" onclick="printDiv('printsideA')"><i class="fa fa-file"></i> PVC Affili&eacute;</button>
<div id="printsideA" style="display: none">
  <br>
  <img src="<?php echo base_url()?>/uploads/front_empy2.png" style="height: 6cm!important;border: 1px solid green;" >
  <div style="margin-left: 135px!important; margin-top:-168px!important; font-family: MyriadPro-Regular;font-size: 15px;">
    Nom:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b><?php echo $selected['NOM']?></b>
  </div>

  <div style="margin-left: 135px!important; margin-top:4px!important; font-family: MyriadPro-Regular;font-size: 15px;">
    Pr&eacute;nom:&nbsp;&nbsp;&nbsp; <b><?php echo $selected['PRENOM']?></b>
  </div>
  <div style="margin-left: 135px!important; margin-top:4px!important; font-family: MyriadPro-Regular;font-size: 15px;">
    Matricule: <i><b><?php echo $selected['CODE_AFILIATION']?></b></i>
  </div>
  <?php 
    $membreun = $this->Model->getRequeteOne("SELECT membre_carte_membre.FIN_SUR_LA_CARTE, membre_carte.ID_CARTE, membre_carte.ID_CATEGORIE_ASSURANCE, syst_categorie_assurance.DESCRIPTION FROM membre_carte_membre JOIN membre_carte ON membre_carte.ID_CARTE = membre_carte_membre.ID_CARTE JOIN syst_categorie_assurance ON syst_categorie_assurance.ID_CATEGORIE_ASSURANCE = membre_carte.ID_CATEGORIE_ASSURANCE WHERE ID_MEMBRE = ".$selected['ID_MEMBRE']." AND membre_carte_membre.STATUS = 1");?>
  <div style="margin-left: 135px!important; margin-top:4px!important; font-family: MyriadPro-Regular;font-size: 15px;color: red;">
    Validit&eacute;: &nbsp;&nbsp; <i><b><?php 
    $originalDate = $membreun['FIN_SUR_LA_CARTE'];
    $newDate = date("d-m-Y", strtotime($originalDate));
    $soin1 = $this->Model->getRequeteOne("SELECT syst_categorie_assurance_type_structure.ID_TYPE_STRUCTURE, syst_categorie_assurance_type_structure.POURCENTAGE FROM syst_categorie_assurance JOIN syst_categorie_assurance_type_structure ON syst_categorie_assurance_type_structure.ID_CATEGORIE_ASSURANCE = syst_categorie_assurance.ID_CATEGORIE_ASSURANCE WHERE syst_categorie_assurance.ID_CATEGORIE_ASSURANCE = ".$membreun['ID_CATEGORIE_ASSURANCE']." AND syst_categorie_assurance_type_structure.ID_TYPE_STRUCTURE = 1");
    $soin2 = $this->Model->getRequeteOne("SELECT syst_categorie_assurance_type_structure.ID_TYPE_STRUCTURE, syst_categorie_assurance_type_structure.POURCENTAGE FROM syst_categorie_assurance JOIN syst_categorie_assurance_type_structure ON syst_categorie_assurance_type_structure.ID_CATEGORIE_ASSURANCE = syst_categorie_assurance.ID_CATEGORIE_ASSURANCE WHERE syst_categorie_assurance.ID_CATEGORIE_ASSURANCE = ".$membreun['ID_CATEGORIE_ASSURANCE']." AND syst_categorie_assurance_type_structure.ID_TYPE_STRUCTURE = 2");
    $soin3 = $this->Model->getRequeteOne("SELECT syst_categorie_assurance_type_structure.ID_TYPE_STRUCTURE, syst_categorie_assurance_type_structure.POURCENTAGE FROM syst_categorie_assurance JOIN syst_categorie_assurance_type_structure ON syst_categorie_assurance_type_structure.ID_CATEGORIE_ASSURANCE = syst_categorie_assurance.ID_CATEGORIE_ASSURANCE WHERE syst_categorie_assurance.ID_CATEGORIE_ASSURANCE = ".$membreun['ID_CATEGORIE_ASSURANCE']." AND syst_categorie_assurance_type_structure.ID_TYPE_STRUCTURE = 3 ");
    $med1 = $this->Model->getRequeteOne("SELECT syst_categorie_assurance_medicament.ID_COUVERTURE_MEDICAMENT, syst_categorie_assurance_medicament.POURCENTAGE FROM syst_categorie_assurance JOIN syst_categorie_assurance_medicament ON syst_categorie_assurance_medicament.ID_CATEGORIE_ASSURANCE = syst_categorie_assurance.ID_CATEGORIE_ASSURANCE WHERE syst_categorie_assurance.ID_CATEGORIE_ASSURANCE = ".$membreun['ID_CATEGORIE_ASSURANCE']." AND syst_categorie_assurance_medicament.ID_COUVERTURE_MEDICAMENT = 1");
    $med2 = $this->Model->getRequeteOne("SELECT syst_categorie_assurance_medicament.ID_COUVERTURE_MEDICAMENT, syst_categorie_assurance_medicament.POURCENTAGE FROM syst_categorie_assurance JOIN syst_categorie_assurance_medicament ON syst_categorie_assurance_medicament.ID_CATEGORIE_ASSURANCE = syst_categorie_assurance.ID_CATEGORIE_ASSURANCE WHERE syst_categorie_assurance.ID_CATEGORIE_ASSURANCE = ".$membreun['ID_CATEGORIE_ASSURANCE']." AND syst_categorie_assurance_medicament.ID_COUVERTURE_MEDICAMENT = 2");
    echo $newDate;?></b></i>
  </div>

  
  
<br><br><br><br><br><br>
<img src="<?php echo base_url()?>/uploads/image_membre/<?php echo $nimag?>" style="height: 3.4cm!important;  width: 2cm!!important; margin-top: -55px;border: 1px solid green;" >
<br><br><br><br><br><br>
  <img src="<?php echo base_url()?>/uploads/back_empy.png" style="height: 6cm!important; border: 1px solid green;" >
  <div style="margin-left: 26px!important; margin-top:-130px!important;">
    <?php echo $soin1['POURCENTAGE']?>%
  </div>
  <div style="margin-left: 60px!important; margin-top:-24px!important; ">
    <?php echo $soin2['POURCENTAGE']?>%
  </div>
  <div style="margin-left: 100px!important; margin-top:-24px!important;">
    <?php echo $soin3['POURCENTAGE']?>%
  </div>
  <div style="margin-left: 147px!important; margin-top:-24px!important;">
    <?php echo $med1['POURCENTAGE']?>%
  </div>
  <div style="margin-left: 195px!important; margin-top:-24px!important;">
    <?php echo $med2['POURCENTAGE']?>%
  </div>
  <div style="margin-left: 140px!important; margin-top:10px!important;">
    <h3><b style="color: red;"><?php echo $membreun['DESCRIPTION']?></b></h3>
  </div>
<?php
$qrcodes = $this->Model->getRequeteOne("SELECT membre_membre_qr.PATH_QR_CODE FROM membre_membre_qr  WHERE ID_MEMBRE = ".$selected['ID_MEMBRE']." ");
?>
  <div style="margin-left: 253px!important;  margin-top: -130px!important;">

    <img src="<?php echo base_url()?>/uploads/QRCODE/<?php echo $qrcodes['PATH_QR_CODE']?>" style="width: 2.6cm!important; margin-top: 0px;" >
  </div>

</div>



                      </div>

                      <div class="form-group col-md-6">
                          
                <table class="table">
                  <tr>
                    <td class="text-center" colspan="5"><b>Ayant droit d&eacute;j&agrave; enregistr&eacute;</b></td>
                  </tr>
                  <tr>
                    <td><b>Nom & Prenom</b></td>
                    <!-- <td><b>Naissance</b></td> -->
                    <!-- <td><b>Age</b></td> -->
                    <!-- <td><b>GS</b></td> -->
                    <td><b>Action</b></td>
                  </tr>

                  <?php
                    
                  // $groupmembre = $this->Model->getList('groupmembre');
                  foreach ($groupmembre as $keys) {

                    $details = $this->Model->getOne('membre_membre',array('ID_MEMBRE'=>$keys['ID_MEMBRE']));
                    if ($details['URL_PHOTO'] == null) {
                    $nimagd = 'default.jpg';
                      }
                    else{
                     $nimagd = $details['URL_PHOTO'];
                     }
                    ?>


                    
<div id="printsideAS<?php echo $keys['ID_MEMBRE']?>" style="display: none">
  <br>
  <img src="<?php echo base_url()?>/uploads/front_empy2.png" style="height: 6cm!important;border: 1px solid green;" >
  <div style="margin-left: 135px!important; margin-top:-168px!important; font-family: MyriadPro-Regular;font-size: 15px;">
    Nom:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b><?php echo $keys['NOM']?></b>
  </div>

  <div style="margin-left: 135px!important; margin-top:4px!important; font-family: MyriadPro-Regular;font-size: 15px;">
    Pr&eacute;nom:&nbsp;&nbsp;&nbsp; <b><?php echo $keys['PRENOM']?></b>
  </div>
  <div style="margin-left: 135px!important; margin-top:4px!important; font-family: MyriadPro-Regular;font-size: 15px;">
    Matricule: <i><b><?php echo $selected['CODE_AFILIATION']?></b></i>
  </div>
  <?php 
    $membreun = $this->Model->getRequeteOne("SELECT membre_carte_membre.FIN_SUR_LA_CARTE, membre_carte.ID_CARTE, membre_carte.ID_CATEGORIE_ASSURANCE, syst_categorie_assurance.DESCRIPTION FROM membre_carte_membre JOIN membre_carte ON membre_carte.ID_CARTE = membre_carte_membre.ID_CARTE JOIN syst_categorie_assurance ON syst_categorie_assurance.ID_CATEGORIE_ASSURANCE = membre_carte.ID_CATEGORIE_ASSURANCE WHERE ID_MEMBRE = ".$selected['ID_MEMBRE']." AND membre_carte_membre.STATUS = 1");?>
  <div style="margin-left: 135px!important; margin-top:4px!important; font-family: MyriadPro-Regular;font-size: 15px;color: red;">
    Validit&eacute;: &nbsp;&nbsp; <i><b><?php 
    $originalDate = $membreun['FIN_SUR_LA_CARTE'];
    $newDate = date("d-m-Y", strtotime($originalDate));
    $soin1 = $this->Model->getRequeteOne("SELECT syst_categorie_assurance_type_structure.ID_TYPE_STRUCTURE, syst_categorie_assurance_type_structure.POURCENTAGE FROM syst_categorie_assurance JOIN syst_categorie_assurance_type_structure ON syst_categorie_assurance_type_structure.ID_CATEGORIE_ASSURANCE = syst_categorie_assurance.ID_CATEGORIE_ASSURANCE WHERE syst_categorie_assurance.ID_CATEGORIE_ASSURANCE = ".$membreun['ID_CATEGORIE_ASSURANCE']." AND syst_categorie_assurance_type_structure.ID_TYPE_STRUCTURE = 1");
    $soin2 = $this->Model->getRequeteOne("SELECT syst_categorie_assurance_type_structure.ID_TYPE_STRUCTURE, syst_categorie_assurance_type_structure.POURCENTAGE FROM syst_categorie_assurance JOIN syst_categorie_assurance_type_structure ON syst_categorie_assurance_type_structure.ID_CATEGORIE_ASSURANCE = syst_categorie_assurance.ID_CATEGORIE_ASSURANCE WHERE syst_categorie_assurance.ID_CATEGORIE_ASSURANCE = ".$membreun['ID_CATEGORIE_ASSURANCE']." AND syst_categorie_assurance_type_structure.ID_TYPE_STRUCTURE = 2");
    $soin3 = $this->Model->getRequeteOne("SELECT syst_categorie_assurance_type_structure.ID_TYPE_STRUCTURE, syst_categorie_assurance_type_structure.POURCENTAGE FROM syst_categorie_assurance JOIN syst_categorie_assurance_type_structure ON syst_categorie_assurance_type_structure.ID_CATEGORIE_ASSURANCE = syst_categorie_assurance.ID_CATEGORIE_ASSURANCE WHERE syst_categorie_assurance.ID_CATEGORIE_ASSURANCE = ".$membreun['ID_CATEGORIE_ASSURANCE']." AND syst_categorie_assurance_type_structure.ID_TYPE_STRUCTURE = 3 ");
    $med1 = $this->Model->getRequeteOne("SELECT syst_categorie_assurance_medicament.ID_COUVERTURE_MEDICAMENT, syst_categorie_assurance_medicament.POURCENTAGE FROM syst_categorie_assurance JOIN syst_categorie_assurance_medicament ON syst_categorie_assurance_medicament.ID_CATEGORIE_ASSURANCE = syst_categorie_assurance.ID_CATEGORIE_ASSURANCE WHERE syst_categorie_assurance.ID_CATEGORIE_ASSURANCE = ".$membreun['ID_CATEGORIE_ASSURANCE']." AND syst_categorie_assurance_medicament.ID_COUVERTURE_MEDICAMENT = 1");
    $med2 = $this->Model->getRequeteOne("SELECT syst_categorie_assurance_medicament.ID_COUVERTURE_MEDICAMENT, syst_categorie_assurance_medicament.POURCENTAGE FROM syst_categorie_assurance JOIN syst_categorie_assurance_medicament ON syst_categorie_assurance_medicament.ID_CATEGORIE_ASSURANCE = syst_categorie_assurance.ID_CATEGORIE_ASSURANCE WHERE syst_categorie_assurance.ID_CATEGORIE_ASSURANCE = ".$membreun['ID_CATEGORIE_ASSURANCE']." AND syst_categorie_assurance_medicament.ID_COUVERTURE_MEDICAMENT = 2");
    echo $newDate;?></b></i>
  </div>

  
<br><br><br><br><br><br>
<img src="<?php echo base_url()?>/uploads/image_membre/<?php echo $nimagd?>" style="height: 3.4cm!important;  width: 2cm!!important; margin-top: -55px;border: 1px solid green;" >
<br><br><br><br><br><br>
  <img src="<?php echo base_url()?>/uploads/back_empy.png" style="height: 6cm!important; border: 1px solid green;" >
  <div style="margin-left: 26px!important; margin-top:-130px!important;">
    <?php echo $soin1['POURCENTAGE']?>%
  </div>
  <div style="margin-left: 60px!important; margin-top:-24px!important; ">
    <?php echo $soin2['POURCENTAGE']?>%
  </div>
  <div style="margin-left: 100px!important; margin-top:-24px!important;">
    <?php echo $soin3['POURCENTAGE']?>%
  </div>
  <div style="margin-left: 147px!important; margin-top:-24px!important;">
    <?php echo $med1['POURCENTAGE']?>%
  </div>
  <div style="margin-left: 195px!important; margin-top:-24px!important;">
    <?php echo $med2['POURCENTAGE']?>%
  </div>
  <div style="margin-left: 140px!important; margin-top:10px!important;">
    <h3><b style="color: red;"><?php echo $membreun['DESCRIPTION']?></b></h3>
  </div>
<?php
$qrcodes_aff = $this->Model->getRequeteOne("SELECT membre_membre_qr.PATH_QR_CODE FROM membre_membre_qr  WHERE ID_MEMBRE = ".$keys['ID_MEMBRE']." ");
?>
  <div style="margin-left: 253px!important;  margin-top: -130px!important;">

    <img src="<?php echo base_url()?>/uploads/QRCODE/<?php echo $qrcodes_aff['PATH_QR_CODE']?>" style="width: 2.6cm!important; margin-top: 0px;" >
  </div>

</div>

                    <?php
                    $groups = $this->Model->getOne('syst_groupe_sanguin',array('ID_GROUPE_SANGUIN'=>$keys['ID_GROUPE_SANGUIN']));
                    

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
                     $newDate = date("d-m-Y", strtotime($keys['DATE_NAISSANCE']));
                    // echo  $newDate;

                     $from = new DateTime($keys['DATE_NAISSANCE']);
                     $to   = new DateTime('today');
                     $age = $from->diff($to)->y;

                    echo "<tr>
                    <td>".$keys['NOM']." ".$keys['PRENOM']."</td>
                    <td>";

        echo '<button class="btn btn-primary btn-sm" onclick="printDivs('.$keys['ID_MEMBRE'].')"><i class="fa fa-file"></i> PVC</button>
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#details'.$keys['ID_MEMBRE'].'"><i class="far fa-eye"></i> D&eacute;tails</button>
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
                              $newNAI = date("d-m-Y", strtotime($details['DATE_NAISSANCE']));
                              echo $DSEX['DESCRIPTION'].'</td>
                            </tr>
                            <tr>
                              <td><b>Date de naissance</b></td>
                              <td>'.$newNAI.'</td>
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

                              $newNAInew = date("d-m-Y", strtotime($details['DATE_ADHESION']));

                              echo $EMP['DESCRIPTION'].'</td>
                              <td><b>Adresse</b></td>
                              <td>'.$details['ADRESSE'].'</td>
                              </tr>
                            <tr>
                              <td><b>Date d\'adhesion</b></td>
                              <td>'.$newNAInew.'</td><td><b>Code d\'afiliation</b></td>
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

      <button type="button" class="btn '.$buttoncolor.' btn-sm" data-toggle="modal" data-target="#delete'.$keys['ID_MEMBRE'].'"><i class="fas fa-minus-circle"></i> '.$buttontext.'</button>
                        
                    </td>
                  </tr>';
                   } 
                  ?>
                  
                  
                </table>

                  </div>
                  </div>

                     
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">


                  <?php
                  $verifaffi = $this->Model->getRequeteOne('SELECT CODE_PARENT FROM membre_membre WHERE ID_MEMBRE = '.$selected['ID_MEMBRE'].''); 
                  if ($verifaffi['CODE_PARENT'] == NULL) {
                    $cconsultationa=$this->Model->getRequete('SELECT syst_couverture_structure.DESCRIPTION AS ID_TYPE_STRUCTURE, masque_stucture_sanitaire.DESCRIPTION AS STRUCTURE, consultation_consultation.DATE_CONSULTATION, consultation_consultation.POURCENTAGE_A, (consultation_consultation.MONTANT_CONSULTATION - consultation_consultation.MONTANT_A_PAYER) AS MONTANT_A_PAYER, IF(consultation_consultation.STATUS_PAIEMENT =0, "Non Paye", "Bien paye") AS STATUS_PAIEMENT, aff.NOM, aff.PRENOM, aff.IS_CONJOINT, aff.CODE_PARENT FROM consultation_consultation  JOIN membre_membre aff ON aff.ID_MEMBRE = consultation_consultation.ID_MEMBRE JOIN syst_couverture_structure ON syst_couverture_structure.ID_TYPE_STRUCTURE = consultation_consultation.ID_TYPE_STRUCTURE JOIN masque_stucture_sanitaire ON masque_stucture_sanitaire.ID_STRUCTURE = consultation_consultation.ID_STRUCTURE WHERE consultation_consultation.ID_MEMBRE = '.$selected['ID_MEMBRE'].' ');
                    $cconsultationb=$this->Model->getRequete('SELECT syst_couverture_structure.DESCRIPTION AS ID_TYPE_STRUCTURE, masque_stucture_sanitaire.DESCRIPTION AS STRUCTURE, consultation_consultation.DATE_CONSULTATION, consultation_consultation.POURCENTAGE_A, (consultation_consultation.MONTANT_CONSULTATION - consultation_consultation.MONTANT_A_PAYER) AS MONTANT_A_PAYER, IF(consultation_consultation.STATUS_PAIEMENT =0, "Non Paye", "Bien paye") AS STATUS_PAIEMENT, aff.NOM, aff.PRENOM, aff.IS_CONJOINT, aff.CODE_PARENT FROM consultation_consultation  JOIN membre_membre aff ON aff.ID_MEMBRE = consultation_consultation.ID_MEMBRE JOIN syst_couverture_structure ON syst_couverture_structure.ID_TYPE_STRUCTURE = consultation_consultation.ID_TYPE_STRUCTURE JOIN masque_stucture_sanitaire ON masque_stucture_sanitaire.ID_STRUCTURE = consultation_consultation.ID_STRUCTURE WHERE consultation_consultation.TYPE_AFFILIE = '.$selected['ID_MEMBRE'].' AND consultation_consultation.ID_MEMBRE != '.$selected['ID_MEMBRE'].'');

                    
                    $cmedicamenta=$this->Model->getRequete('SELECT consultation_pharmacie.DESCRIPTION AS PHARMACIE, consultation_medicament.TYPE_AFFILIE, membre_membre.NOM, membre_membre.PRENOM, consultation_medicament.DATE_CONSULTATION, consultation_medicament.MONTANT_A_PAYE_MIS, IF(consultation_medicament.STATUS_PAIEMENT =0, "Non Paye", "Bien paye") AS STATUS_PAIEMENT FROM `consultation_medicament` JOIN consultation_pharmacie ON consultation_pharmacie.ID_PHARMACIE = consultation_medicament.ID_PHARMACIE JOIN membre_membre ON membre_membre.ID_MEMBRE = consultation_medicament.ID_MEMBRE WHERE consultation_medicament.ID_MEMBRE = '.$selected['ID_MEMBRE'].' ');
                    $cmedicamentb=$this->Model->getRequete('SELECT consultation_pharmacie.DESCRIPTION AS PHARMACIE, consultation_medicament.TYPE_AFFILIE, membre_membre.NOM, membre_membre.PRENOM, consultation_medicament.DATE_CONSULTATION, consultation_medicament.MONTANT_A_PAYE_MIS, IF(consultation_medicament.STATUS_PAIEMENT =0, "Non Paye", "Bien paye") AS STATUS_PAIEMENT FROM `consultation_medicament` JOIN consultation_pharmacie ON consultation_pharmacie.ID_PHARMACIE = consultation_medicament.ID_PHARMACIE JOIN membre_membre ON membre_membre.ID_MEMBRE = consultation_medicament.ID_MEMBRE WHERE consultation_medicament.TYPE_AFFILIE = '.$selected['ID_MEMBRE'].' AND consultation_medicament.ID_MEMBRE != '.$selected['ID_MEMBRE'].' ');
                  }
                  else{
                    $cconsultationa= array();
                    $cconsultationb= array();
                    $cmedicamenta= array();
                    $cmedicamentb= array();
                  }
                  
                  
                  
                  ?>

<table id="example" class="mytable table" style="width:100%">
        <thead>
            <tr>
                <th style="width: 170px;">Nom</th>
                <th>Date</th>
                <th>Type</th>
                <th style="width: 110px;">Structure</th>
                <th>Montant MIS</th>
                <!-- <th>T Beneficaire</th> -->
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
          <?php
          //  aff.IS_CONJOINT, aff.CODE_PARENT
            foreach ($cconsultationa as $value) {
              echo '<tr>
              <td>'.$value['NOM'].' '.$value['PRENOM'].' (Affili&eacute;)</td>
              <td>'.$value['DATE_CONSULTATION'].'</td>
              <td>Consultation</td>
              <td>'.$value['STRUCTURE'].' ('.$value['ID_TYPE_STRUCTURE'].')</td>
              <td class="text-right">'.$value['MONTANT_A_PAYER'].' ('.$value['POURCENTAGE_A'].'%)</td>
              <td>'.$value['STATUS_PAIEMENT'].'</td>
          </tr>';
            }
          ?>
            
            <?php
          //  aff.IS_CONJOINT, aff.CODE_PARENT
            foreach ($cconsultationb as $value) {
              echo '<tr>
              <td>'.$value['NOM'].' '.$value['PRENOM'].' (Ayant droit)</td>
              <td>'.$value['DATE_CONSULTATION'].'</td>
              <td>Consultation</td>
              <td>'.$value['STRUCTURE'].' ('.$value['ID_TYPE_STRUCTURE'].')</td>
              <td class="text-right">'.$value['MONTANT_A_PAYER'].' ('.$value['POURCENTAGE_A'].'%)</td>
              <td>'.$value['STATUS_PAIEMENT'].'</td>
          </tr>';
            }
          ?>

          <?php
            foreach ($cmedicamenta as $value) {
              echo '<tr>
              <td>'.$value['NOM'].' '.$value['PRENOM'].' (Affili&eacute;)</td>
              <td>'.$value['DATE_CONSULTATION'].'</td>
              <td>Medicament</td>
              <td>'.$value['PHARMACIE'].'</td>
              <td class="text-right">'.$value['MONTANT_A_PAYE_MIS'].'</td>
              <td>'.$value['STATUS_PAIEMENT'].'</td>
          </tr>';
            }
          ?>
          <?php
            foreach ($cmedicamentb as $value) {
              echo '<tr>
              <td>'.$value['NOM'].' '.$value['PRENOM'].' (Ayant Droit)</td>
              <td>'.$value['DATE_CONSULTATION'].'</td>
              <td>Medicament</td>
              <td>'.$value['PHARMACIE'].'</td>
              <td class="text-right">'.$value['MONTANT_A_PAYE_MIS'].'</td>
              <td>'.$value['STATUS_PAIEMENT'].'</td>
          </tr>';
            }
          ?>


            
        </tbody>
       
    </table>
                     
                  </div>
                  
                 
                </div>
              </div>
              <!-- /.card -->
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

<script type="text/javascript">
      function printDiv(printsideA) {
     var printContents = document.getElementById(printsideA).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
</script>
<script type="text/javascript">
      function printDivs(ID) {
     var printContents = document.getElementById('printsideAS'+ID).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
</script>
 <!--     <script type="text/javascript">
       function printDiv(printsideA) {
  var corpo = document.getElementById(printsideA).innerHTML;
  const html = [];
  html.push('<html><head>');
  html.push('<link rel="stylesheet" href="' + document.querySelector("link[rel=stylesheet]").href + '">');
  html.push('</head><body onload="window.focus(); window.print()"><div>');
  html.push(corpo);
  html.push('</div></body></html>');
  var a = window.open('', '', 'width=640,height=480');
  a.document.open("text/html");
  a.document.write(html.join(""));
  a.document.close();
}
     </script> -->

<!--      <script type="text/javascript">
       function printDiv(printsideB) {
  var corpo = document.getElementById(printsideB).innerHTML;
  const html = [];
  html.push('<html><head>');
  html.push('<link rel="stylesheet" href="' + document.querySelector("link[rel=stylesheet]").href + '">');
  html.push('</head><body onload="window.focus(); window.print()"><div>');
  html.push(corpo);
  html.push('</div></body></html>');
  var a = window.open('', '', 'width=640,height=480');
  a.document.open("text/html");
  a.document.write(html.join(""));
  a.document.close();
}
     </script> -->

     <script type="text/javascript">
  $('.mytable').DataTable({
   dom: 'Bfrtlip',
   "paging":   true,
    "ordering": false,
    "info":     true,
    "lengthChange": true,
   buttons: [
      {
         extend: 'excel',
         text: 'Excel',
         className: 'btn btn-default',
         exportOptions: {
            columns: 'th:not(:last-child)'
         }
      },
      {
         extend: 'pdfHtml5',
         text: 'PDF',
         className: 'btn btn-default',
         exportOptions: {
            columns: 'th:not(:last-child)'
         }
      }
   ],
   order: [[1, 'desc']] ,
  //  ordering: false,
   language: {
                                "sProcessing":     "Traitement en cours...",
                                "sSearch":         "Rechercher&nbsp;:",
                                "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
                                "sInfo":           "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
                                "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
                                "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
                                "sInfoPostFix":    "",
                                "sLoadingRecords": "Chargement en cours...",
                                "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
                                "sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
                                "oPaginate": {
                                    "sFirst":      "Premier",
                                    "sPrevious":   "Pr&eacute;c&eacute;dent",
                                    "sNext":       "Suivant",
                                    "sLast":       "Dernier"
                                },
                                "oAria": {
                                    "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
                                    "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
                                }
                        }
});
</script>