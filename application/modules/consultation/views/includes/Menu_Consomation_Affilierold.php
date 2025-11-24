   <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><?php echo $stitle;?></h1>
          </div>
          <div class="col-sm-4">
          <form>
      <div class="row form-group col-md-12">
      

      <div class=" form-group col-sm-6">
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
          </div>
          <div class="col-sm-2">
            <ol class="breadcrumb float-sm-right">
            <li><a class="btn <?php if($this->router->method == 'index') echo 'btn-primary';?> btn-sm" 
     href="<?=base_url('consultation/Consomation_Affilier/')?>">Liste</a></li>
     <li><a class="btn <?php if($this->router->method == 'depacement') echo 'btn-primary';?> btn-sm" 
     href="<?=base_url('consultation/Consomation_Affilier/depacement')?>">Dépassement plafond</a></li>
            </ol>

          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

