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

               if ($firstayantdroit['URL_PHOTO'] == null) {
                 $firstnimag = 'default.jpg';
               }
               else{
                 $firstnimag = $firstayantdroit['URL_PHOTO'];
               }

               if ($secondayantdroit['URL_PHOTO'] == null) {
                 $secondnimag = 'default.jpg';
               }
               else{
                 $secondnimag = $secondayantdroit['URL_PHOTO'];
               }

               if ($thirdayantdroit['URL_PHOTO'] == null) {
                 $thirdnimag = 'default.jpg';
               }
               else{
                 $thirdnimag = $thirdayantdroit['URL_PHOTO'];
               }

               if ($fourthayantdroit['URL_PHOTO'] == null) {
                 $fourthnimag = 'default.jpg';
               }
               else{
                 $fourthnimag = $fourthayantdroit['URL_PHOTO'];
               }

               if ($fivehayantdroit['URL_PHOTO'] == null) {
                 $fivenimag = 'default.jpg';
               }
               else{
                 $fivenimag = $fivehayantdroit['URL_PHOTO'];
               }
               
               ?>
         <div class="card-body">
         

<!-- <input type="button" onclick="printDiv('printsideA')" value="print a div!" /> -->
          <div class="row">
  <div class="col-md-2 text-center">
    <br><br><br><br><br>
Face A &#9658;
<!-- <a class="btn btn-primary" href="#" role="button">Imprimer la FACE A</a> -->
<input type="button" class="btn btn-primary" onclick="printDiv('printsideA')" value="Imprimer la FACE A" />
  </div>
  <div class="col-md-10" style="width: 21.0cm" id="printsideA">

