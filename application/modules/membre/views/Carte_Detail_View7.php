  <?php
  include VIEWPATH.'includes/new_header.php';
  include VIEWPATH.'includes/new_top_menu.php';
  include VIEWPATH.'includes/new_menu_principal.php';
  ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php
    include 'includes/Menu_Carte.php';
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
                <h3 class="card-title">Détails de la carte</h3>
                <?php
$idcarte = $this->uri->segment(4);
?>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
<?php
               if ($selected['URL_PHOTO'] == null) {
                 $nimag = 'default.jpg';
               }
               else{
                 $nimag = $selected['URL_PHOTO'];
               }

               if (empty($firstayantdroit) || $firstayantdroit['URL_PHOTO'] == null) {
                 $firstnimag = 'default.jpg';
               }
               else{
                 $firstnimag = $firstayantdroit['URL_PHOTO'];
               }

               if (empty($secondayantdroit) || $secondayantdroit['URL_PHOTO'] == null) {
                 $secondnimag = 'default.jpg';
               }
               else{
                 $secondnimag = $secondayantdroit['URL_PHOTO'];
               }

               if (empty($thirdayantdroit) || $thirdayantdroit['URL_PHOTO'] == null) {
                 $thirdnimag = 'default.jpg';
               }
               else{
                 $thirdnimag = $thirdayantdroit['URL_PHOTO'];
               }

               if (empty($fourthayantdroit) || $fourthayantdroit['URL_PHOTO'] == null) {
                 $fourthnimag = 'default.jpg';
               }
               else{
                 $fourthnimag = $fourthayantdroit['URL_PHOTO'];
               }

               
               if (empty($fivehayantdroit) || $fivehayantdroit['URL_PHOTO'] == null) {
                 $fivenimag = 'default.jpg';
               }
               else{
                 $fivenimag = $fivehayantdroit['URL_PHOTO'];
               }

               if (empty($sixhayantdroit) || $sixhayantdroit['URL_PHOTO'] == null) {
                 $sixnimag = 'default.jpg';
               }
               else{
                 $sixnimag = $sixhayantdroit['URL_PHOTO'];
               }

               if (empty($septhayantdroit) || $septhayantdroit['URL_PHOTO'] == null) {
                 $septnimag = 'default.jpg';
               }
               else{
                 $septnimag = $septhayantdroit['URL_PHOTO'];
               }

               if (empty($huitayantdroit) || $huitayantdroit['URL_PHOTO'] == null) {
                $huitnimag = 'default.jpg';
              }
              else{
                $huitnimag = $huitayantdroit['URL_PHOTO'];
              }

              if (empty($neufayantdroit) || $neufayantdroit['URL_PHOTO'] == null) {
                $neufnimag = 'default.jpg';
              }
              else{
                $neufnimag = $neufayantdroit['URL_PHOTO'];
              }

               
               ?>
         <div class="card-body">
        

          <div class="row">
