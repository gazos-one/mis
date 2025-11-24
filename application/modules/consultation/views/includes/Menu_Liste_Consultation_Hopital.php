   <div class="content-header">
      <div class="container-fluid">
      <div class="row form-group col-sm-12">
      <div class="form-group col-md-4">
      <h1 class="m-0 text-dark"><?php echo $stitle;?></h1>
      <!-- <h3 class="text-danger text-left"><?php echo $TOTAL?></h3> -->
      </div>
     <form>
      <div class="row form-group col-md-12">
      

      <div class=" form-group col-sm-4">
                          <label for="ANNEE">
                          Ann&eacute;e 
                          </label>
                          <select class="form-control select2" name="ANNEE" id="ANNEE" onchange="liste(this)">
                            <option value="">-- Sélectionner --</option>
                            <?php
                          foreach ($annee as $key => $value) { 
                            if (set_value('ANNEE') == $value['ANNEE']) {?>
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
                  <div class=" form-group col-sm-2">
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

                 <div class="form-group col-sm-6">
                          <label for="ID_CONSULTATION_TYPE">
                          Type de consultation
                          </label>
                          <select class="form-control select2" name="ID_CONSULTATION_TYPE" id="ID_CONSULTATION_TYPE" onchange="liste(this)">
                            <option value="">-- Sélectionner --</option>
                            <?php
                          foreach ($tconsultation as $value) { 
                            if (set_value('ID_CONSULTATION_TYPE') == $value['ID_CONSULTATION_TYPE']) {?>
                            <option value="<?=$value['ID_CONSULTATION_TYPE']?>" selected><?=$value['DESCRIPTION']?></option>
                            <?php
                              # code...
                            }
                            else{
                              ?>
                              <option value="<?=$value['ID_CONSULTATION_TYPE']?>"><?=$value['DESCRIPTION']?></option>
                              <?php
                            }
                              ?>
                              
                              <?php
                           } 
                           ?>
                          </select>
                      </div>

      
      </div>
        </form>
     
      <div class="form-group col-md-4">
      <ol class="breadcrumb float-sm-right">
            <li><a class="btn <?php if($this->router->method == 'indexs') echo 'btn-primary';?> btn-sm" 
     href="<?=base_url('consultation/Liste_Consultation_Hopital/indexs')?>">Liste non pay&eacute;</a></li>
     <li><a class="btn <?php if($this->router->method == 'listing') echo 'btn-primary';?> btn-sm" 
     href="<?=base_url('consultation/Liste_Consultation_Hopital/listing')?>">Liste pay&eacute;</a></li>
            </ol>
      </div>

  </div>

      </div><!-- /.container-fluid -->
    </div>