<div style="width: 830px; height: 490px; border: 0px solid black; margin: auto; padding-top:10px;padding-bottom: 5">

            <div style="width: 414px; height: 485px; float: left; margin: auto; ">
                <div style="width: 419px; height: 240px;  padding-left:70px; ">
                  <div class="text-center" style="width: 110px; height: 240px; float: left; margin-top: 3px ;" >
                  <img src="<?php echo base_url()?>/uploads/benefi_image.png" style="max-height: 50px;  max-width: 1.5cm; margin-bottom: 10px; margin-top: 5px" > 
                  <img src="<?php echo base_url()?>/uploads/image_membre/<?php echo $nimag?>" style="max-height: 140px;  max-width: 2.2cm" >
                  
                </div>
                <!-- <div style="width: 305px; height: 245px; float: right; font-size: 16px;"> -->
                  <div style="width: 220px; height: 245px; float: right; font-size: 14px;">
                  <?php 
                  $GSANGUIN = $this->Model->getOne('syst_groupe_sanguin',array('ID_GROUPE_SANGUIN'=>$selected['ID_GROUPE_SANGUIN']));
                  $EMP = $this->Model->getOne('masque_emploi',array('ID_EMPLOI'=>$selected['ID_EMPLOI']));
                  ?>
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
              </div>
              <!--Fin de la premiere personne et debut de la seconde -->
             
              <div style="width: 419px; height: 245px;  padding-left:70px; ">
                <div style="width: 110px; height: 245px; float: left; ">
                  <br><div class="text-center">
                    <?php
                    if ($firstayantdroit['IS_CONJOINT'] == 1) { ?>
                      <img src="<?php echo base_url()?>/uploads/conjoint.png" style="max-height: 50px;  margin-bottom: 10px;  max-width: 1.5cm" >
                      <?php
                    }
                    else{
                      ?>
                      <img src="<?php echo base_url()?>/uploads/imgayant.png" style="max-height: 50px;  margin-bottom: 10px;  max-width: 1.5cm" >
                      <?php
                    }
                    ?>
                  
                  <img src="<?php echo base_url()?>/uploads/image_membre/<?php echo $firstnimag?>" style="max-height: 140px; max-width: 2.2cm" >  
                  </div>
                  
                </div>
                <!-- <div style="width: 305px; height: 245px; float: right; font-size: 16px;"> -->
                  <div style="width: 220px; height: 245px; float: right; font-size: 14px;">
                  
                  <?php 
                  $FGSANGUIN = $this->Model->getOne('syst_groupe_sanguin',array('ID_GROUPE_SANGUIN'=>$firstayantdroit['ID_GROUPE_SANGUIN']));
                  ?><br><br><br>
                  <table>
                    <tr>
                      <td>NOM</td>
                      <td>:</td>
                      <td><b><?php echo $firstayantdroit['NOM'].' '.$firstayantdroit['PRENOM']?></b></td>
                    </tr>
                    <tr>
                      <td>G/S.</td>
                      <td>:</td>
                      <td><b><?php echo $FGSANGUIN['DESCRIPTION'];?></b></td>
                    </tr>
                    <tr>
                      <td>NAISSANCE</td>
                      <td>:</td>
                      <!-- <td><?php echo $firstayantdroit['DATE_NAISSANCE']?></td> -->
                      <td><b><?php 
                        $newDates1 = date("d-m-Y", strtotime($firstayantdroit['DATE_NAISSANCE']));
                        echo  $newDates1;
                      ?></b></td>
                    </tr>
                  </table>
                   
                </div>
              </div>
              <!--Fin de la seconde personne-->

            </div>

              <div style="width: 414px; height: 490px; float: right;">

                <div class="text-center" style="width: 110px; height: 240px; float: left; padding-left:20px; margin-top: 3px; ">
                
                  <!-- <img src="<?php echo base_url()?>/uploads/imgayant.png" style="max-height: 50px;  margin-bottom: 10px;  max-width: 1.5cm; margin-top: 5px" > -->
                  <?php
                    if ($secondayantdroit['IS_CONJOINT'] == 1) { ?>
                      <img src="<?php echo base_url()?>/uploads/conjoint.png" style="max-height: 50px;  margin-bottom: 10px;  max-width: 1.5cm" >
                      <?php
                    }
                    else{
                      ?>
                      <img src="<?php echo base_url()?>/uploads/imgayant.png" style="max-height: 50px;  margin-bottom: 10px;  max-width: 1.5cm" >
                      <?php
                    }
                    ?>
                  <img src="<?php echo base_url()?>/uploads/image_membre/<?php echo $secondnimag?>" style="max-height: 140px;  max-width: 2.2cm" >

                </div>

                <div style="width: 300px; height: 245px; float: right; font-size: 14px;  ">

                  
                  <?php 
                  $SGSANGUIN = $this->Model->getOne('syst_groupe_sanguin',array('ID_GROUPE_SANGUIN'=>$secondayantdroit['ID_GROUPE_SANGUIN']));
                  ?>
                  <br><br>
                  <table>
                    <tr>
                      <td>NOM</td>
                      <td>:</td>
                      <td><b><?php echo $secondayantdroit['NOM'].' '.$secondayantdroit['PRENOM']?></b></td>
                    </tr>
                    <tr>
                      <td>G/S.</td>
                      <td>:</td>
                      <td><b><?php echo $SGSANGUIN['DESCRIPTION'];?></b></td>
                    </tr>
                    <tr>
                      <td>NAISSANCE</td>
                      <td>:</td>
                      <!-- <td><?php echo $secondayantdroit['DATE_NAISSANCE']?></td> -->
                      <td><b><?php 
                        $newDates2 = date("d-m-Y", strtotime($secondayantdroit['DATE_NAISSANCE']));
                        echo  $newDates2;
                      ?></b></td>
                    </tr>
                  </table>
                </div>
                <!--Debut de la quatrieme personne-->
                <br><div class="text-center" style="width: 110px; height: 245px; float: left;">
                  <!-- <br> -->

                  <!-- <img src="<?php echo base_url()?>/uploads/imgayant.png" style="max-height: 50px;  margin-bottom: 10px; margin-top: 20px;  max-width: 1.5cm" > -->
                  <?php
                    if ($thirdayantdroit['IS_CONJOINT'] == 1) { ?>
                      <img src="<?php echo base_url()?>/uploads/conjoint.png" style="max-height: 50px;  margin-bottom: 10px;  max-width: 1.5cm" >
                      <?php
                    }
                    else{
                      ?>
                      <img src="<?php echo base_url()?>/uploads/imgayant.png" style="max-height: 50px;  margin-bottom: 10px;  max-width: 1.5cm" >
                      <?php
                    }
                    ?>
                  <img src="<?php echo base_url()?>/uploads/image_membre/<?php echo $thirdnimag?>" style="max-height: 140px;  max-width: 2.2cm" >
                </div>

                <div style="width: 301px; height: 245px; float: right; font-size: 14px;">
                  <br><br><br>
                  <?php 
                  $TRGSANGUIN = $this->Model->getOne('syst_groupe_sanguin',array('ID_GROUPE_SANGUIN'=>$thirdayantdroit['ID_GROUPE_SANGUIN']));
                  ?>
                  <table>
                    <tr>
                      <td>NOM</td>
                      <td>:</td>
                      <td><b><?php echo $thirdayantdroit['NOM'].' '.$thirdayantdroit['PRENOM']?></b></td>
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
                        $newDates3 = date("d-m-Y", strtotime($thirdayantdroit['DATE_NAISSANCE']));
                        echo  $newDates3;
                      ?></b></td>
                    </tr>
                  </table>
                </div>
                <!--Fin de la 4 em personne-->
            </div>

          </div>
          <!--Fin de la premiere partie-->

  </div>
          </div>

          <div class="row">
  <div class="col-md-2 text-center">
    <br><br><br><br><br>
