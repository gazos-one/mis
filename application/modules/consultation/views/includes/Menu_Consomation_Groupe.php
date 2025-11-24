   <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><?php echo $stitle;?></h1>
          </div>
          <div class="col-sm-4">
          <form id="FormData" action="<?php echo base_url()?>consultation/Consomation_Groupe/<?php echo $this->router->method ?>" method="POST" enctype="multipart/form-data">
      <div class="row form-group col-md-12">
      

      <div class=" form-group col-sm-6">
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

                      <div class="form-group col-sm-6">
                          <label for="ID_CONSULTATION_TYPE">
                          Mois de consomation
                          </label>
                          <select class="form-control select2" name="ID_CONSULTATION_TYPE" id="ID_CONSULTATION_TYPE" onchange="getlist(this)">
                            <option value="">-- Sélectionner --</option>
                            <option value="">01</option>
                            <option value="">02</option>
                            <option value="">03</option>
                            <option value="">04</option>
                            <option value="">05</option>
                            <option value="">06</option>
                            <option value="">07</option>
                            <option value="">08</option>
                            <option value="">09</option>
                            <option value="">10</option>
                            <option value="">11</option>
                            <option value="">12</option>
                           
                          </select>
                      </div>

      
      </div>
      </form>
          </div>
          <!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

