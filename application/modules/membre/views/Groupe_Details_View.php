  <?php
  include VIEWPATH.'includes/new_header.php';
  include VIEWPATH.'includes/new_top_menu.php';
  include VIEWPATH.'includes/new_menu_principal.php';
  ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php
    include 'includes/Menu_Groupe.php';
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
                <h3 class="card-title">Detail  d'un groupe</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->

         <div class="card-body">



         <div class="card card-primary card-tabs">
              <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Details du Groupe</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Liste des affilie</a>
                  </li>
                  
                  
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-one-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                  <table class="table">
        <tr>
          <td>Numero</td>
          <td><?php echo $selected['ID_GROUPE']?></td>
        </tr>
        <tr>
          <td>Nom</td>
          <td><?php echo $selected['NOM_GROUPE']?></td>
        </tr>
        <tr>
          <td>Date enregistrement</td>
          <td><?php echo $selected['DATE_ENREGISTREMENT']?></td>
        </tr>
        <tr>
          <td>Status</td>
          <td><?php echo $selected['STATUS']?></td>
        </tr>
        <tr>
          <td>Nombre affili&eacute;</td>
          <td><?php echo $selected['MEMBRE']?></td>
        </tr>
      </table>
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                     
                  
                  <table id="example2" class="table table-bordered table-hover">
                  <thead>
       
                  <tr>
                    <th>Nom</th>
                    <th>Code</th>
                    <th>CNI</th>
                    <th>Date adhesion</th>
                    <th>Ayant Droit</th>
                    <th>Option</th>
                  </tr>
                  </thead>
                  <tbody>

                  <?php
                  
                  foreach ($list as $listes) {

                    if ($listes['IS_AFFILIE'] == 1) {
                      $aff = 'Oui';
                    }
                    else{
                      $aff = 'Non';
                    }
                    $newDate = date("d-m-Y", strtotime($listes['DATE_ADHESION']));

                   ?>
                  <tr>
                    <td><?php echo $listes['NOM'].' '.$listes['PRENOM'] ?></td>
                    <td><?php echo $listes['CODE_AFILIATION'] ?></td>
                    <td><?php echo $listes['CNI'] ?></td>
                    <td><?php echo $newDate ?></td>
                    <td><?php echo $aff ?></td>
                    <td>
                      <?php
                         echo '<div class="dropdown ">
                                      <a class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Actions
                                      <span class="caret"></span></a>
                                      <ul class="dropdown-menu dropdown-menu-right">
                                      <li><a class="dropdown-item" href="'.base_url('membre/Membre/details/'.$listes['ID_MEMBRE']).'"> Détail </a> </li>
                                      </ul>
                          </div>';
                    ?></td>
                  </tr>

         

                   <?php
                  }
                  ?>

                  
                  
                  
                  
                  </tbody>
                  <tfoot>
                </table>


                  </div>
                  
                  
                </div>
              </div>
              <!-- /.card -->
            </div>



 
               
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

<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>