<div class="col-md-6 row">
  <?php 
                  $GSANGUIN = $this->Model->getOne('syst_groupe_sanguin',array('ID_GROUPE_SANGUIN'=>$selected['ID_GROUPE_SANGUIN']));
                  $EMP = $this->Model->getOne('masque_emploi',array('ID_EMPLOI'=>$selected['ID_EMPLOI']));
                  ?>
  <div class="col-md-4 text-center">
    <img src="<?php echo base_url()?>/uploads/benefi_image.png" style="width: 60%; " > 
    <img src="<?php echo base_url()?>/uploads/image_membre/<?php echo $nimag?>" style="width: 60%;" >
  </div>
  <div class="col-md-8">
    <table>
                    <tr>
                      <td style="font-size: 14px">NOM</td>
                      <td>:</td>
                      <td><b><?php echo $selected['NOM'].' '.$selected['PRENOM']?></b></td>
                    </tr>
                    <tr>
                      <td style="font-size: 14px">CNI</td>
                      <td>:</td>
                      <td><b><?php echo $selected['CNI']?></b></td>
                    </tr>

                    <tr>
                      <td style="font-size: 14px">SERVICE</td>
                      <td>:</td>
                      <td><b><?php echo $EMP['DESCRIPTION']?></b></td>
                    </tr>
                    <tr>
                      <td style="font-size: 14px">G/S.</td>
                      <td>:</td>
                      <td><b><?php echo $GSANGUIN['DESCRIPTION']?></b></td>
                    </tr>
                    <tr>
                      <td style="font-size: 14px">ADRESSE</td>
                      <td>:</td>
                      <td><b><?php echo $selected['ADRESSE']?></b></td>
                    </tr>
                    <tr>
                      <td style="font-size: 14px">TEL</td>
                      <td>:</td>
                      <td><b><?php echo $selected['TELEPHONE']?></b></td>
                    </tr>
                    
                  </table>
  </div>
  <div class="col-md-6  text-right">
    <a class="btn btn-default" href="<?php echo base_url()?>pdf/Carte/index/<?php echo $selected['ID_MEMBRE']?>" target="_blank" role="button">Voir la carte</a>
  </div>
  <div class="col-md-6">
    <?php 
     $uns = $this->Model->getRequeteOne('SELECT * FROM `membre_membre_qr` WHERE ID_MEMBRE = '.$selected['ID_MEMBRE'].'');
     if ($uns['IS_TAKEN']==0) {    
    ?>
      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalfirst">Signaler que elle a été prise</button>
      <?php
      }
      ?>
     
<div class="modal fade" id="modalfirst" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Confirmation</h4>
      </div>
      <div class="modal-body">
        Confimez vous que <?php echo $selected['NOM'].' '.$selected['PRENOM']?> a pris sa carte?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <a class="btn btn-success" href="<?php echo base_url('membre/Carte/carte_taken/'.$selected['ID_MEMBRE'].'/'.$idcarte)?>" role="button">Enregistrer</a>
      </div>
    </div>
  </div>
</div>
  </div>
</div>

