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
    include 'includes/Menu_Consomation_Affilier.php';
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
            <div class="card card-primary card-tabs">
              <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Affilie</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Depacement de Plafond</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#custom-tabs-one-messages" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false">Details consomation</a>
                  </li>
                  
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-one-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                  <div class="row">
                        <div class="form-group col-md-12">
                  <?php
               if ($selected['URL_PHOTO'] == null) {
                 $nimag = 'default.jpg';
               }
               else{
                 $nimag = $selected['URL_PHOTO'];
               }
               ?>
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
                  </div>
                  
                  </div>
                  </div>
                  
                  <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                  <table class="table table-bordered">
                            <tr>
                              <td colspan="5" class="text-center"><b>Plafonds</b></td>
                            </tr>
                            <tr>
                              <td><b>Affili&eacute;</b></td>
                              <td><b>Nom</b></td>
                              <td><b>Plafond</b></td>
                              <td><b>Consomm&eacute;</b></td>
                              <td><b>Obsevation</b></td>
                            </tr>
                            <?php 
                            if ($plafond['PLAFOND_ANNUEL'] > $MONTANT_TOTAL) {
                              $tplafondannuel = 'OK';
                              $classeannuel = '';
                            }
                            else{
                              $tplafondannuel = 'Depass&eacute;';
                              $classeannuel = 'class="bg-danger"';
                            }
                            ?>
                            <tr <?php echo $classeannuel;?>>
                              <td></td>
                              <td>Annuel</td>
                              <td class="text-right"><?php echo number_format($plafond['PLAFOND_ANNUEL'],0,' ',' ')?></td>
                              <td class="text-right"><?php echo number_format($MONTANT_TOTAL,0,' ',' ')?></td>
                              <td> <?php echo $tplafondannuel;?> </td>
                            </tr>
                            <?php
                            $aff_consu_hos = $this->Model->getRequeteOne('SELECT SUM(consultation_consultation.MONTANT_A_PAYER) AS MONTANT FROM consultation_consultation WHERE consultation_consultation.ID_MEMBRE = '.$selected['ID_MEMBRE'].' AND ID_CONSULTATION_TYPE = 6  AND YEAR(consultation_consultation.DATE_CONSULTATION) = "'.$ANNEE.'"'); 
                            if ($plafond['PLAFOND_COUVERTURE_HOSP_JOURS'] > $aff_consu_hos['MONTANT']) {
                              $hosaff = 'OK';
                              $clashosaff = '';
                            }
                            else{
                              $hosaff = 'Depass&eacute;';
                              $clashosaff = 'class="bg-danger"';
                            }
                            $aff_consu_lun = $this->Model->getRequeteOne('SELECT SUM(consultation_consultation.MONTANT_A_PAYER) AS MONTANT FROM consultation_consultation WHERE consultation_consultation.ID_MEMBRE = '.$selected['ID_MEMBRE'].' AND ID_CONSULTATION_TYPE = 3 AND YEAR(consultation_consultation.DATE_CONSULTATION) = "'.$ANNEE.'"'); 
                            if ($plafond['PLAFOND_LUNETTE'] > $aff_consu_lun['MONTANT']) {
                              $hoslun = 'OK';
                              $clashoslun = '';
                            }
                            else{
                              $hoslun = 'Depass&eacute;';
                              $clashoslun = 'class="bg-danger"';
                            }

                            $aff_consu_mont = $this->Model->getRequeteOne('SELECT SUM(consultation_consultation.MONTANT_A_PAYER) AS MONTANT FROM consultation_consultation WHERE consultation_consultation.ID_MEMBRE = '.$selected['ID_MEMBRE'].' AND ID_CONSULTATION_TYPE = 7 AND YEAR(consultation_consultation.DATE_CONSULTATION) = "'.$ANNEE.'"'); 
                            if ($plafond['PLAFOND_LUNETTE'] > $aff_consu_mont['MONTANT']) {
                              $hoslmont = 'OK';
                              $clashosmont = '';
                            }
                            else{
                              $hoslmont = 'Depass&eacute;';
                              $clashosmont = 'class="bg-danger"';
                            }

                            $aff_consu_prod = $this->Model->getRequeteOne('SELECT SUM(consultation_consultation.MONTANT_A_PAYER) AS MONTANT FROM consultation_consultation WHERE consultation_consultation.ID_MEMBRE = '.$selected['ID_MEMBRE'].' AND ID_CONSULTATION_TYPE = 4 AND YEAR(consultation_consultation.DATE_CONSULTATION) = "'.$ANNEE.'"'); 
                            if ($plafond['PLAFOND_PROTHESES_DENTAIRES'] > $aff_consu_prod['MONTANT']) {
                              $hosprod = 'OK';
                              $clasprod = '';
                            }
                            else{
                              $hosprod = 'Depass&eacute;';
                              $clasprod = 'class="bg-danger"';
                            }

                            $aff_consu_ces = $this->Model->getRequeteOne('SELECT SUM(consultation_consultation.MONTANT_A_PAYER) AS MONTANT FROM consultation_consultation WHERE consultation_consultation.ID_MEMBRE = '.$selected['ID_MEMBRE'].' AND ID_CONSULTATION_TYPE = 8 AND YEAR(consultation_consultation.DATE_CONSULTATION) = "'.$ANNEE.'"'); 
                            if ($plafond['PLAFOND_CESARIENNE'] > $aff_consu_ces['MONTANT']) {
                              $hoscesa = 'OK';
                              $clascesa = '';
                            }
                            else{
                              $hoscesa = 'Depass&eacute;';
                              $clascesa = 'class="bg-danger"';
                            }

                            $aff_consu_scan = $this->Model->getRequeteOne('SELECT SUM(consultation_consultation.MONTANT_A_PAYER) AS MONTANT FROM consultation_consultation WHERE consultation_consultation.ID_MEMBRE = '.$selected['ID_MEMBRE'].' AND ID_CONSULTATION_TYPE = 9 AND YEAR(consultation_consultation.DATE_CONSULTATION) = "'.$ANNEE.'"'); 
                            if ($plafond['PLAFOND_SCANNER'] > $aff_consu_scan['MONTANT']) {
                              $hosscan = 'OK';
                              $classcan = '';
                            }
                            else{
                              $hosscan = 'Depass&eacute;';
                              $classcan = 'class="bg-danger"';
                            }

                            $aff_med_scan = $this->Model->getRequeteOne('SELECT SUM(consultation_medicament.MONTANT_A_PAYE_MIS) AS MONTANT FROM consultation_medicament WHERE consultation_medicament.ID_MEMBRE = '.$selected['ID_MEMBRE'].' AND YEAR(consultation_medicament.DATE_CONSULTATION) = "'.$ANNEE.'"'); 
                            if ($plafond['PLAFOND_PHARMACEUTICAL'] > $aff_med_scan['MONTANT']) {
                              $hossmeda = 'OK';
                              $clasmed = '';
                            }
                            else{
                              $hossmeda = 'Depass&eacute;';
                              $clasmed = 'class="bg-danger"';
                            }

                            ?>
                            <tr>
                              <td><?php echo $selected['NOM'].' '.$selected['PRENOM']?> (A)</td>
                              <td>Hospitalisation</td>
                              <td class="text-right"><?php echo number_format($plafond['PLAFOND_COUVERTURE_HOSP_JOURS'],0,' ',' ')?></td>
                              <td class="text-right"><?php echo number_format($aff_consu_hos['MONTANT'],0,' ',' ')?></td>
                              <td <?php echo $clashosaff;?>><?php echo $hosaff?></td>
                            </tr>
                            <tr>
                              <td><?php echo $selected['NOM'].' '.$selected['PRENOM']?> (A)</td>
                              <td>Lunette</td>
                              <td class="text-right"><?php echo number_format($plafond['PLAFOND_LUNETTE'],0,' ',' ')?></td>
                              <td class="text-right"><?php echo number_format($aff_consu_lun['MONTANT'],0,' ',' ')?></td>
                              <td <?php echo $clashoslun;?>><?php echo $hoslun?></td>
                            </tr>
                            <tr>
                            <td><?php echo $selected['NOM'].' '.$selected['PRENOM']?> (A)</td>
                              <td>Monture</td>
                              <td class="text-right"><?php echo number_format($plafond['PLAFOND_MONTURES'],0,' ',' ')?></td>
                              <td class="text-right"><?php echo number_format($aff_consu_mont['MONTANT'],0,' ',' ')?></td>
                              <td <?php echo $clashosmont;?>><?php echo $hoslmont?></td>
                            </tr>
                            <tr>
                              <td><?php echo $selected['NOM'].' '.$selected['PRENOM']?> (A)</td>
                              <td>Prothese dentaire</td>
                              <td class="text-right"><?php echo number_format($plafond['PLAFOND_PROTHESES_DENTAIRES'],0,' ',' ')?></td>
                              <td class="text-right"><?php echo number_format($aff_consu_prod['MONTANT'],0,' ',' ')?></td>
                              <td <?php echo $clasprod;?>><?php echo $hosprod?></td>
                            </tr>
                            <tr>
                              <td><?php echo $selected['NOM'].' '.$selected['PRENOM']?> (A)</td>
                              <td>Medicament</td>
                              <td class="text-right"><?php echo number_format($plafond['PLAFOND_PHARMACEUTICAL'],0,' ',' ')?></td>
                              <td class="text-right"><?php echo number_format($aff_med_scan['MONTANT'],0,' ',' ')?></td>
                              <td <?php echo $clasmed;?>><?php echo $hossmeda?></td>
                            </tr>
                            
                            <tr>
                              <td><?php echo $selected['NOM'].' '.$selected['PRENOM']?> (A)</td>
                              <td>Cesarienne</td>
                              <td class="text-right"><?php echo number_format($plafond['PLAFOND_CESARIENNE'],0,' ',' ')?></td>
                              <td class="text-right"><?php echo number_format($aff_consu_ces['MONTANT'],0,' ',' ')?></td>
                              <td <?php echo $clascesa;?>><?php echo $hoscesa?></td>
                            </tr>
                            
                            <tr>
                              <td><?php echo $selected['NOM'].' '.$selected['PRENOM']?> (A)</td>
                              <td>Scanner</td>
                              <td class="text-right"><?php echo number_format($plafond['PLAFOND_SCANNER'],0,' ',' ')?></td>
                              <td class="text-right"><?php echo number_format($aff_consu_scan['MONTANT'],0,' ',' ')?></td>
                              <td <?php echo $classcan;?>><?php echo $hosscan?></td>
                            </tr>
                            <?php
