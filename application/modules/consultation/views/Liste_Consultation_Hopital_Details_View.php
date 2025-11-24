  <?php
  include VIEWPATH.'includes/new_header.php';
  include VIEWPATH.'includes/new_top_menu.php';
  include VIEWPATH.'includes/new_menu_principal.php';
  ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php
    include 'includes/Menu_Liste_Consultation_Hopital.php';
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
                <h3 class="card-title">Details des consultations</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->

 <div class="card-body table-responsive">

<table id="mytable" class="table" style="width:100%">
        <thead>
            <tr>
                <th>Affili&eacute;</th>
                <th>Patient</th>
                <th>Date</th>
                <th>Borderaux</th>
                <th>%</th>
                <th>A payer</th>
                <th>Groupe</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
          <?php
          foreach ($list as $key) {

            // consultation_consultation.ID_CONSULTATION, membre_membre.ID_MEMBRE, IF(membre_membre.IS_AFFILIE = 0, "Affilie", "Ayant droit") AS IS_AFFILIE, consultation_consultation.POURCENTAGE_A, 


            echo'<tr>
            <td>'.$key['ANOM'].' '.$key['APRENOM'].'</td>
            <td>'.$key['NOM'].' '.$key['PRENOM'].'</td>
            <td>'.$key['DATE_CONSULTATION'].'</td>
            <td>'.$key['NUM_BORDERAUX'].'</td>
            <td>'.$key['POURCENTAGE_A'].'</td>
            <td class="text-right">'.number_format($key['MONTANT_A_PAYER'],0,' ',' ').'</td>
            <td>'.$key['NOM_GROUPE'].'</td>
            <td><a class="btn btn-primary btn-sm" href="'.base_url('consultation/Liste_Consultation_Hopital/payement/'.$key['ID_CONSULTATION'].'/'.$key['DATE_CONSULTATION'].'/0').'" role="button">Payer</a></td>
        </tr>';
          }
          ?>
            
            
            
        </tbody>
        
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
