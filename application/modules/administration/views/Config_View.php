 <?php
  include VIEWPATH.'includes/new_header.php';
  include VIEWPATH.'includes/new_top_menu.php';
  include VIEWPATH.'includes/new_menu_principal.php';
  ?>
  

    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
  <?php include "includes/Menu_Config.php";?>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
              <!-- <div class="card-header"> -->
                <!-- <h3 class="card-title">Liste des regimes d'assurance</h3>  -->
              <!-- </div> -->
              <!-- /.card-header -->
              <!-- form start -->

        <div class="card-body table-responsive">




       <?php 
             if(!empty($this->session->flashdata('message')))
               echo $this->session->flashdata('message');
               // echo $this->table->generate($employe);
            ?>

            <table class="table">
              <tr style="background-color: #5bc0de" >
                  <td>Description</td>
                  <td>Valeur actuelle</td>
                  <td style="width: 290px;">Nouvelle valeur</td>
                </tr>
                
                <tr>
                  <td>L'âge minimum pour l'affili&eacute; (C'est l'age qu'une personne doit avoir pour etre enregistrer comme affil&eacute;)</td>
                  <td><?php echo $conf['AGE_MINIMALE_AFFILIE']?></td>
                  <td>
                    <form id="FormData" action="<?php echo base_url()?>administration/Config/update_Ageminaff" method="POST" enctype="multipart/form-data">
                      <div class="input-group input-group-sm">
                  <input type="text" name="AGE_MINIMALE_AFFILIE" required="required" class="form-control">
                  <span class="input-group-append">
                    <input type="submit" value="Enregistrer" class="btn btn-primary"/>
                  </span>
                </div>
                    </form>
                  </td>
                </tr>
                <tr>
                  <td>Durée  de validité de la carte d'assurance MIS santé (Après cette pariode la carte devient invalide)</td>
                  <td><?php echo $conf['DUREE_CARTE']?></td>
                  <td>
                    <form id="FormData" action="<?php echo base_url()?>administration/Config/update_Dureecarte" method="POST" enctype="multipart/form-data">
                      <div class="input-group input-group-sm">
                  <input type="text" name="DUREE_CARTE" required="required" class="form-control">
                  <span class="input-group-append">
                    <input type="submit" value="Enregistrer" class="btn btn-primary"/>
                  </span>
                </div>
                    </form>
                  </td>
                </tr>
                <tr>
                  <td>Age maximale de l'affilie non conjoint pour etre sur une carte (Arrive a cette age on recoir une notification que la carte doit etre modifie)</td>
                  <td><?php echo $conf['AGE_MAXIMALE_AFFILIE_NON_CONJOIN_SUR_CARTE']?></td>
                  <td>
                    <form id="FormData" action="<?php echo base_url()?>administration/Config/update_age_max" method="POST" enctype="multipart/form-data">
                      <div class="input-group input-group-sm">
                  <input type="text" name="AGE_MAXIMALE_AFFILIE_NON_CONJOIN_SUR_CARTE" required="required" class="form-control">
                  <span class="input-group-append">
                    <input type="submit" value="Enregistrer" class="btn btn-primary"/>
                  </span>
                </div>
                    </form>
                  </td>
                </tr>

            </table>


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
