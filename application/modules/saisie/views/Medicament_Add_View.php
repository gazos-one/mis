  <?php
  include VIEWPATH.'includes/new_header.php';
  include VIEWPATH.'includes/new_top_menu.php';
  include VIEWPATH.'includes/new_menu_principal.php';
  ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php
    include 'includes/Menu_Medicament.php';
    ?>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <?php 
                          if(!empty($this->session->flashdata('message')))
                             echo $this->session->flashdata('message');
            ?>
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Ajout d'un medicament</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->

         <div class="card-body">
               <form id="FormData" action="<?php echo base_url()?>saisie/Medicament/add" method="POST">
                      <div class="row">
                         <div class="form-group col-md-6">
                          <label for="DESCRIPTION">
                             Nom du medicament
                             <i class="text-danger"> *</i>
                          </label>
                          <input type="text" name="DESCRIPTION" class="form-control" value="" id="DESCRIPTION">
                          <?php echo form_error('DESCRIPTION', '<div class="text-danger">', '</div>'); ?>
                      </div>
                  <div class="form-group col-md-6">
                          <label for="ID_COUVERTURE_MEDICAMENT">
                             Type de medicament
                             <i class="text-danger"> *</i>
                          </label>
                          <select class="form-control"  aria-describedby="emailHelp" name="ID_COUVERTURE_MEDICAMENT" id="ID_COUVERTURE_MEDICAMENT">
                          <option value="" >-- Chosir--</option>
                          <?php
                          foreach ($type_med as $key => $value) { ?>
                          <option value="<?=$value['ID_COUVERTURE_MEDICAMENT']?>" ><?=$value['DESCRIPTION']?></option>
                          <?php
                           } ?>
                          </select>
                          <?php echo form_error('ID_COUVERTURE_MEDICAMENT', '<div class="text-danger">', '</div>'); ?>
                       </div>

                       
                    </div>
                                        <div class="row" style="margin-top: 5px">
                                            <div class="col-10" id="divdata" class="text-center">
                                                <input type="submit" value="Enregistrer" class="btn btn-primary"/>
                                            </div>
                                        </div>
                                    </form>
          </div> 
            </div>
            <!-- /.card -->
            </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-6">
          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
 <?php
  include VIEWPATH.'includes/new_copy_footer.php';
  ?>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<?php
  include VIEWPATH.'includes/new_script.php';
  ?>
<!-- jQuery -->

</body>
</html>
<script>
  $(document).ready(function(){ 
    $('#message').delay(5000).hide('slow');
    });
</script>
<script>

     function province(va){
      var provine_id= $(va).val();
      $.post('<?php echo base_url('saisie/Structure_Sanitaire/get_commune')?>',
          {provine_id:provine_id},
          function(data){
            $('#COMMUNE_ID').html(data);
          });
     }
     </script>