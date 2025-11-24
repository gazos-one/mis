  <?php
  include VIEWPATH.'includes/new_header.php';
  include VIEWPATH.'includes/new_top_menu.php';
  include VIEWPATH.'includes/new_menu_principal.php';
  ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php
    include 'includes/Menu_Centre_Optique.php';
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
                <h3 class="card-title">Ajout d'un Centre Optique</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->

         <div class="card-body">
               <form id="FormData" action="<?php echo base_url()?>saisie/Centre_Optique/add" method="POST">
                      <div class="row">
                         <div class="form-group col-md-12">
                          <label for="DESCRIPTION">
                             Nom du Centre Optique
                             <i class="text-danger"> *</i>
                          </label>
                          <input type="text" name="DESCRIPTION" class="form-control" value="" id="DESCRIPTION">
                          <?php echo form_error('DESCRIPTION', '<div class="text-danger">', '</div>'); ?>
                      </div>


                       <div class="form-group col-md-6">
                          <label for="PROVINCE_ID">
                             Province
                             <i class="text-danger"> *</i>
                          </label>
                          <select class="form-control"  onchange="province(this)" name="PROVINCE_ID" id="PROVINCE_ID">
                          <option value="" >-- Sélectionner --</option>
                          <?php
                          foreach ($province as $key => $value) { ?>
                          <option value="<?=$value['PROVINCE_ID']?>" ><?=$value['PROVINCE_NAME']?></option>
                          <?php
                           } ?>
                          </select>
                          <?php echo form_error('PROVINCE_ID', '<div class="text-danger">', '</div>'); ?>
                       </div>

                       <div class="form-group col-md-6">
                          <label for="COMMUNE_ID">
                             Commune
                             <i class="text-danger"> *</i>
                          </label>
                          <select class="form-control"  aria-describedby="emailHelp" name="COMMUNE_ID" id="COMMUNE_ID">
                          </select>
                          <?php echo form_error('COMMUNE_ID', '<div class="text-danger">', '</div>'); ?>
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
      $.post('<?php echo base_url('saisie/Centre_Optique/get_commune')?>',
          {provine_id:provine_id},
          function(data){
            $('#COMMUNE_ID').html(data);
          });
     }
     </script>