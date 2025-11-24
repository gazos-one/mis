  <?php
  include VIEWPATH.'includes/new_header.php';
  include VIEWPATH.'includes/new_top_menu.php';
  include VIEWPATH.'includes/new_menu_principal.php';
  ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php
    include 'includes/Menu_Membre.php';
    ?> 

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <form id="FormData" action="<?php echo base_url()?>membre/Membre/listing" method="POST">
            <div class="col-md-12 row">
              
              <div class="col-md-2">
                <label for="IS_AFFILIE">
                             Type de membre
                          </label>
                          <select class="form-control" name="IS_AFFILIE" id="IS_AFFILIE" onchange="recherche()">
                          <option value="">-- Sélectionner --</option>
                          <option value="0" <?php if ($IS_AFFILIE == 0) { echo "selected";}?> >Affilie</option>
                          <option value="1" <?php if ($IS_AFFILIE == 1) { echo "selected";}?>>Ayant Droit</option>
                          <option value="2" <?php if ($IS_AFFILIE == 2) { echo "selected";}?>>Affilie & Ayant Droit</option>
                          </select><br>
              </div>
              <div class="col-md-2">
                <label for="ANNE">
                             Ann&eacute; d'affiliation
                          </label>
                          <select class="form-control"  onchange="recherche()" name="DATE_ADHESION" id="DATE_ADHESION">
                          <option value="1">-- Tout --</option>
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
              <div class="col-md-2">
                <label for="MOIS">
                             Mois d'affiliation
                          </label>
                          <select class="form-control"  onchange="recherche()" name="MOIS" id="MOIS">
                          <option value="">-- Sélectionner --</option>
                          <?php
                          foreach ($mois_aff as $keys) { 
                            if ($keys['MOIS']==$MOIS) {
                              ?>
                              <option value="<?=$keys['MOIS']?>" selected><?=$keys['MOIS']?></option>
                              <?php
                            }
                            else{                            
                              ?>
                              <option value="<?=$keys['MOIS']?>"><?=$keys['MOIS']?></option>
                              <?php
                              }
                           } 
                           ?> 
                          </select><br>
              </div>

              <div class="col-md-2">
                <label for="ID_SEXE">
                             Sexe
                          </label>
                          <select class="form-control"  onchange="recherche()" name="ID_SEXE" id="ID_SEXE">
                          <option value="">-- Sélectionner --</option>
                          <?php
                          foreach ($sexe_nom as $keys) { 
                            if ($keys['ID_SEXE']==$ID_SEXE) {
                              ?>
                              <option value="<?=$keys['ID_SEXE']?>" selected><?=$keys['DESCRIPTION']?></option>
                              <?php
                            }
                            else{                            
                              ?>
                              <option value="<?=$keys['ID_SEXE']?>"><?=$keys['DESCRIPTION']?></option>
                              <?php
                              }
                           } 
                           ?> 
                          </select><br>
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

              <div class="col-md-2">
                <label for="ID_GROUPE">
                             Groupe
                          </label>
                          <select class="form-control"  onchange="recherche()" name="ID_GROUPE" id="ID_GROUPE">
                          <option value="">-- Sélectionner --</option>
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

              <div class="col-md-2">
                <label for="STATUS">
                             Status
                          </label>
                          <select class="form-control"  onchange="recherche()" name="STATUS" id="STATUS">
                          <option value="2" <?php if ($STATUS == 2) { echo 'selected';}?>>Sélectionner</option>
                          <option value="1" <?php if ($STATUS == 1) { echo 'selected';}?>>Actif</option>
                          <option value="0" <?php if ($STATUS == 0) { echo 'selected';}?>>Innactif</option>
                          </select><br>
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
            <!-- jquery validation -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Liste des Affili&eacute;s</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->

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


<div class="modal" id="modificationgroupe" role="dialog">
    <div class="modal-dialog modal-lg ">
      <div class="modal-content">
        <div class="modal-header">
         <h5> Modification du groupe de l'affilié</h5>
         <div >    
          <i class="close fa fa-remove float-left text-primary" data-dismiss="modal"></i>  
          <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
          </button>

        </div>
      </div>
      <div class="modal-body">
        <div class="table-responsive" id="resultatmodif">
          <!-- <table id='mytable3' class="table table-bordered table-striped table-hover table-condensed " style="width: 100%;"> -->
            <!-- <thead>
              <tr>
                <th>#</th>
                <th>ASSURANCES</th>
              </tr>
            </thead> -->
            <!-- <tbody id="table3">

            </tbody> -->

          <!-- </table> -->

        </div>

      </div>
    </div>
  </div>
</div>


<div class="modal" id="modif_date" role="dialog">
    <div class="modal-dialog modal-lg ">
      <div class="modal-content">
        <div class="modal-header">
         <h5> Modification de la date fin pour une carte</h5>
         <div >    
          <i class="close fa fa-remove float-left text-primary" data-dismiss="modal"></i>  
          <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
          </button>

        </div>
      </div>
      <div class="modal-body">
        <div class="table-responsive" id="resultatmodif2">
         
        </div>

      </div>
    </div>
  </div>
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

 <script type="text/javascript">
      function recherche() {
        var form = document.getElementById("FormData");
        form.submit();
      }
    </script>

<script type="text/javascript">
  function get_modal(id) {
  
   $("#modificationgroupe").modal("show");



      $.post('<?php echo base_url('membre/Membre/modificationgroupe')?>',
          {id:id},
          function(data){
            $('#resultatmodif').html(data);
          });
  }
</script>

<script type="text/javascript">
  function send_modif(argument) {
   var ID_GROUPE=$('#ID_GROUPE2').val();
   var ID_MEMBRE=$('#ID_MEMBRE').val();

   var statut=1;
  

   if (ID_GROUPE=="") {
    statut=0;
    $("#erID_GROUPE").html("Champ obligatoire");
   }else{
    $("#erID_GROUPE").html("");
   }



    var myform=document.getElementById('FormDatachange');
    if (statut==1) {
    myform.submit();
    }



  }
</script>

<script type="text/javascript">
  function get_membre2(id) 
  {
    
     $("#modif_date").modal("show");

      $.post('<?php echo base_url('membre/Membre/modif_date')?>',
          {id:id},
          function(data){
            $('#resultatmodif2').html(data);
          });
  }
</script>
</html>
