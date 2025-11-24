   <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-8">
            <h1 class="m-0 text-dark"><?php echo $stitle;?>

            <?php if($this->router->method == 'index_carte') echo ' numero '.$categoriecarte['CODE_CARTE'];?>
            </h1>
          </div><!-- /.col -->
          <div class="col-sm-4">
            <ol class="breadcrumb float-sm-right">
            <!-- <li><a class="btn <?php if($this->router->method == 'index') echo 'btn-primary';?> btn-sm" 
     href="<?=base_url('saisie/Structure_Sanitaire/')?>">Ajouter</a></li> -->
     <li><a class="btn btn-primary btn-sm" 
     href="<?=base_url('membre/Carte/listing')?>">Liste</a></li>
            </ol>

          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

