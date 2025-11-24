   <div class="content-header">
      <div class="container-fluid">
      <div class="row form-group col-sm-12">
      <div class="form-group col-md-4">
      <h1 class="m-0 text-dark"><?php echo $stitle;?></h1>
      </div>
      <form id="FormData" action="<?php echo base_url()?>consultation/Liste_Consultation/<?php echo $this->router->method ?>" method="POST" enctype="multipart/form-data">
      <div class="row form-group col-md-12">
      

      <div class=" form-group col-sm-6">
                          <label for="ANNEE">
                          Ann&eacute;e 
                          </label>
                          <select class="form-control select2" name="ANNEE" id="ANNEE" onchange="litse_non_archive(this)">
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

                      <div class="form-group col-sm-6">
                          <label for="ID_CONSULTATION_TYPE">
                          Type de consultation
                          </label>
                          <select class="form-control select2" name="ID_CONSULTATION_TYPE" id="ID_CONSULTATION_TYPE" onchange="litse_non_archive(this)">
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
            <li><a class="btn <?php if($this->router->method == 'index') echo 'btn-primary';?> btn-sm" 
     href="<?=base_url('consultation/Liste_Consultation/')?>">Non Archiv&eacute;</a></li>
     <li><a class="btn <?php if($this->router->method == 'listing') echo 'btn-primary';?> btn-sm" 
     href="<?=base_url('consultation/Liste_Consultation/listing')?>">Archiv&eacute;</a></li>
            </ol>
      </div>

  </div>

      </div><!-- /.container-fluid -->
    </div>

