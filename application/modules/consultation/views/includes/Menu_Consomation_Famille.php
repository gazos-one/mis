   <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-4">
            <h1 class="m-0 text-dark"><?php echo $stitle;?></h1>
          </div>
          <div class="col-sm-6">
          <form id="FormData" action="<?php echo base_url()?>consultation/Consomation_Famille/<?php echo $this->router->method ?>" method="POST" enctype="multipart/form-data">
      <div class="row form-group col-md-12">
      

      <div class=" form-group col-sm-3">
                          <label for="ANNEE">
                          Ann&eacute;e 
                          </label>
                          <select class="form-control select2" name="ANNEE" id="ANNEE" onchange="getlist(this)">
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
                      <div class=" form-group col-sm-3">
                          <label for="MOIS">
                          Mois
                          </label>
                          <select class="form-control select2" name="MOIS" id="MOIS" onchange="getlist(this)">
                            <option value="">-- Tous --</option>
                            <option value="01" <?php if ($MOIS == '01') { echo 'selected';}?>>01</option>
                            <option value="02" <?php if ($MOIS == '02') { echo 'selected';}?>>02</option>
                            <option value="03" <?php if ($MOIS == '03') { echo 'selected';}?>>03</option>
                            <option value="04" <?php if ($MOIS == '04') { echo 'selected';}?>>04</option>
                            <option value="05" <?php if ($MOIS == '05') { echo 'selected';}?>>05</option>
                            <option value="06" <?php if ($MOIS == '06') { echo 'selected';}?>>06</option>
                            <option value="07" <?php if ($MOIS == '07') { echo 'selected';}?>>07</option>
                            <option value="08" <?php if ($MOIS == '08') { echo 'selected';}?>>08</option>
                            <option value="09" <?php if ($MOIS == '09') { echo 'selected';}?>>09</option>
                            <option value="10" <?php if ($MOIS == '10') { echo 'selected';}?>>10</option>
                            <option value="11" <?php if ($MOIS == '11') { echo 'selected';}?>>11</option>
                            <option value="12" <?php if ($MOIS == '12') { echo 'selected';}?>>12</option>                            
                          </select>
                      </div>

                      <div class="form-group col-sm-6">
                          <label for="ID_GROUPE">
                          Groupe
                       </label>
                       <select class="form-control"  onchange="getlist(this)" name="ID_GROUPE" id="ID_GROUPE">
                       <option value="">-- Tous --</option>
                       <?php
                       foreach ($groupe as $value) { 
                         if ($ID_GROUPE == $value['ID_GROUPE']) {
                         ?>
                         <option value="<?=$value['ID_GROUPE']?>" selected><?=$value['NOM_GROUPE']?></option>
                         <?php
                         }
                         else{


                           ?>
                           <option value="<?=$value['ID_GROUPE']?>"><?=$value['NOM_GROUPE']?></option>
                           <?php
                           }
                        } 
                        ?>
                       </select>
                         
                      </div>

      
      </div>
      </form>
          </div>
          <div class="col-sm-2">
            <ol class="breadcrumb float-sm-right">
            <li><a class="btn <?php if($this->router->method == 'index') echo 'btn-primary';?> btn-sm" 
     href="<?=base_url('consultation/Consomation_Famille/')?>">Liste</a></li>
            </ol>

          </div>
          <div class="col-sm-4 text-center">
            <h3>Total Consultation: <?php echo number_format($totalconsultation,0,' ',' ');?></h3>
          </div>
          <div class="col-sm-4 text-center">
            <h3>Total Medicament: <?php echo number_format($totalmedicaament,0,' ',' ');?></h3>
          </div>
          <div class="col-sm-4 text-center">
            <h3>Total :
            <?php 
            $totalall = $totalconsultation + $totalmedicaament;
            echo number_format($totalall,0,' ',' ');?></h3>
          </div>
          
          
          <!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