<?php
              if (!is_null($firstayantdroit)) {
                ?>
<div class="col-md-6 row">
<div class="col-md-4 text-center">
  <?php
                    if ($firstayantdroit['IS_CONJOINT'] == 1) { ?>
                      <img src="<?php echo base_url()?>/uploads/conjoint.png" style="width: 60%;" >
                      <?php
                    }
                    else{
                      ?>
                      <img src="<?php echo base_url()?>/uploads/imgayant.png" style="width: 60%;" >
                      <?php
                    }
                    ?>
    <img src="<?php echo base_url()?>/uploads/image_membre/<?php echo $firstnimag?>" style="width: 60%;" >
  </div>
  <div class="col-md-8">
    <?php 
                  $FGSANGUIN = $this->Model->getOne('syst_groupe_sanguin',array('ID_GROUPE_SANGUIN'=>$firstayantdroit['ID_GROUPE_SANGUIN']));
                  ?>
                  <table>
                    <tr>
                      <td>NOM</td>
                      <td>:</td>
                      <td  style="width: 130px;"><b><?php echo $firstayantdroit['NOM'].' '.$firstayantdroit['PRENOM']?></b></td>
                    </tr>
                    <tr>
                      <td>G/S.</td>
                      <td>:</td>
                      <td><b><?php echo $FGSANGUIN['DESCRIPTION'];?></b></td>
                    </tr>
                    <tr>
                      <td>NAISSANCE</td>
                      <td>:</td>
                      <td><b><?php 
                        $newDates1 = date("d-m-Y", strtotime($firstayantdroit['DATE_NAISSANCE']));
                        echo  $newDates1;
                      ?></b></td>
                    </tr>
                  </table>
  </div>
  <div class="col-md-6 text-right">
    <a class="btn btn-default" href="<?php echo base_url()?>pdf/Carte/index/<?php echo $firstayantdroit['ID_MEMBRE']?>" target="_blank" role="button">Voir la carte</a>

  </div>
  <div class="col-md-6">

    <?php 
     $deuxs = $this->Model->getRequeteOne('SELECT * FROM `membre_membre_qr` WHERE ID_MEMBRE = '.$firstayantdroit['ID_MEMBRE'].'');
     if ($deuxs['IS_TAKEN']==0) {    
    ?>
      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalsecond">Signaler que elle a été prise</button>
      <?php
      }
      ?>
    

<div class="modal fade" id="modalsecond" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Confirmation</h4>
      </div>
      <div class="modal-body">
        Confimez vous que <?php echo $firstayantdroit['NOM'].' '.$firstayantdroit['PRENOM']?> a pris sa carte?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <a class="btn btn-success" href="<?php echo base_url('membre/Carte/carte_taken/'.$firstayantdroit['ID_MEMBRE'].'/'.$idcarte)?>" role="button">Enregistrer</a>
      </div>
    </div>
  </div>
</div>
  </div>
  </div>
                <?php
              }
                ?>

                 <?php
              if (!is_null($secondayantdroit)) {
                ?>
<div class="col-md-6 row">
<div class="col-md-4 text-center">
  <?php
                    if ($secondayantdroit['IS_CONJOINT'] == 1) { ?>
                      <img src="<?php echo base_url()?>/uploads/conjoint.png" style="width: 60%;" >
                      <?php
                    }
                    else{
                      ?>
                      <img src="<?php echo base_url()?>/uploads/imgayant.png" style="width: 60%;" >
                      <?php
                    }
                    ?>
                  <img src="<?php echo base_url()?>/uploads/image_membre/<?php echo $secondnimag?>" style="width: 60%;" >
</div>
<div class="col-md-6">
  <?php 
                  $SGSANGUIN = $this->Model->getOne('syst_groupe_sanguin',array('ID_GROUPE_SANGUIN'=>$secondayantdroit['ID_GROUPE_SANGUIN']));
                  ?><br>
                  <table>
                    <tr>
                      <td>NOM</td>
                      <td>:</td>
                      <td style="width: 130px;"><b><?php echo $secondayantdroit['NOM'].' '.$secondayantdroit['PRENOM']?></b></td>
                    </tr>
                    <tr>
                      <td>G/S.</td>
                      <td>:</td>
                      <td><b><?php echo $SGSANGUIN['DESCRIPTION'];?></b></td>
                    </tr>
                    <tr>
                      <td>NAISSANCE</td>
                      <td>:</td>
                      <td><b><?php 
                        $newDates1 = date("d-m-Y", strtotime($secondayantdroit['DATE_NAISSANCE']));
                        echo  $newDates1;
                      ?></b></td>
                    </tr>
                  </table>
</div>
<div class="col-md-6 text-right">
  <a class="btn btn-default" href="<?php echo base_url()?>pdf/Carte/index/<?php echo $secondayantdroit['ID_MEMBRE']?>" target="_blank" role="button">Voir la carte</a>
</div>
<div class="col-md-6">
  <?php 
     $trois = $this->Model->getRequeteOne('SELECT * FROM `membre_membre_qr` WHERE ID_MEMBRE = '.$secondayantdroit['ID_MEMBRE'].'');
     if ($trois['IS_TAKEN']==0) {    
    ?>
      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modaltroisieme">Signaler que elle a été prise</button>
      <?php
      }
      ?>

<div class="modal fade" id="modaltroisieme" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Confirmation</h4>
      </div>
      <div class="modal-body">
        Confimez vous que <?php echo $secondayantdroit['NOM'].' '.$secondayantdroit['PRENOM']?> a pris sa carte?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <a class="btn btn-success" href="<?php echo base_url('membre/Carte/carte_taken/'.$secondayantdroit['ID_MEMBRE'].'/'.$idcarte)?>" role="button">Enregistrer</a>
      </div>
    </div>
  </div>
</div>
</div>
</div>
                <?php
              }
              ?>

 <?php
              if (!is_null($thirdayantdroit)) {
                ?>
<div class="col-md-6 row">
  <div class="col-md-4">
    <?php
                    if ($thirdayantdroit['IS_CONJOINT'] == 1) { ?>
                      <img src="<?php echo base_url()?>/uploads/conjoint.png" style="width: 60%;" >
                      <?php
                    }
                    else{
                      ?>
                      <img src="<?php echo base_url()?>/uploads/imgayant.png" style="width: 60%;" >
                      <?php
                    }
                    ?>
                  <img src="<?php echo base_url()?>/uploads/image_membre/<?php echo $thirdnimag?>" style="width: 60%;" >
  </div>
  <div class="col-md-8">
    <?php 
                  $TRGSANGUIN = $this->Model->getOne('syst_groupe_sanguin',array('ID_GROUPE_SANGUIN'=>$thirdayantdroit['ID_GROUPE_SANGUIN']));

                  ?>
                  <table>
                    <tr>
                      <td>NOM</td>
                      <td>:</td>
                      <td style="width: 150px;"><b><?php echo $thirdayantdroit['NOM'].' '.$thirdayantdroit['PRENOM']?></b></td>
                    </tr>
                    <tr>
                      <td>G/S.</td>
                      <td>:</td>
                      <td><b><?php echo $TRGSANGUIN['DESCRIPTION'];?></b></td>
                    </tr>
                    <tr>
                      <td>NAISSANCE</td>
                      <td>:</td>
                      <td><b><?php 
                        $newDates2 = date("d-m-Y", strtotime($thirdayantdroit['DATE_NAISSANCE']));
                        echo  $newDates2;
                      ?></b></td>
                    </tr>
                  </table>
  </div>
  <div class="col-md-6 text-right">
    <a class="btn btn-default" href="<?php echo base_url()?>pdf/Carte/index/<?php echo $thirdayantdroit['ID_MEMBRE']?>" target="_blank" role="button">Voir la carte</a>
  </div>
  <div class="col-md-6">

    <?php 
     $quatres = $this->Model->getRequeteOne('SELECT * FROM `membre_membre_qr` WHERE ID_MEMBRE = '.$thirdayantdroit['ID_MEMBRE'].'');
     if ($quatres['IS_TAKEN']==0) {    
    ?>
      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modaltroisiemes">Signaler que elle a été prise</button>
      <?php
      }
      ?>
    

<div class="modal fade" id="modaltroisiemes" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Confirmation</h4>
      </div>
      <div class="modal-body">
        Confimez vous que <?php echo $thirdayantdroit['NOM'].' '.$thirdayantdroit['PRENOM']?> a pris sa carte?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <a class="btn btn-success" href="<?php echo base_url('membre/Carte/carte_taken/'.$thirdayantdroit['ID_MEMBRE'].'/'.$idcarte)?>" role="button">Enregistrer</a>
      </div>
    </div>
  </div>
</div>
  </div>
</div>
<?php } ?>

