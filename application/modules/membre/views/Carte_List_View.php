  <?php
  include VIEWPATH.'includes/new_header.php';
  include VIEWPATH.'includes/new_top_menu.php';
  include VIEWPATH.'includes/new_menu_principal.php';
  ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php
    include 'includes/Menu_Carte.php';
    ?>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Liste des Cartes des affili&eacute;s</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->

              <form id="FormData" action="<?php echo base_url()?>membre/Carte/listing" method="POST">
            <div class="col-md-12 row">
              
              
              <div class="col-md-3">
                <label for="ANNE">
                             Ann&eacute; d'affiliation
                          </label>
                          <select class="form-control"  onchange="recherche()" name="DATE_ADHESION" id="DATE_ADHESION">
                          <option value="">-- Sélectionner --</option>
                          <?php
                          foreach ($anne_aff as $keys) { 
                            if ($keys['DATE_ADHESION']==$DATE_ADHESION) {
                              ?>
                              <option value="<?=$keys['DATE_ADHESION']?>" selected><?=$keys['DATE_ADHESION']?></option>
                              <?php
                            }
                            else{                            
                              ?>
                              <option value="<?=$keys['DATE_ADHESION']?>"><?=$keys['DATE_ADHESION']?></option>
                              <?php
                              }
                           } 
                           ?> 
                          </select><br>
              </div>

              <div class="col-md-3">
                <label for="IS_TAKEN">
                             Carte Prise
                          </label>
                        <select class="form-control"  onchange="recherche()" name="IS_TAKEN" id="IS_TAKEN">
                          <option value="3" <?php if ($IS_TAKEN == 3) {echo 'selected';} ?>>Tout</option>
                          <option value="1" <?php if ($IS_TAKEN == 1) {echo 'selected';} ?>>Prise</option>  
                          <option value="0" <?php if ($IS_TAKEN == 0) {echo 'selected';} ?>>Non Prise</option>
                        </select>
                        <br>
              </div>

              <!-- <div class="col-md-3">
                <label for="PROVINCE_ID">
                             Groupe
                          </label>
                          <select class="form-control"  onchange="province(this)" name="DATE_ADHESION" id="DATE_ADHESION">
                          <option value="">-- Sélectionner --</option>
                          <?php
                          foreach ($anne_aff as $keys) { 
                              ?>
                              <option value="<?=$keys['DATE_ADHESION']?>"><?=$keys['DATE_ADHESION']?></option>
                              <?php
                           } 
                           ?> 
                          </select><br>
              </div> -->

              <div class="col-md-3">
                <label for="ID_GROUPE">
                             Groupe
                          </label>
                          <select class="form-control"  onchange="recherche()" name="ID_GROUPE" id="ID_GROUPE">
                          <option value="">-- Tout --</option>
                          <?php
                          foreach ($groupe as $value) { 
                            if ($ID_GROUPE == $value['ID_GROUPE']) {
                            ?>
                            <option value="<?=$value['ID_GROUPE']?>" selected><?=$value['NOM_GROUPE']?></option>
                            <?php
                            }
                            else{


                              ?>
                              <option value="<?=$value['ID_GROUPE']?>"><?=$value['NOM_GROUPE']?></option>
                              <?php
                              }
                           } 
                           ?>
                          </select><br>
              </div>

              <div class="col-md-3">
                <label for="STATUS">
                             Actif
                          </label>
                          <select class="form-control"  onchange="recherche()" name="STATUS" id="STATUS">
                          <option value="1" <?php if ($STATUS == 1) {echo 'selected';} ?>>Oui</option>
                          <option value="0" <?php if ($STATUS == 0) {echo 'selected';} ?>>Non</option>
                          </select>
                          <br>
              </div>
              <!-- <div class="col-md-2">
                <label for="ID_CATEGORIE_ASSURANCE">
                             Categorie Assurance
                          </label>
                          <select class="form-control"  onchange="recherche()" name="ID_CATEGORIE_ASSURANCE" id="ID_CATEGORIE_ASSURANCE">
                          <option value="">-- Sélectionner --</option>
                           <?php
                          foreach ($acategorie as $keys) { 
                            if ($keys['ID_CATEGORIE_ASSURANCE'] == $ID_CATEGORIE_ASSURANCE) {
                              ?>
                              <option value="<?=$keys['ID_CATEGORIE_ASSURANCE']?>"><?=$keys['DESCRIPTION']?></option>
                              <?php
                            }
                            else{
                              ?>
                              <option value="<?=$keys['ID_CATEGORIE_ASSURANCE']?>"><?=$keys['DESCRIPTION']?></option>
                              <?php
                              }
                           } 
                           ?>
                          </select><br>
              </div> -->
              
            
            </div>
            </form>

 <div class="card-body table-responsive">




       <?php 
             if(!empty($this->session->flashdata('message')))
               echo $this->session->flashdata('message');
               echo $this->table->generate($chamb);
            ?>


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
<script>
  $(document).ready(function(){ 
    $('#message').delay(5000).hide('slow');
    });
</script>

<script type="text/javascript">
  $('#mytable').DataTable({
   dom: 'Bfrtlip',
   "paging":   true,
    "ordering": true,
    "info":     true,
    "lengthChange": true,
   buttons: [
      {
         extend: 'excel',
         text: 'Excel',
         className: 'btn btn-default',
         exportOptions: {
            columns: 'th:not(:last-child)'
         }
      },
      {
         extend: 'pdfHtml5',
         text: 'PDF',
         className: 'btn btn-default',
         exportOptions: {
            columns: 'th:not(:last-child)'
         }
      }
   ],
   language: {
                                "sProcessing":     "Traitement en cours...",
                                "sSearch":         "Rechercher&nbsp;:",
                                "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
                                "sInfo":           "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
                                "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
                                "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
                                "sInfoPostFix":    "",
                                "sLoadingRecords": "Chargement en cours...",
                                "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
                                "sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
                                "oPaginate": {
                                    "sFirst":      "Premier",
                                    "sPrevious":   "Pr&eacute;c&eacute;dent",
                                    "sNext":       "Suivant",
                                    "sLast":       "Dernier"
                                },
                                "oAria": {
                                    "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
                                    "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
                                }
                        }
});
</script>


</body>
</html>
<script>
function recherche(selectElement) {
  document.getElementById("FormData").submit();
}
</script>