  <?php
  include VIEWPATH.'includes/new_header.php';
  include VIEWPATH.'includes/new_top_menu.php';
  include VIEWPATH.'includes/new_menu_principal.php';
  ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php
    include 'includes/Menu_Configuration_Cotisation.php';
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
              <!-- <div class="card-header">
                <h3 class="card-title">Ajout d'un affili&eacute;</h3>
              </div> -->
              <!-- /.card-header -->
              <!-- form start -->

         <div class="card-body">
               <!-- <form id="FormData" action="#" method="POST"> -->
               <form id="FormData" action="<?php echo base_url()?>cotisation/Configuration_Cotisation/update" method="POST" enctype="multipart/form-data">
                      <div class="row">
                        <div class="col-md-12">
                          <h4>Configuration des cotisations</h4>
                        </div>
                         <div class="form-group col-md-12">
                          <label for="MONTANT_COTISATION">
                             Montant de la cotisation
                             <i class="text-danger"> *</i>
                          </label>
                          <input type="hidden" name="ID_MONTANT_COTISATION" class="form-control" value="<?php echo $cotisation['ID_MONTANT_COTISATION']?>" id="ID_MONTANT_COTISATION">
                          <input type="number" name="MONTANT_COTISATION" class="form-control" value="<?php echo $cotisation['MONTANT_COTISATION']?>" id="MONTANT_COTISATION" required>
                          <?php echo form_error('MONTANT_COTISATION', '<div class="text-danger">', '</div>'); ?>
                      </div>
                  <div class="form-group col-md-6">
                          <label for="ID_CATEGORIE_COTISATION_MEMBRE">
                             Categorie
                             <i class="text-danger"> *</i> 
                             <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modalcat">
                  (Ajouter nouvelle categorie)
                </button>
                          </label>
                          <select class="form-control"  aria-describedby="emailHelp" name="ID_CATEGORIE_COTISATION_MEMBRE" id="ID_CATEGORIE_COTISATION_MEMBRE">
                            <option value="">-- Sélectionner --</option>
                            <?php
                          foreach ($categorie as $key => $value) { 
                            if ($cotisation['ID_CATEGORIE_COTISATION_MEMBRE'] == $value['ID_CATEGORIE_COTISATION_MEMBRE']) {
                             ?>
                             <option value="<?=$value['ID_CATEGORIE_COTISATION_MEMBRE']?>" selected><?=$value['DESCRIPTION']?></option>
                             <?php
                            }
                            else{
                              ?>
                              <option value="<?=$value['ID_CATEGORIE_COTISATION_MEMBRE']?>"><?=$value['DESCRIPTION']?></option>
                              <?php
                           } 
                           }
                           ?>
                          </select>
                          <?php echo form_error('ID_CATEGORIE_COTISATION_MEMBRE', '<div class="text-danger">', '</div>'); ?>
                       </div>
                       <div class="form-group col-md-6">
                    <label for="">Periode <i class="text-danger"> *</i>
                    <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modalper">
                  (Ajouter nouvelle periode)
                </button>
              </label>

              <select class="form-control"  aria-describedby="emailHelp" name="ID_PERIODE_COTISATION" id="ID_PERIODE_COTISATION">
                            <option value="">-- Sélectionner --</option>
                            <?php
                          foreach ($periode as $key => $value) { 
                            if ($cotisation['ID_PERIODE_COTISATION'] == $value['ID_PERIODE_COTISATION']) {
                             ?>
                             <option value="<?=$value['ID_PERIODE_COTISATION']?>" selected><?=$value['DESCRIPTION']?></option>
                             <?php
                            }
                            else{
                              ?>
                              <option value="<?=$value['ID_PERIODE_COTISATION']?>"><?=$value['DESCRIPTION']?></option>
                              <?php
                           } 
                           }
                           ?>
                          </select>

                     

                          <?php echo form_error('ID_PERIODE_COTISATION', '<div class="text-danger">', '</div>'); ?>
                  </div>

                       
                      
                       

                     
                       
                    </div>
                    
                    
                              <div class="row"><br>
                                  <div class="col-12 text-center" id="divdata" style="margin-top: 10px">
                                        <input type="submit" value="Enregistrer" class="btn btn-primary"/>
                                  </div>
                              </div>
                                    </form>
          </div> 
            </div>


            <div class="modal fade" id="modalcat">
        <div class="modal-dialog">
          <form id="myformsassuree" method="POST" onsubmit="addcategorie();return false" accept-charset="utf-8" enctype="multipart/form-data">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Ajout d'une nouvelle categorie</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                      <div class="row">
                         <div class="form-group col-md-12">
                          <label for="NOMMETIER">
                             Categorie
                             <i class="text-danger"> *</i>
                          </label>
                          <input type="text" name="DESCRIPTION_CAT" class="form-control" value="" id="DESCRIPTION_CAT">
                          <?php echo form_error('DESCRIPTION_CAT', '<div class="text-danger">', '</div>'); ?>
                      </div>
                    </div>                                    
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
              <input type="submit" value="Enregistrer" class="btn btn-primary"/>
            </div>
          </div>
        </form>

        </div>
      </div>



      <div class="modal fade" id="modalper">
        <div class="modal-dialog">
          <form id="myformsassuree" method="POST" onsubmit="addperiode();return false" accept-charset="utf-8" enctype="multipart/form-data">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Ajout d'une nouvelle periode</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                      <div class="row">
                         <div class="form-group col-md-12">
                          <label for="NOMMETIER">
                             Periode
                             <i class="text-danger"> *</i>
                          </label>
                          <input type="text" name="DESCRIPTION_PER" class="form-control" value="" id="DESCRIPTION_PER">
                          <?php echo form_error('DESCRIPTION_PER', '<div class="text-danger">', '</div>'); ?>
                      </div>
                      <div class="form-group col-md-12">
                          <label for="NOMMETIER">
                             Nb Jours
                             <i class="text-danger"> *</i>
                          </label>
                          <input type="number" name="NB_JOURS" class="form-control" value="" id="NB_JOURS">
                          <?php echo form_error('NB_JOURS', '<div class="text-danger">', '</div>'); ?>
                      </div>
                    </div>                                    
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
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
<!-- <script>

     function province(va){
      var provine_id= $(va).val();
      $.post('<?php echo base_url('membre/Membre/get_commune')?>',
          {provine_id:provine_id},
          function(data){
            $('#COMMUNE_ID').html(data);
          });
     }
     </script> -->

     <script>