<?php
              if (!is_null($fourthayantdroit)) {
                ?>
<div class="col-md-6 row">
  <div class="col-md-4">
    <?php
                    if ($fourthayantdroit['IS_CONJOINT'] == 1) { ?>
                      <img src="<?php echo base_url()?>/uploads/conjoint.png" style="width: 60%;" >
                      <?php
                    }
                    else{
                      ?>
                      <img src="<?php echo base_url()?>/uploads/imgayant.png" style="width: 60%;" >
                      <?php
                    }
                    ?>
                  <img src="<?php echo base_url()?>/uploads/image_membre/<?php echo $fourthnimag?>" style="width: 60%;" >
  </div>
  <div class="col-md-8">
    <?php 
                  $FOGSANGUIN = $this->Model->getOne('syst_groupe_sanguin',array('ID_GROUPE_SANGUIN'=>$fourthayantdroit['ID_GROUPE_SANGUIN']));
                  ?>
                  <table>
                    <tr>
                      <td>NOM</td>
                      <td>:</td>
                      <td style="width: 150px;"><b><?php echo $fourthayantdroit['NOM'].' '.$fourthayantdroit['PRENOM']?></b></td>
                    </tr>
                    <tr>
                      <td>G/S.</td>
                      <td>:</td>
                      <td><b><?php echo $FOGSANGUIN['DESCRIPTION'];?></b></td>
                    </tr>
                    <tr>
                      <td>NAISSANCE</td>
                      <td>:</td>
                      <td><b><?php 
                        $newDates3 = date("d-m-Y", strtotime($fourthayantdroit['DATE_NAISSANCE']));
                        echo  $newDates3;
                      ?></b></td>
                    </tr>
                  </table>
  </div>
  <div class="col-md-6 text-right">
  <a class="btn btn-default" href="<?php echo base_url()?>pdf/Carte/index/<?php echo $fourthayantdroit['ID_MEMBRE']?>" target="_blank" role="button">Voir la carte</a>
</div>
<div class="col-md-6">
  <?php 
     $cinques = $this->Model->getRequeteOne('SELECT * FROM `membre_membre_qr` WHERE ID_MEMBRE = '.$fourthayantdroit['ID_MEMBRE'].'');
     if ($cinques['IS_TAKEN']==0) {    
    ?>
      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalquatriem">Signaler que elle a été prise</button>
      <?php
      }
      ?>
  

<div class="modal fade" id="modalquatriem" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Confirmation</h4>
      </div>
      <div class="modal-body">
        Confimez vous que <?php echo $fourthayantdroit['NOM'].' '.$fourthayantdroit['PRENOM']?> a pris sa carte?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <a class="btn btn-success" href="<?php echo base_url('membre/Carte/carte_taken/'.$fourthayantdroit['ID_MEMBRE'].'/'.$idcarte)?>" role="button">Enregistrer</a>
      </div>
    </div>
  </div>
</div>

</div>
</div>

              <?php }?>

              <?php
              if (!is_null($fivehayantdroit)) {
                ?>
<div class="col-md-6 row">
  <div class="col-md-4">
    <?php
                    if ($fivehayantdroit['IS_CONJOINT'] == 1) { ?>
                      <img src="<?php echo base_url()?>/uploads/conjoint.png" style="width : 60%" >
                      <?php
                    }
                    else{
                      ?>
                      <img src="<?php echo base_url()?>/uploads/imgayant.png" style="width : 60%" >
                      <?php
                    }
                    ?>
                  <img src="<?php echo base_url()?>/uploads/image_membre/<?php echo $fivenimag?>" style="width : 60%" >
  </div>
  <div class="col-md-8">
    <?php 
                  $SIXGSANGUIN = $this->Model->getOne('syst_groupe_sanguin',array('ID_GROUPE_SANGUIN'=>$fivehayantdroit['ID_GROUPE_SANGUIN']));
                  ?>
                  <table>
                    <tr>
                      <td>NOM</td>
                      <td>:</td>
                      <td style="width: 150px;"><b><?php echo $fivehayantdroit['NOM'].' '.$fivehayantdroit['PRENOM']?></b></td>
                    </tr>
                    <tr>
                      <td>G/S.</td>
                      <td>:</td>
                      <td><b><?php echo $SIXGSANGUIN['DESCRIPTION'];?></b></td>
                    </tr>
                    <tr>
                      <td>NAISSANCE</td>
                      <td>:</td>
                      <!-- <td><?php echo $fourthayantdroit['DATE_NAISSANCE']?></td> -->
                      <td><b><?php 
                        $newDates4 = date("d-m-Y", strtotime($fivehayantdroit['DATE_NAISSANCE']));
                        echo  $newDates4;
                      ?></b></td>
                    </tr>
                  </table>
  </div>
  <div class="col-md-6 text-right">
    <a class="btn btn-default" href="<?php echo base_url()?>pdf/Carte/index/<?php echo $fivehayantdroit['ID_MEMBRE']?>" target="_blank" role="button">Voir la carte</a>
  </div>
  <div class="col-md-6">

    <?php 
     $sixs = $this->Model->getRequeteOne('SELECT * FROM `membre_membre_qr` WHERE ID_MEMBRE = '.$fivehayantdroit['ID_MEMBRE'].'');
     if ($sixs['IS_TAKEN']==0) {    
    ?>
      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalcinque">Signaler que elle a été prise</button>
      <?php
      }
      ?>
    

<div class="modal fade" id="modalcinque" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Confirmation</h4>
      </div>
      <div class="modal-body">
        Confimez vous que <?php echo $fivehayantdroit['NOM'].' '.$fivehayantdroit['PRENOM']?> a pris sa carte?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <a class="btn btn-success" href="<?php echo base_url('membre/Carte/carte_taken/'.$fivehayantdroit['ID_MEMBRE'].'/'.$idcarte)?>" role="button">Enregistrer</a>
      </div>
    </div>
  </div>
</div>
  </div>
</div>
              <?php }?>
  <?php
              if (!is_null($sixhayantdroit)) {
                ?>
<div class="col-md-6 row">
  <div class="col-md-4">
    <?php
                    if ($sixhayantdroit['IS_CONJOINT'] == 1) { ?>
                      <img src="<?php echo base_url()?>/uploads/conjoint.png" style="width: 60%;" >
                      <?php
                    }
                    else{
                      ?>
                      <img src="<?php echo base_url()?>/uploads/imgayant.png" style="width: 60%;" >
                      <?php
                    }
                    ?>
                  <img src="<?php echo base_url()?>/uploads/image_membre/<?php echo $sixnimag?>" style="width: 60%;" >  
  </div>
  <div class="col-md-8">
    <?php 
                  $SIXGSANGUINS = $this->Model->getOne('syst_groupe_sanguin',array('ID_GROUPE_SANGUIN'=>$sixhayantdroit['ID_GROUPE_SANGUIN']));
                  ?>
                  <table>
                    <tr>
                      <td>NOM</td>
                      <td>:</td>
                      <td style="width: 150px;"><b><?php echo $sixhayantdroit['NOM'].' '.$sixhayantdroit['PRENOM']?></b></td>
                    </tr>
                    <tr>
                      <td>G/S.</td>
                      <td>:</td>
                      <td><b><?php echo $SIXGSANGUINS['DESCRIPTION'];?></b></td>
                    </tr>
                    <tr>
                      <td>NAISSANCE</td>
                      <td>:</td>
                      <td><b><?php 
                        $newDates5 = date("d-m-Y", strtotime($sixhayantdroit['DATE_NAISSANCE']));
                        echo  $newDates5;
                      ?></b></td>
                    </tr>
                  </table>
  </div>
  <div class="col-md-6 text-right">
    <a class="btn btn-default" href="<?php echo base_url()?>pdf/Carte/index/<?php echo $sixhayantdroit['ID_MEMBRE']?>" target="_blank" role="button">Voir la carte</a>
  </div>
  <div class="col-md-6">
    <?php 
     $septs = $this->Model->getRequeteOne('SELECT * FROM `membre_membre_qr` WHERE ID_MEMBRE = '.$sixhayantdroit['ID_MEMBRE'].'');
     if ($septs['IS_TAKEN']==0) {    
    ?>
      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalsixs">Signaler que elle a été prise</button>
      <?php
      }
      ?>
    

<div class="modal fade" id="modalsixs" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Confirmation</h4>
      </div>
      <div class="modal-body">
        Confimez vous que <?php echo $sixhayantdroit['NOM'].' '.$sixhayantdroit['PRENOM']?> a pris sa carte?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <a class="btn btn-success" href="<?php echo base_url('membre/Carte/carte_taken/'.$sixhayantdroit['ID_MEMBRE'].'/'.$idcarte)?>" role="button">Enregistrer</a>
      </div>
    </div>
  </div>
</div>
  </div>
  </div> 
              <?php } ?>
              <?php
              if (!is_null($septhayantdroit)) {
                ?>
<div class="col-md-6 row">
  <div class="col-md-4">
    <?php
                    if ($septhayantdroit['IS_CONJOINT'] == 1) { ?>
                      <img src="<?php echo base_url()?>/uploads/conjoint.png" style="width: 60%;" >
                      <?php
                    }
                    else{
                      ?>
                      <img src="<?php echo base_url()?>/uploads/imgayant.png" style="width: 60%;" >
                      <?php
                    }
                    ?>
                  <img src="<?php echo base_url()?>/uploads/image_membre/<?php echo $septnimag?>" style="width: 60%;" >
  </div>
  <div class="col-md-8">
    <?php 
                  $SETGSANGUIN = $this->Model->getOne('syst_groupe_sanguin',array('ID_GROUPE_SANGUIN'=>$septhayantdroit['ID_GROUPE_SANGUIN']));
                  ?>
                  <table>
                    <tr>
                      <td>NOM</td>
                      <td>:</td>
                      <td style="width: 150px;"><b><?php echo $septhayantdroit['NOM'].' '.$septhayantdroit['PRENOM']?></b></td>
                    </tr>
                    <tr>
                      <td>G/S.</td>
                      <td>:</td>
                      <td><b><?php echo $SETGSANGUIN['DESCRIPTION'];?></b></td>
                    </tr>
                    <tr>
                      <td>NAISSANCE</td>
                      <td>:</td>
                      <td><b><?php 
                        $newDates7 = date("d-m-Y", strtotime($septhayantdroit['DATE_NAISSANCE']));
                        echo  $newDates7;
                      ?></b></td>
                    </tr>
                  </table>
  </div>
  <div class="col-md-6 text-right">
    <a class="btn btn-default" href="<?php echo base_url()?>pdf/Carte/index/<?php echo $septhayantdroit['ID_MEMBRE']?>" target="_blank" role="button">Voir la carte</a>
  </div>
  <div class="col-md-6">
    <?php 
     $huits = $this->Model->getRequeteOne('SELECT * FROM `membre_membre_qr` WHERE ID_MEMBRE = '.$septhayantdroit['ID_MEMBRE'].'');
     if ($huits['IS_TAKEN']==0) {    
    ?>
      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalseven">Signaler que elle a été prise</button>
      <?php
      }
      ?>
    

<div class="modal fade" id="modalseven" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Confirmation</h4>
      </div>
      <div class="modal-body">
        Confimez vous que <?php echo $septhayantdroit['NOM'].' '.$septhayantdroit['PRENOM']?> a pris sa carte?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <a class="btn btn-success" href="<?php echo base_url('membre/Carte/carte_taken/'.$septhayantdroit['ID_MEMBRE'].'/'.$idcarte)?>" role="button">Enregistrer</a>
      </div>
    </div>
  </div>
</div>
  </div>
</div>
              <?php }
               