Face B &#9658;
<!-- <a class="btn btn-primary" href="#" role="button">Imprimer la FACE B</a> -->
<input type="button" class="btn btn-primary" onclick="printDiv('printsideB')" value="Imprimer la FACE B" />
  </div>
  <div class="col-md-10" style="width: 21.0cm" id="printsideB">
    
     
          <div style="width: 830px; height: 490px;  margin: auto; padding-top:8px;padding-bottom:0">

           
            <div style="width: 414px; height: 485px; float: left; margin: auto; "> 


            <div style="width: 419px; height: 135px;  padding-left:70px;">
                <div style="width: 110px; height: 135px; float: left; ">
                  <div class="text-center">
                  <!-- <img src="<?php echo base_url()?>/uploads/imgayant.png" style="max-height: 50px;  max-width: 1.2cm" > -->
                  <?php
                    if ($fourthayantdroit['IS_CONJOINT'] == 1) { ?>
                      <img src="<?php echo base_url()?>/uploads/conjoint.png" style="max-height: 50px;  margin-bottom: 10px;  max-width: 1.5cm" >
                      <?php
                    }
                    else{
                      ?>
                      <img src="<?php echo base_url()?>/uploads/imgayant.png" style="max-height: 50px;  margin-bottom: 10px;  max-width: 1.5cm" >
                      <?php
                    }
                    ?>
                  <img src="<?php echo base_url()?>/uploads/image_membre/<?php echo $fourthnimag?>" style="max-height: 140px; max-width: 1.8cm" >  
                  </div>
                  
                </div>
                <div style="width: 220px; height: 135px; float: right; font-size: 14px;">
                  
                  <?php 
                  $FOGSANGUIN = $this->Model->getOne('syst_groupe_sanguin',array('ID_GROUPE_SANGUIN'=>$fourthayantdroit['ID_GROUPE_SANGUIN']));
                  ?><br>
                  <table>
                    <tr>
                      <td>NOM</td>
                      <td>:</td>
                      <td><b><?php echo $fourthayantdroit['NOM'].' '.$fourthayantdroit['PRENOM']?></b></td>
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
                        $newDates4 = date("d-m-Y", strtotime($fourthayantdroit['DATE_NAISSANCE']));
                        echo  $newDates4;
                      ?></b></td>
                    </tr>
                  </table>
                   
                </div>
              </div>

              <div style="width: 419px; height: 135px;  padding-left:70px;">
                <div style="width: 110px; height: 135px; float: left;">
                  <div class="text-center">
                  <!-- <img src="<?php echo base_url()?>/uploads/imgayant.png" style="max-height: 50px;   max-width: 1.2cm" > -->
                  <?php
                    if ($fivehayantdroit['IS_CONJOINT'] == 1) { ?>
                      <img src="<?php echo base_url()?>/uploads/conjoint.png" style="max-height: 50px;  margin-bottom: 10px;  max-width: 1.5cm" >
                      <?php
                    }
                    else{
                      ?>
                      <img src="<?php echo base_url()?>/uploads/imgayant.png" style="max-height: 50px;  margin-bottom: 10px;  max-width: 1.5cm" >
                      <?php
                    }
                    ?>
                  <img src="<?php echo base_url()?>/uploads/image_membre/<?php echo $fivenimag?>" style="max-height: 140px; max-width: 1.8cm" >
                  </div>
                  
                </div>
                <div style="width: 220px; height: 135px; float: right; font-size: 14px;">
                  
                  <?php 
                  $SIXGSANGUIN = $this->Model->getOne('syst_groupe_sanguin',array('ID_GROUPE_SANGUIN'=>$fivehayantdroit['ID_GROUPE_SANGUIN']));
                  ?><br>
                  <table>
                    <tr>
                      <td>NOM</td>
                      <td>:</td>
                      <td><b><?php echo $fivehayantdroit['NOM'].' '.$fivehayantdroit['PRENOM']?></b></td>
                    </tr>
                    <tr>
                      <td>G/S.</td>
                      <td>:</td>
                      <td><b><b><?php echo $SIXGSANGUIN['DESCRIPTION'];?></b></td>
                    </tr>
                    <tr>
                      <td>NAISSANCE</td>
                      <td>:</td>
                      <td><b><?php 
                        $newDates5 = date("d-m-Y", strtotime($fivehayantdroit['DATE_NAISSANCE']));
                        echo  $newDates5;
                      ?></b></td>
                    </tr>
                  </table>
                   
                </div>
              </div>

              
              <div style="width: 390px; height: 180px; font-size: 14px;  padding-left:100px!important ; padding-top:0px!important " class="text-center">

                
              <table style="border: 2px solid black">
  <tr style="padding: 2px; border: 2px solid black">
    <td colspan="6" class="text-left" style="padding: 0.5px; border: 2px solid black">CODE: <?php echo $categoriecarte['CODE_CARTE']?></td>
  </tr>
  <tr style="padding: 2px; border: 2px solid black">
    <td rowspan="2" class="text-center" style="padding: 0.5px; border: 2px solid black">Cat&eacute;gorie</td>
    <td colspan="5" class="text-center" style="padding: 0.5px; border: 2px solid black">Couverture MIS Sant&eacute;</td>
  </tr>
  <tr>
    <td colspan="3" class="text-center" style="padding: 0.5px; border: 2px solid black">Soins</td>
    <td colspan="2" class="text-center" style="padding: 0.5px; border: 2px solid black">M&eacute;dicaments</td>
  </tr>
  <tr style="padding: 2px; border: 2px solid black">
    <td rowspan="2" class="text-center"><h2><b><?php echo $categoriecarte['DESCRIPTION']?></b></h2></td>
    <td style="padding: 0px; border: 2px solid black">Type &nbsp; I</td>
    <td style="padding: 0px; border: 2px solid black">Type II</td>
    <td style="padding: 0px; border: 2px solid black">Type III</td>
    <td style="padding: 0px; border: 2px solid black">Géné riques</td>
    <td style="padding: 0px; border: 2px solid black">Spécia lités</td>
  </tr>
  
  
  <tr>
    <td class="text-center" style="padding: 5px; border: 2px solid black">
      <?php
      if ($this->Model->checkvalue('syst_categorie_assurance_type_structure',array('ID_CATEGORIE_ASSURANCE'=>$categoriecarte['ID_CATEGORIE_ASSURANCE'], 'ID_TYPE_STRUCTURE'=>1))) {
        $pourcentage1 = $this->Model->getOne('syst_categorie_assurance_type_structure',array('ID_CATEGORIE_ASSURANCE'=>$categoriecarte['ID_CATEGORIE_ASSURANCE'], 'ID_TYPE_STRUCTURE'=>1));
        echo $pourcentage1['POURCENTAGE'].'%';
        // echo "&#9632;";
      }
      ?>    
    </td>
    <td class="text-center" style="padding: 5px; border: 2px solid black">
      <?php
      if ($this->Model->checkvalue('syst_categorie_assurance_type_structure',array('ID_CATEGORIE_ASSURANCE'=>$categoriecarte['ID_CATEGORIE_ASSURANCE'], 'ID_TYPE_STRUCTURE'=>2))) {
        // echo "&#9632;";
        $pourcentage2 = $this->Model->getOne('syst_categorie_assurance_type_structure',array('ID_CATEGORIE_ASSURANCE'=>$categoriecarte['ID_CATEGORIE_ASSURANCE'], 'ID_TYPE_STRUCTURE'=>2));
        echo $pourcentage2['POURCENTAGE'].'%';
      }
      ?> 
    </td>
    <td class="text-center" style="padding: 5px; border: 2px solid black">
      <?php
      if ($this->Model->checkvalue('syst_categorie_assurance_type_structure',array('ID_CATEGORIE_ASSURANCE'=>$categoriecarte['ID_CATEGORIE_ASSURANCE'], 'ID_TYPE_STRUCTURE'=>3))) {
        // echo "&#9632;";
        $pourcentage3 = $this->Model->getOne('syst_categorie_assurance_type_structure',array('ID_CATEGORIE_ASSURANCE'=>$categoriecarte['ID_CATEGORIE_ASSURANCE'], 'ID_TYPE_STRUCTURE'=>3));
        echo $pourcentage3['POURCENTAGE'].'%';
      }
      ?> 
    </td>
    <td class="text-center" style="padding: 5px; border: 2px solid black">
      <?php
      if ($this->Model->checkvalue('syst_categorie_assurance_medicament',array('ID_CATEGORIE_ASSURANCE'=>$categoriecarte['ID_CATEGORIE_ASSURANCE'], 'ID_COUVERTURE_MEDICAMENT'=>1))) {
        // echo "&#9632;";
        $pourcentage4 = $this->Model->getOne('syst_categorie_assurance_medicament',array('ID_CATEGORIE_ASSURANCE'=>$categoriecarte['ID_CATEGORIE_ASSURANCE'], 'ID_COUVERTURE_MEDICAMENT'=>1));
        echo $pourcentage4['POURCENTAGE'].'%';
      }
      ?> 
    </td>
    <td class="text-center" style="padding: 5px; border: 2px solid black">
      <?php
      if ($this->Model->checkvalue('syst_categorie_assurance_medicament',array('ID_CATEGORIE_ASSURANCE'=>$categoriecarte['ID_CATEGORIE_ASSURANCE'], 'ID_COUVERTURE_MEDICAMENT'=>2))) {
        // echo "&#9632;";
        $pourcentage5 = $this->Model->getOne('syst_categorie_assurance_medicament',array('ID_CATEGORIE_ASSURANCE'=>$categoriecarte['ID_CATEGORIE_ASSURANCE'], 'ID_COUVERTURE_MEDICAMENT'=>2));
        echo $pourcentage5['POURCENTAGE'].'%';
      }
      ?> 
    </td>
  </tr>

  <tr style="padding: 5px; border: 2px solid black">

    <td colspan="3" class="text-center" style="border: 2px solid black">Affiliation: 

      <?php 
      $debuval = date("d-m-Y", strtotime($categoriecarte['DATE_DABUT_VALIDITE']));
                        echo  $debuval;?></td>

    <td colspan="5" class="text-left" style="border: 2px">Validit&eacute;: 
      <?php 
      $finval = date("d-m-Y", strtotime($categoriecarte['DATE_FIN_VALIDITE']));
                        echo  $finval;?></td>

  </tr>
