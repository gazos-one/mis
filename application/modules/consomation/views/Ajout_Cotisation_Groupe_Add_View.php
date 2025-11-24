  <?php
  include VIEWPATH.'includes/new_header.php';
  include VIEWPATH.'includes/new_top_menu.php';
  include VIEWPATH.'includes/new_menu_principal.php';
  ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php
    include 'includes/Menu_Ajout_Cotisation.php';
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
                <h3 class="card-title">Enregistrement des cotisations des membres des groupes</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form id="FormData" action="<?php echo base_url()?>cotisation/Ajout_Cotisation/addgroupe" method="POST">
              <div class="row">
                        <div class="form-group col-md-4">
                          <label for="MOIS_DEBUT_COTISATION">
                             Debut du mois de cotisation
                             <i class="text-danger"> *</i>
                          </label>
                          <input type="date"  max=""  class="form-control" id="MOIS_DEBUT_COTISATION" name="MOIS_DEBUT_COTISATION" value="<?=set_value('MOIS_DEBUT_COTISATION') ?>">
                        
                          <?php echo form_error('MOIS_DEBUT_COTISATION', '<div class="text-danger">', '</div>'); ?>                        
                       </div>
                       <div class="form-group col-md-4">
                          <label for="MOIS_FIN_COTISATION">
                             Fin du mois de cotisation
                             <i class="text-danger"> *</i>
                          </label>
                          <input type="date"  max=""  class="form-control" id="MOIS_FIN_COTISATION" name="MOIS_FIN_COTISATION" value="<?=set_value('MOIS_FIN_COTISATION') ?>">
                        
                          <?php echo form_error('MOIS_FIN_COTISATION', '<div class="text-danger">', '</div>'); ?>

                                               
                       </div>
                       <div class="form-group col-md-4">
                          <label for="ID_GROUPE">
                             Groupe
                             <i class="text-danger"> *</i>
                          </label>
                          <select class="form-control select2" onchange="getMembregroupe()" style="width: 100%;" id="ID_GROUPE" name="ID_GROUPE">
                    <option> Selectionner le groupe</option>
                    <?php 
                          foreach ($groupe as $value) {
                            ?>
                    <option value="<?php echo $value['ID_GROUPE']?>"><?php echo $value['NOM_GROUPE']?> </option>
                          <?php
                        }
                          ?>
                  </select> 
                        

                                               
                       </div>
                       </div>
<!-- <div class="col-md-4"></div> -->
<!-- <div class="col-md-4"></div> -->
 <div class="card-body table-responsive">




       <?php 
             if(!empty($this->session->flashdata('message')))
               echo $this->session->flashdata('message');
               // echo $this->table->generate($chamb);
            ?>
            
<div id="resultat"></div>


          </div> 
          </form>
          
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


<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
  })
</script>

<script>
function getMembregroupe(){
   
  var MOIS_DEBUT_COTISATION= $('#MOIS_DEBUT_COTISATION').val();
  var MOIS_FIN_COTISATION= $('#MOIS_FIN_COTISATION').val();
  var ID_GROUPE= $('#ID_GROUPE').val();
  // alert(MOIS_DEBUT_COTISATION);
  // alert(MOIS_FIN_COTISATION);
  // alert(ID_MEMBRE);
  $.post('<?php echo base_url('cotisation/Ajout_Cotisation/getMembregroupe')?>',
          {
            MOIS_DEBUT_COTISATION:MOIS_DEBUT_COTISATION,
            MOIS_FIN_COTISATION:MOIS_FIN_COTISATION,
            ID_GROUPE:ID_GROUPE
          },
          function(data){
            // alert(data);
            $('#resultat').html(data); 
          });
}
</script>

</body>
</html>
