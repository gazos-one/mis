   <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-4">
            <h1 class="m-0 text-dark"><?php echo $stitle;?></h1>
          </div><!-- /.col -->
          <div class="col-sm-8">
            <ol class="breadcrumb float-sm-right">
            <li><a class="btn <?php if($this->router->method == 'index') echo 'btn-primary';?> btn-sm" 
     href="<?=base_url('cotisation/Ajout_Cotisation/')?>">Cotisation individuel</a></li>
     <li><a class="btn <?php if($this->router->method == 'groupe') echo 'btn-primary';?> btn-sm" 
     href="<?=base_url('cotisation/Ajout_Cotisation/groupe')?>">Cotisation par groupe</a></li>
            </ol>

          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