</table>
              </div>

            </div>
            <div class="text-center" style="width: 370px; height: 490px; float: right;position: relative; margin-right: 20px;position: relative; padding-right: 70px">
             <!-- Image avec parapluie -->
             <br>
                <img src="<?php echo base_url()?>/uploads/parapluie.png" style="max-height: 400px;">
                <!-- <img src="<?php echo base_url()?>/uploads/imagecarte.JPG" style="min-height: 360px; max-width: 490px" > -->


                
            </div>

          </div>

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

     function printDiv(printsideA) {
     var printContents = document.getElementById(printsideA).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}

 function printDiv(printsideB) {
     var printContents = document.getElementById(printsideB).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}

// function printDiv(printsideA)
// {
//     var mywindow = window.open('', 'PRINT', 'height=688,width=386');
// // 18.2cm; height: 10.2cm;
//     mywindow.document.write('<html><head><title>' + document.title  + '</title>');
//     mywindow.document.write('</head><body >');
//     // mywindow.document.write('<h1>' + document.title  + '</h1>');
//     mywindow.document.write(document.getElementById(printsideA).innerHTML);
//     mywindow.document.write('</body></html>');

//     mywindow.document.close(); // necessary for IE >= 10
//     mywindow.focus(); // necessary for IE >= 10*/

//     mywindow.print();
//     mywindow.close();

//     return true;
// }
     </script>