   <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-4">
          <h1 class="m-0 text-dark"><?php echo $stitle;?></h1>
        </div><!-- /.col -->
        <div class="col-sm-8">
          <ol class="breadcrumb float-sm-right">
            <li><a class="btn <?php if($this->router->method == 'index') echo 'btn-primary';?> btn-sm" 
             href="<?=base_url('paiment/Paiment_facture/')?>">Ajouter</a></li>
             <li><a class="btn <?php if($this->router->method == 'liste') echo 'btn-primary';?> btn-sm" 
               href="<?=base_url('paiment/Paiment_facture/liste')?>">Liste</a></li>
             </ol>

           </div><!-- /.col -->
         </div><!-- /.row -->
       </div><!-- /.container-fluid -->
     </div>

