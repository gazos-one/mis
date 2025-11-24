  <?php
  include VIEWPATH.'includes/new_header.php';
  include VIEWPATH.'includes/new_top_menu.php';
  include VIEWPATH.'includes/new_menu_principal.php';
  ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php
    include 'includes/Menu_Prise_Charge_View.php';
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
                <h3 class="card-title">Resultat</h3>
              </div>


              <div class="card-body table-responsive">


               <?php 
               if(!empty($this->session->flashdata('message')))
                 echo $this->session->flashdata('message');
               // echo $this->table->generate($chamb);
               ?>

               <table id="mytable" class="table table-bordered table-striped " style="width:100%">
                <thead>
                  <tr>
                   <th>Date</th>
                   <th>Categorie</th>                  
                   <th>Structure</th>
                   <th>Affilie</th>
                   <th>Beneficiaire</th>
                   <th>Actions</th>
                 </tr>
               </thead>
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







<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->


<script>
  $(document).ready(function(){
      // Initialize the DataTable
      liste_search();

    });

  function liste_search() {
    var url = "<?= base_url() ?>consultation/Pdf_prise_en_charge/listing/";

    var ID_PHARMACIE = $('#ID_PHARMACIE').val();  
    var STATUT_PAIE = $('#STATUT_PAIE').val(); 

    var row_count = "1000000";
    table = $("#mytable").DataTable({
      "processing": true,
      "destroy": true,
      "serverSide": true,
      "order": [
      [0, 'desc']
      ],
      "ajax": {
        url: url,
        type: "POST",
        data: {
          ID_PHARMACIE: ID_PHARMACIE,
          STATUT_PAIE: STATUT_PAIE
        },

      },
      lengthMenu: [
      [5, 10, 50, 100, row_count],
      [5, 10, 50, 100, "All"]
      ],
      pageLength: 10,
      "columnDefs": [{
        "targets": [],
        "orderable": false
      }],

      dom: 'Bfrtlip',
      buttons: ['copy', 'excel', 'pdf'],
      language: {
        "sProcessing": "Traitement en cours...",
        "sSearch": "Rechercher&nbsp;:",
        "sLengthMenu": "Afficher _MENU_ &eacute;l&eacute;ments",
        "sInfo": "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
        "sInfoEmpty": "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
        "sInfoFiltered": "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
        "sInfoPostFix": "",
        "sLoadingRecords": "Chargement en cours...",
        "sZeroRecords": "Aucun &eacute;l&eacute;ment &agrave; afficher",
        "sEmptyTable": "Aucune donn&eacute;e disponible dans le tableau",
        "oPaginate": {
          "sFirst": "Premier",
          "sPrevious": "Pr&eacute;c&eacute;dent",
          "sNext": "Suivant",
          "sLast": "Dernier"
        },
        "oAria": {
          "sSortAscending": ": activer pour trier la colonne par ordre croissant",
          "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
        }
      }
    });
  }


</script>


<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
  })
</script>
</body>
</html>
