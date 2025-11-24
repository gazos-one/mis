   <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-3">
            <h1 class="m-0 text-dark"><?php echo $stitle;?></h1>
            <h3 class="text-danger text-left" id="total"></h3>
            
          </div><!-- /.col -->

          <div class="col-sm-5" id="chiffre">
           
            
          </div><!-- /.col -->
          
          <div class="col-sm-4">
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

