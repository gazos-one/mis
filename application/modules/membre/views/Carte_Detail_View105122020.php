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

<div style="width: 840px; height: 490px; border: 1px solid black; margin: auto;">

            <div style="width: 420px; height: 490px; float: left; border: 1px solid black;">
              <!-- Debut de la premiere personne -->
              <div style="width: 420px; height: 245px;">
                <div style="width: 110px; height: 245px; float: left;"><br>
                  <div class="text-center">
                  <img src="<?php echo base_url()?>/uploads/benemis.png" style="max-height: 50px;  max-width: 1.5cm" >
                  <img src="<?php echo base_url()?>/uploads/image_membre/<?php echo $nimag?>" style="max-height: 150px;  max-width: 2.5cm" >  
                  </div>
                  
                </div>
                <div style="width: 305px; height: 245px; float: right; font-size: 16px;">
                  <?php 
                  $GSANGUIN = $this->Model->getOne('syst_groupe_sanguin',array('ID_GROUPE_SANGUIN'=>$selected['ID_GROUPE_SANGUIN']));
                  $EMP = $this->Model->getOne('masque_emploi',array('ID_EMPLOI'=>$selected['ID_EMPLOI']));
                  ?>
                  <table>
                    <tr>
                      <td><b>NOM ET PRENOM</b></td>
                      <td>:</td>
                      <td><?php echo $selected['NOM'].' '.$selected['PRENOM']?></td>
                    </tr>
                    <tr>
                      <td><b>CNI</b></td>
                      <td>:</td>
                      <td><?php echo $selected['CNI']?></td>
                    </tr>
                    <tr>
                      <td><b>CATEGORIE</b></td>
                      <td>:</td>
                      <td><b><?php echo $categoriecarte['DESCRIPTION']?></b></td>
                    </tr>
                    <tr>
                      <td><b>CODE</b></td>
                      <td>:</td>
                      <td><?php echo $selected['CODE_AFILIATION']?></td>
                    </tr>
                    <tr>
                      <td><b>SERVICE</b></td>
                      <td>:</td>
                      <td><?php echo $EMP['DESCRIPTION']?></td>
                    </tr>
                    <tr>
                      <td><b>GROUPE SANGUIN</b></td>
                      <td>:</td>
                      <td><b><?php echo $GSANGUIN['DESCRIPTION']?></b></td>
                    </tr>
                    <tr>
                      <td><b>ADRESSE</b></td>
                      <td>:</td>
                      <td><?php echo $selected['ADRESSE']?></td>
                    </tr>
                    <tr>
                      <td><b>TELEPHONE</b></td>
                      <td>:</td>
                      <td><?php echo $selected['TELEPHONE']?></td>
                    </tr>
                    <tr>
                      <td><b>DATE D'ADHESION</b></td>
                      <td>:</td>
                      <td><?php 
                        $newDate = date("d-m-Y", strtotime($selected['DATE_ADHESION']));
                        echo  $newDate;
                      ?></td>
                    </tr>
                    
                  </table>
                </div>
              </div>
              <!--Fin de la premiere personne et debut de la seconde -->
             
              <div style="width: 420px; height: 245px;">
                <div style="width: 110px; height: 245px; float: left; ">
                  <br><div class="text-center">
                  <img src="<?php echo base_url()?>/uploads/imgayant.png" style="max-height: 50px;  max-width: 1.5cm" >
                  <img src="<?php echo base_url()?>/uploads/image_membre/<?php echo $firstnimag?>" style="max-height: 150px; max-width: 2.5cm" >  
                  </div>
                  
                </div>
                <div style="width: 305px; height: 245px; float: right; font-size: 16px;">
                  
                  <?php 
                  $FGSANGUIN = $this->Model->getOne('syst_groupe_sanguin',array('ID_GROUPE_SANGUIN'=>$firstayantdroit['ID_GROUPE_SANGUIN']));
                  ?><br><br>
                  <table>
                    <tr>
                      <td><b>NOM ET PRENOM</b></td>
                      <td>:</td>
                      <td><?php echo $firstayantdroit['NOM'].' '.$firstayantdroit['PRENOM']?></td>
                    </tr>
                    <tr>
                      <td><b>GROUPE SANGUIN</b></td>
                      <td>:</td>
                      <td><b><?php echo $FGSANGUIN['DESCRIPTION'];?></b></td>
                    </tr>
                    <tr>
                      <td><b>DATE DE NAISSANCE</b></td>
                      <td>:</td>
                      <!-- <td><?php echo $firstayantdroit['DATE_NAISSANCE']?></td> -->
                      <td><?php 
                        $newDates1 = date("d-m-Y", strtotime($firstayantdroit['DATE_NAISSANCE']));
                        echo  $newDates1;
                      ?></td>
                    </tr>
                  </table>
                   
                </div>
              </div>
              <!--Fin de la seconde personne-->

            </div>
            <!-- Debut de la seconde page-->
            <!--Debut du troisieme personne -->
            <div style="width: 418px; height: 490px; float: right; border: 1px solid black;">

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
  <!--Debut de la 2eme page-->
          <div style="width: 840px; height: 490px; border: 1px solid black; margin: auto;" >

            <div style="width: 420px; height: 490px;  float: left; border: 1px solid black;">
              
              <div style="width:390px; height: 245px;">
                <div style="width: 3cm; height: 5cm; float: left;">
                 
                </div>

                <!-- <div style="width: 390px; height: 5cm; border: 1px solid blue; float: right; font-size: 14px;">
                  
                </div> -->
              </div>
              <div style="width: 390px; height: 245px; font-size: 15px; padding-left: 15px " class="text-center">

                <br><br><br><br>
                
              <table style="padding: 5px; border: 2px solid black">
  <tr style="padding: 5px; border: 2px solid black">
    <th rowspan="2" class="text-center" style="padding: 5px; border: 2px solid black">Cat&eacute;gorie</th>
    <th colspan="5" class="text-center" style="padding: 5px; border: 2px solid black">Couverture MIS Sant&eacute;</th>
  </tr>
  <tr>
    <th colspan="3" class="text-center" style="padding: 0.5px; border: 2px solid black">Soins</th>
    <th colspan="2" class="text-center" style="padding: 0.5px; border: 2px solid black">M&eacute;dicaments</th>
  </tr>
  <tr style="padding: 5px; border: 2px solid black">
    <td rowspan="2" class="text-center"><h2><b><?php echo $categoriecarte['DESCRIPTION']?></b></h2></td>
    <td style="padding: 5px; border: 2px solid black">Type I</td>
    <td style="padding: 5px; border: 2px solid black">Type II</td>
    <td style="padding: 5px; border: 2px solid black">Type III</td>
    <td style="padding: 5px; border: 2px solid black">Génériques</td>
    <td style="padding: 5px; border: 2px solid black">Spécialités</td>
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
</table>
              </div>

            </div>
            <div class="text-center" style="width: 418px; height: 490px; float: right;position: relative; border: 1px solid black;">
             <!-- Image avec parapluie -->
             <br>
                <img src="<?php echo base_url()?>/uploads/imagecarte.JPG" style="max-height: 460px;">
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