function addcategorie(val){
var DESCRIPTION_CAT= $('#DESCRIPTION_CAT').val();

$.post('<?php echo base_url('cotisation/Configuration_Cotisation/addCategorie')?>',
          {
            DESCRIPTION:DESCRIPTION_CAT
          },
          function(data){
            // alert(data);
            $('#ID_CATEGORIE_COTISATION_MEMBRE').html(data); 
            $('#ID_CATEGORIE_COTISATION_MEMBRE').selectpicker('refresh');
          });
            $('#modalcat').modal('hide');

}

    </script>


    <script>

function addperiode(val){
var DESCRIPTION_PER= $('#DESCRIPTION_PER').val();
var NB_JOURS= $('#NB_JOURS').val();


$.post('<?php echo base_url('cotisation/Configuration_Cotisation/addPeriode')?>',
          {
            DESCRIPTION:DESCRIPTION_PER,
            NB_JOURS:NB_JOURS
          },
          function(data){
            // alert(data);
            $('#ID_PERIODE_COTISATION').html(data); 
            $('#ID_PERIODE_COTISATION').selectpicker('refresh');
          });
            $('#modalper').modal('hide');

}

    </script>


    

  <!--   <script>
  function changegroupe(){
  if(document.getElementById('mgr1').checked) {
        $('#ID_GROUPE')
        .attr('disabled', true)
        }
  if(document.getElementById('mgr2').checked) {
        $('#ID_GROUPE')
        .attr('disabled', false)
          
        }

    }
</script> -->

<!-- <script>
  function countmembre(){
    var ID_GROUPE= $('#ID_GROUPE').val();
    if(document.getElementById('etud1').checked) {
      var ETUDIANT= 0;
        }
        else{
      var ETUDIANT= 1;   
        }
    $.post('<?php echo base_url('membre/Membre/countmembre')?>',
          {
            ID_GROUPE:ID_GROUPE,
            ETUDIANT:ETUDIANT
          },
          function(data){
            $('#ID_CATEGORIE_ASSURANCE').html(data);
          });
    }
</script> -->



<!-- 
<script>
$('#DATE_NAISSANC').daterangepicker({
    "singleDatePicker": true,
    "showDropdowns": true,
    "startDate": "<?php echo $datemin;?>",
    // "endDate": "12/06/2020",
    // "minDate": "<?php echo $datemin;?>",
    "maxDate": "<?php echo $datemin;?>",
    "opens": "center",
    "drops": "auto"
}, function(start, end, label) {
  console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
});
</script> -->