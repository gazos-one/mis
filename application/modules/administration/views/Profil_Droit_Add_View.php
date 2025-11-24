<?php
  include VIEWPATH.'includes/new_header.php';
  ?>
  
<!-- Site wrapper -->
<div class="wrapper">
  <?php
  include VIEWPATH.'includes/new_top_menu.php';
  include VIEWPATH.'includes/new_menu_principal.php';
  ?>

  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php 
    include 'includes/menu_profil_droit.php';
    ?>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">

      <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Enregistrement d'un profil et droits</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form id="FormData" action="<?php echo base_url()?>administration/Profil_Droit/add" method="POST" enctype="multipart/form-data">
                <div class="card-body row">
                  <div class="form-group col-lg-12">
                    <label for="exampleInputEmail1">Nom du Profil <spam class="text-danger">*</spam> </label>
                    <input type="text" class="form-control" id="DESCRIPTION" name="DESCRIPTION" placeholder="Nom Profil" value="<?=set_value('DESCRIPTION')?>">
                    <?php echo form_error('DESCRIPTION', '<div class="text-danger">', '</div>'); ?>
                  </div>
                  <?php
                    foreach ($droits as $value) {
                      ?>
                  <div class="form-group col-lg-4 custom-control custom-checkbox">
                          <input class="custom-control-input custom-control-input-primary custom-control-input-outline" type="checkbox" name="ID_DROIT[]" value="<?php echo $value['ID_DROIT']?>" id="customCheckbox<?php echo $value['ID_DROIT']?>" >
                          <label for="customCheckbox<?php echo $value['ID_DROIT']?>" class="custom-control-label"><?php echo $value['DESCRIPTION']?> </label>
                  </div>
                      <?php
                    }
                  ?>
                  <?php echo form_error('ID_DROIT', '<div class="text-danger">', '</div>'); ?>
                  
                  
                  
                  
                  
                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary btn-block">Enregistrer</button>
                </div>
              </form>
            </div>
        
        
        <!-- /.card-body -->
        <!-- <div class="card-footer">
          Footer
        </div> -->
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php
 include VIEWPATH.'includes/new_copy_footer.php';  
  ?>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<?php
  include VIEWPATH.'includes/new_script.php';
  ?>
  <script>
  $(function () {
   
    //Date picker
    $('#DEBUT_EXERCICE').datetimepicker({
        format: 'L'
        // daysOfWeekDisabled: [0, 6]
    });    
    $('#FIN_EXERCICE').datetimepicker({
        format: 'L'
    });    

  })
 


</script>
</body>
</html>
