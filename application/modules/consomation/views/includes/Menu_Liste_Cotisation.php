   <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-3">
            <h1 class="m-0 text-dark"><?php echo $stitle;?></h1>
            <h3 class="text-danger text-left"><?php echo $TOTAL?></h3>
            
          </div><!-- /.col -->
          <form id="FormData" action="<?php echo base_url()?>cotisation/Liste_Cotisation/<?php echo $this->router->method ?>" method="POST" enctype="multipart/form-data">
          <div class="col-sm-12">
            <div class="row">
            <div class="form-group col-sm-10">
                          <label for="MOIS">
                          MOIS
                             <i class="text-danger"> *</i>
                          </label>
                          <input type="month" name="MOIS" class="form-control" value="<?php echo $MOIS ?>" id="MOIS">
                      </div>
            <div class="form-group col-md-2"><br>
                      <input type="submit" value="Chercher" class="btn btn-primary"/>
            </div>
            </div>

            
          </div>
          </form>
          <div class="col-sm-5">
            <ol class="breadcrumb float-sm-right">
            <li><a class="btn <?php if($this->router->method == 'index') echo 'btn-primary';?> btn-sm" 
     href="<?=base_url('cotisation/Liste_Cotisation/')?>">Liste des paiements</a></li>
     <li><a class="btn <?php if($this->router->method == 'listing') echo 'btn-primary';?> btn-sm" 
     href="<?=base_url('cotisation/Liste_Cotisation/listing')?>">Liste des retards ou manquant</a></li>
            </ol>

          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

