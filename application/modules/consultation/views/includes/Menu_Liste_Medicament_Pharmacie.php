   <div class="content-header">

      <div class="container-fluid">

        <div class="row mb-2">

          <div class="col-sm-3">

            <h1 class="m-0 text-dark"><?php echo $stitle;?></h1>

            <h3 class="text-danger text-left" id="total"></h3>

             

          </div><!-- /.col -->

          <!-- <form id="FormData" action="<?php echo base_url()?>consultation/Liste_Medicament_Pharmacie/index" method="POST" enctype="multipart/form-data"> -->

          <form>

          <div class="col-sm-12">

            <div class="row">

              <div class="form-group col-sm-6">

              <label for="ANNEE">

                          Ann&eacute;e

                          </label>

                          <select class="form-control select2" name="ANNEE" id="ANNEE" onchange="liste(this)">

                            <option value="">-- Sélectionner --</option>

                            <?php

                          foreach ($annee as $key => $value) { 

                            if ($ANNEE == $value['ANNEE']) {?>

                            <option value="<?=$value['ANNEE']?>" selected><?=$value['ANNEE']?></option>

                            <?php

                              # code...

                            }

                            else{

                              ?>

                              <option value="<?=$value['ANNEE']?>"><?=$value['ANNEE']?></option>

                              <?php

                            }

                              ?>

                              

                              <?php

                           } 

                           ?>

                          </select>

                      </div>

                      <div class=" form-group col-sm-6">
                          <label for="MOIS">
                         MOIS 
                          </label>
                       <select class="form-control select2" name="MOIS" id="MOIS" onchange="liste()">
                            <option value="">-- Tous --</option>
                            <option value="01">01</option>
                            <option value="02">02</option>
                            <option value="03">03</option>
                            <option value="04">04</option>
                            <option value="05">05</option>
                            <option value="06">06</option>
                            <option value="07">07</option>
                            <option value="08">08</option>
                            <option value="09">09</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>                            
                          </select>
                      </div>


          

            

            </div>



            

          </div>

          </form>

          <div class="col-sm-5">

            <ol class="breadcrumb float-sm-right">

            <li><a class="btn <?php if($this->router->method == 'index') echo 'btn-primary';?> btn-sm" 

     href="<?=base_url('consultation/Liste_Medicament_Pharmacie/index')?>">Liste non pay&eacute;</a></li>



     <li><a class="btn <?php if($this->router->method == 'listings') echo 'btn-primary';?> btn-sm" 

     href="<?=base_url('consultation/Liste_Medicament_Pharmacie/listings')?>">Liste encours de paiement</a></li>



     <li><a class="btn <?php if($this->router->method == 'listing') echo 'btn-primary';?> btn-sm" 

     href="<?=base_url('consultation/Liste_Medicament_Pharmacie/listing')?>">Liste pay&eacute;</a></li>

            </ol>



          </div><!-- /.col -->

        </div><!-- /.row -->

      </div><!-- /.container-fluid -->

    </div>



