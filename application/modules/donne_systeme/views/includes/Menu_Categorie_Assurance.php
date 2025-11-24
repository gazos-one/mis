    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-4">
            <h1 class="m-0 text-dark"> <?php echo $stitle;?></h1>
          </div>
          <div class="col-sm-8">
            <ol class="breadcrumb float-sm-right">
            <li><a class="btn <?php if($this->router->method == 'index_add') echo 'btn-primary';?> btn-sm" 
     href="<?=base_url('donne_systeme/Categorie_Assurance/index_add')?>">Ajouter</a></li>
     <li><a class="btn <?php if($this->router->method == 'index') echo 'btn-primary';?> btn-sm" 
     href="<?=base_url('donne_systeme/Categorie_Assurance')?>">Liste</a></li>
            </ol>
          </div>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