if (!is_null($huitayantdroit)) {
                ?>
<div class="col-md-6 row">
  <div class="col-md-4">
    <?php
                    if ($huitayantdroit['IS_CONJOINT'] == 1) { ?>
                      <img src="<?php echo base_url()?>/uploads/conjoint.png" style="width: 60%;" >
                      <?php
                    }
                    else{
                      ?>
                      <img src="<?php echo base_url()?>/uploads/imgayant.png" style="width: 60%;" >
                      <?php
                    }
                    ?>
                  <img src="<?php echo base_url()?>/uploads/image_membre/<?php echo $huitnimag?>" style="width: 60%;" >
  </div>
  <div class="col-md-8">
    <?php 
                  $HUIGSANGUIN = $this->Model->getOne('syst_groupe_sanguin',array('ID_GROUPE_SANGUIN'=>$huitayantdroit['ID_GROUPE_SANGUIN']));
                  ?>
                  <table>
                    <tr>
                      <td>NOM</td>
                      <td>:</td>
                      <td style="width: 150px;"><b><?php echo $huitayantdroit['NOM'].' '.$huitayantdroit['PRENOM']?></b></td>
                    </tr>
                    <tr>
                      <td>G/S.</td>
                      <td>:</td>
                      <td><b><?php echo $HUIGSANGUIN['DESCRIPTION'];?></b></td>
                    </tr>
                    <tr>
                      <td>NAISSANCE</td>
                      <td>:</td>
                      <td><b><?php 
                        $newDates7 = date("d-m-Y", strtotime($huitayantdroit['DATE_NAISSANCE']));
                        echo  $newDates7;
                      ?></b></td>
                    </tr>
                  </table>
  </div>
  <div class="col-md-6 text-right">
    <a class="btn btn-default" href="<?php echo base_url()?>pdf/Carte/index/<?php echo $huitayantdroit['ID_MEMBRE']?>" target="_blank" role="button">Voir la carte</a>
  </div>
  <div class="col-md-6">
    <?php 
     $neufss = $this->Model->getRequeteOne('SELECT * FROM `membre_membre_qr` WHERE ID_MEMBRE = '.$huitayantdroit['ID_MEMBRE'].'');
     if ($neufss['IS_TAKEN']==0) {    
    ?>
      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalseven">Signaler que elle a été prise</button>
      <?php
      }
      ?>
    

<div class="modal fade" id="modalseven" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Confirmation</h4>
      </div>
      <div class="modal-body">
        Confimez vous que <?php echo $huitayantdroit['NOM'].' '.$huitayantdroit['PRENOM']?> a pris sa carte?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <a class="btn btn-success" href="<?php echo base_url('membre/Carte/carte_taken/'.$huitayantdroit['ID_MEMBRE'].'/'.$idcarte)?>" role="button">Enregistrer</a>
      </div>
    </div>
  </div>
</div>
  </div>
</div>
              <?php } ?>
