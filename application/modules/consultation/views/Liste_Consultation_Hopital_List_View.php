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
                <h3 class="card-title">Liste des consultations par Stucture sanitaire</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->

 <div class="card-body table-responsive">
  <input type="hidden" name="STATUS_PAYEMENT" id="STATUS_PAIEMENT" value="<?=$STATUS_PAIEMENT;?>">
   <div class="card card-primary card-tabs">
              <div class="card-header p-0 pt-1">
   <ul class="nav nav-tabs" id="configuration-tabs" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#cotisation-content" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Structure sans Pharmacie</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#adhesion-content" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Structure avec Pharmacie </a>
                  </li>
                 

      </ul>
      </div>

              <div class="card-body">
              
</div>
  
            <div class="tab-content" id="custom-tabs-one-tabContent">
                  <div class="tab-pane fade show active" id="cotisation-content" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                    <div class="card-body table-responsive">
                     

 <table id="mytable" class="table table-bordered table-striped table-hover">
                  <thead>
                  <tr>
                    <th>Structure</th>
                    <th>Nombre</th>
                    <th>Consultation</th>
                    <th>A paye</th>
                    <th>A paye par MIS</th>
                    <th>Ann&eacute;e</th>
                    <th>MOIS</th>
                    <th>Apercu</th>
                   <!--  <th>Details</th> -->
                  </tr>
                  </thead> 
                  <tbody>
                     </tbody>

                </table>
                 </div>
                  </div>
                  <div class="tab-pane fade" id="adhesion-content" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                    <div class="card-body table-responsive">

                      <table id="mytable2" class="table table-bordered table-striped table-hover">
                  <thead>
                  <tr>
                    <th>Structure</th>
                    <th>Nombre</th>
                    <th>Consultation</th>
                    <th>A paye</th>
                    <th>MONTANT MIS CONSULTATION</th>
                    <th>MONTANT MIS MEDICAMENT</th>
                    <th>TOTAL MIS</th>


                    <th>Ann&eacute;e</th>
                    <th>MOIS</th>
                    <th>Apercu</th>
                   <!--  <th>Details</th> -->
                  </tr>
                  </thead> 
                  <tbody>
                     </tbody>

                </table>
              </div>
          </div>
        </div>
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
<script>
  $(document).ready(function()
  {
    liste();

     $('#configuration-tabs a').on('shown.bs.tab', function (e) {
    var target = $(e.target).attr("href");
    
    if (target === '#adhesion-content' && !$.fn.DataTable.isDataTable('#mytable2')) {
      liste2();
    } 
    
  });
  });
    function liste(argument) {

    var ANNEE=$('#ANNEE').val();
    var MOIS=$('#MOIS').val();
    var ID_CONSULTATION_TYPE=$('#ID_CONSULTATION_TYPE').val();
    var STATUS_PAIEMENT=$('#STATUS_PAIEMENT').val();
    
    var row_count ="1000000";

    $("#mytable").DataTable({
      "processing":true,
      "destroy" : true,
      "serverSide":true,
      "order":[],
      "ajax":{
        url:"<?php echo base_url('consultation/Liste_Consultation_Hopital/index/');?>",
        type:"POST",
        data:{ANNEE:ANNEE,ID_CONSULTATION_TYPE:ID_CONSULTATION_TYPE,STATUS_PAIEMENT:STATUS_PAIEMENT,MOIS:MOIS},
      },
      lengthMenu: [[10,50, 100, row_count], [10,50, 100, "All"]],
      pageLength: 10,
      "columnDefs":[{
        "targets":[],
        "orderable":false
      }],

      dom: 'Bfrtlip',
      buttons: [
      'pdf', 'excel','colvis'
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
  }

   function liste2(argument) {

    var ANNEE=$('#ANNEE').val();
    var MOIS=$('#MOIS').val();
    var ID_CONSULTATION_TYPE=$('#ID_CONSULTATION_TYPE').val();
    var STATUS_PAIEMENT=$('#STATUS_PAIEMENT').val();
    
    var row_count ="1000000";

    $("#mytable2").DataTable({
      "processing":true,
      "destroy" : true,
      "serverSide":true,
      "order":[],
      "ajax":{
        url:"<?php echo base_url('consultation/Liste_Consultation_Hopital/liste2/');?>",
        type:"POST",
        data:{ANNEE:ANNEE,ID_CONSULTATION_TYPE:ID_CONSULTATION_TYPE,STATUS_PAIEMENT:STATUS_PAIEMENT,MOIS:MOIS},
      },
      lengthMenu: [[10,50, 100, row_count], [10,50, 100, "All"]],
      pageLength: 10,
      "columnDefs":[{
        "targets":[],
        "orderable":false
      }],

      dom: 'Bfrtlip',
      buttons: [
      'pdf', 'excel','colvis'
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
  }
</script>

</body>
</html>