$ayantdroit = $this->Model->getRequete('SELECT ID_MEMBRE, NOM, PRENOM FROM `membre_membre` WHERE `CODE_PARENT` = '.$selected['ID_MEMBRE'].''); 
// print_r($ayantdroit);
foreach ($ayantdroit as $ayant) {

  $aya_consu_hos = $this->Model->getRequeteOne('SELECT SUM(consultation_consultation.MONTANT_A_PAYER) AS MONTANT FROM consultation_consultation WHERE consultation_consultation.ID_MEMBRE = '.$ayant['ID_MEMBRE'].' AND TYPE_AFFILIE = '.$selected['ID_MEMBRE'].' AND ID_CONSULTATION_TYPE = 6 AND YEAR(consultation_consultation.DATE_CONSULTATION) = "'.$ANNEE.'"'); 
  if ($plafond['PLAFOND_COUVERTURE_HOSP_JOURS'] > $aya_consu_hos['MONTANT']) {
    $hosayant = 'OK';
    $clashosayant = '';
  }
  else{
    $hosayant = 'Depass&eacute;';
    $clashosayant = 'class="bg-danger"';
  }

  $aya_consu_lun = $this->Model->getRequeteOne('SELECT SUM(consultation_consultation.MONTANT_A_PAYER) AS MONTANT FROM consultation_consultation WHERE consultation_consultation.ID_MEMBRE = '.$ayant['ID_MEMBRE'].' AND TYPE_AFFILIE = '.$selected['ID_MEMBRE'].' AND ID_CONSULTATION_TYPE = 3 AND YEAR(consultation_consultation.DATE_CONSULTATION) = "'.$ANNEE.'"'); 
  if ($plafond['PLAFOND_LUNETTE'] > $aya_consu_lun['MONTANT']) {
    $hosayantlunette = 'OK';
    $clashosayantlunette = '';
  }
  else{
    $hosayantlunette = 'Depass&eacute;';
    $clashosayantlunette = 'class="bg-danger"';
  }

  $aya_consu_mont = $this->Model->getRequeteOne('SELECT SUM(consultation_consultation.MONTANT_A_PAYER) AS MONTANT FROM consultation_consultation WHERE consultation_consultation.ID_MEMBRE = '.$ayant['ID_MEMBRE'].' AND TYPE_AFFILIE = '.$selected['ID_MEMBRE'].' AND ID_CONSULTATION_TYPE = 7 AND YEAR(consultation_consultation.DATE_CONSULTATION) = "'.$ANNEE.'"'); 
  if ($plafond['PLAFOND_MONTURES'] > $aya_consu_mont['MONTANT']) {
    $hosayantmontu = 'OK';
    $clashosayantmontu = '';
  }
  else{
    $hosayantmontu = 'Depass&eacute;';
    $clashosayantmontu = 'class="bg-danger"';
  }

  $aya_consu_prothez = $this->Model->getRequeteOne('SELECT SUM(consultation_consultation.MONTANT_A_PAYER) AS MONTANT FROM consultation_consultation WHERE consultation_consultation.ID_MEMBRE = '.$ayant['ID_MEMBRE'].' AND TYPE_AFFILIE = '.$selected['ID_MEMBRE'].' AND ID_CONSULTATION_TYPE = 4 AND YEAR(consultation_consultation.DATE_CONSULTATION) = "'.$ANNEE.'"'); 
  if ($plafond['PLAFOND_PROTHESES_DENTAIRES'] > $aya_consu_prothez['MONTANT']) {
    $hosayantprot = 'OK';
    $clashosayantprot = '';
  }
  else{
    $hosayantprot = 'Depass&eacute;';
    $clashosayantprot = 'class="bg-danger"';
  }

  $aya_consu_cesa = $this->Model->getRequeteOne('SELECT SUM(consultation_consultation.MONTANT_A_PAYER) AS MONTANT FROM consultation_consultation WHERE consultation_consultation.ID_MEMBRE = '.$ayant['ID_MEMBRE'].' AND TYPE_AFFILIE = '.$selected['ID_MEMBRE'].' AND ID_CONSULTATION_TYPE = 8 AND YEAR(consultation_consultation.DATE_CONSULTATION) = "'.$ANNEE.'"'); 
  if ($plafond['PLAFOND_CESARIENNE'] > $aya_consu_cesa['MONTANT']) {
    $hosayantcesa = 'OK';
    $clashosayantcesa = '';
  }
  else{
    $hosayantcesa = 'Depass&eacute;';
    $clashosayantcesa = 'class="bg-danger"';
  }

  $aya_consu_scan = $this->Model->getRequeteOne('SELECT SUM(consultation_consultation.MONTANT_A_PAYER) AS MONTANT FROM consultation_consultation WHERE consultation_consultation.ID_MEMBRE = '.$ayant['ID_MEMBRE'].' AND TYPE_AFFILIE = '.$selected['ID_MEMBRE'].' AND ID_CONSULTATION_TYPE = 9 AND YEAR(consultation_consultation.DATE_CONSULTATION) = "'.$ANNEE.'"'); 
  if ($plafond['PLAFOND_CESARIENNE'] > $aya_consu_scan['MONTANT']) {
    $hosayantscan = 'OK';
    $clashosayantscan = '';
  }
  else{
    $hosayantscan = 'Depass&eacute;';
    $clashosayantscan = 'class="bg-danger"';
  }

  $ayant_med_scan = $this->Model->getRequeteOne('SELECT SUM(consultation_medicament.MONTANT_A_PAYE_MIS) AS MONTANT FROM consultation_medicament WHERE TYPE_AFFILIE = '.$selected['ID_MEMBRE'].' AND consultation_medicament.ID_MEMBRE = '.$ayant['ID_MEMBRE'].' AND YEAR(consultation_medicament.DATE_CONSULTATION) = "'.$ANNEE.'"'); 
  if ($plafond['PLAFOND_PHARMACEUTICAL'] > $ayant_med_scan['MONTANT']) {
        $hossmedayant = 'OK';
        $clasmedayant = '';
  }
  else{
        $hossmedayant = 'Depass&eacute;';
        $clasmedayant = 'class="bg-danger"';
  }
  
  echo'<tr>
  <td>'.$ayant['NOM'].' '.$ayant['PRENOM'].'</td>
  <td>Hospitalisation</td>
  <td class="text-right">'.number_format($plafond['PLAFOND_COUVERTURE_HOSP_JOURS'],0,' ',' ').'</td>
  <td class="text-right">'.number_format($aya_consu_hos['MONTANT'],0,' ',' ').'</td>
  <td '.$clashosayant.'>'.$hosayant.'</td>
  
  </tr>';
  echo'<tr>
  <td>'.$ayant['NOM'].' '.$ayant['PRENOM'].'</td>
  <td>Lunette</td>
  <td class="text-right">'.number_format($plafond['PLAFOND_LUNETTE'],0,' ',' ').'</td>
  <td class="text-right">'.number_format($aya_consu_lun['MONTANT'],0,' ',' ').'</td>
  <td '.$clashosayantlunette.'>'.$hosayantlunette.'</td>
  </tr>';
  echo'<tr>
  <td>'.$ayant['NOM'].' '.$ayant['PRENOM'].'</td>
  <td>Monture</td>
  <td class="text-right">'.number_format($plafond['PLAFOND_MONTURES'],0,' ',' ').'</td>
  <td class="text-right">'.number_format($aya_consu_mont['MONTANT'],0,' ',' ').'</td>
  <td '.$clashosayantmontu.'>'.$hosayantmontu.'</td>     
  </tr>';
  echo'<tr>
  <td>'.$ayant['NOM'].' '.$ayant['PRENOM'].'</td>
  <td>Prothese dentaire	</td>
  <td class="text-right">'.number_format($plafond['PLAFOND_PROTHESES_DENTAIRES'],0,' ',' ').'</td>
  <td class="text-right">'.number_format($aya_consu_prothez['MONTANT'],0,' ',' ').'</td>
  <td '.$clashosayantprot.'>'.$hosayantprot.'</td>
  </tr>';
  echo'<tr>
  <td>'.$ayant['NOM'].' '.$ayant['PRENOM'].'</td>
  <td>Medicament</td>
  <td class="text-right">'.number_format($plafond['PLAFOND_PHARMACEUTICAL'],0,' ',' ').'</td>
  <td class="text-right">'.number_format($ayant_med_scan['MONTANT'],0,' ',' ').'</td>
  <td '.$clasmedayant.'>'.$hossmedayant.'</td>
  </tr>';   
  echo'<tr>
  <td>'.$ayant['NOM'].' '.$ayant['PRENOM'].'</td>
  <td>Cesarienne</td>
  <td class="text-right">'.number_format($plafond['PLAFOND_CESARIENNE'],0,' ',' ').'</td>
  <td class="text-right">'.number_format($aya_consu_cesa['MONTANT'],0,' ',' ').'</td>
  <td '.$clashosayantcesa.'>'.$hosayantcesa.'</td>
  </tr>';   
  echo'<tr>
  <td>'.$ayant['NOM'].' '.$ayant['PRENOM'].'</td>
  <td>Scanner</td>
  <td class="text-right">'.number_format($plafond['PLAFOND_SCANNER'],0,' ',' ').'</td>
  <td class="text-right">'.number_format($aya_consu_scan['MONTANT'],0,' ',' ').'</td>
  <td '.$clashosayantscan.'>'.$hosayantscan.'</td>
  </tr>';
    
}
                            ?>
                   </table>
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-one-messages" role="tabpanel" aria-labelledby="custom-tabs-one-messages-tab">
                     
 <table id="mytable" class="table table-bordered table-striped" style="width:100%">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Date</th>
                <th>Type</th>
                <th>Structure</th>
                <th>Montant</th>
            </tr>
        </thead>
        <tbody>
        <?php
           
          
           foreach ($resultat as $cvaluea) {
           echo '<tr>
           <td>'.$cvaluea['NOM'].' '.$cvaluea['PRENOM'].' ('.$cvaluea['AFFIL'].')</td>
           <td>'.$cvaluea['DATE_CONSULTATION'].'</td>
           <td>'.$cvaluea['DESCRIPTION'].'</td>
           <td>'.$cvaluea['STRUCTURE'].' ('.$cvaluea['ID_TYPE_STRUCTURE'].')</td>
           <td>'.number_format($cvaluea['MONTANT_A_PAYER'],0,',',' ').' ('.$cvaluea['POURCENTAGE_A'].'%) - '.$cvaluea['STATUS_PAIEMENT'].'</td>
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
  $('#mytable').DataTable({
   dom: 'Bfrtlip',
   "paging":   true,
    "ordering": true,
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