<?php
              if (!is_null($neufayantdroit)) {
                ?>
<div class="col-md-6 row">
  <div class="col-md-4">
    <?php
                    if ($neufayantdroit['IS_CONJOINT'] == 1) { ?>
                      <img src="<?php echo base_url()?>/uploads/conjoint.png" style="width: 60%;" >
                      <?php
                    }
                    else{
                      ?>
                      <img src="<?php echo base_url()?>/uploads/imgayant.png" style="width: 60%;" >
                      <?php
                    }
                    ?>
                  <img src="<?php echo base_url()?>/uploads/image_membre/<?php echo $neufnimag?>" style="width: 60%;" >
  </div>
  <div class="col-md-8">
    <?php 
                  $NEUFGSANGUIN = $this->Model->getOne('syst_groupe_sanguin',array('ID_GROUPE_SANGUIN'=>$neufayantdroit['ID_GROUPE_SANGUIN']));
                  ?>
                  <table>
                    <tr>
                      <td>NOM</td>
                      <td>:</td>
                      <td style="width: 150px;"><b><?php echo $neufayantdroit['NOM'].' '.$neufayantdroit['PRENOM']?></b></td>
                    </tr>
                    <tr>
                      <td>G/S.</td>
                      <td>:</td>
                      <td><b><?php echo $NEUFGSANGUIN['DESCRIPTION'];?></b></td>
                    </tr>
                    <tr>
                      <td>NAISSANCE</td>
                      <td>:</td>
                      <td><b><?php 
                        $newDates7 = date("d-m-Y", strtotime($neufayantdroit['DATE_NAISSANCE']));
                        echo  $newDates7;
                      ?></b></td>
                    </tr>
                  </table>
  </div>
  <div class="col-md-6 text-right">
    <a class="btn btn-default" href="<?php echo base_url()?>pdf/Carte/index/<?php echo $neufayantdroit['ID_MEMBRE']?>" target="_blank" role="button">Voir la carte</a>
  </div>
  <div class="col-md-6">
    <?php 
     $dixs = $this->Model->getRequeteOne('SELECT * FROM `membre_membre_qr` WHERE ID_MEMBRE = '.$neufayantdroit['ID_MEMBRE'].'');
     if ($dixs['IS_TAKEN']==0) {    
    ?>
      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalseven">Signaler que elle a été prise</button>
      <?php
      }
      ?>
    

<div class="modal fade" id="modalseven" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Confirmation</h4>
      </div>
      <div class="modal-body">
        Confimez vous que <?php echo $neufayantdroit['NOM'].' '.$neufayantdroit['PRENOM']?> a pris sa carte?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <a class="btn btn-success" href="<?php echo base_url('membre/Carte/carte_taken/'.$neufayantdroit['ID_MEMBRE'].'/'.$idcarte)?>" role="button">Enregistrer</a>
      </div>
    </div>
  </div>
</div>
  </div>
</div>
              <?php } ?>
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