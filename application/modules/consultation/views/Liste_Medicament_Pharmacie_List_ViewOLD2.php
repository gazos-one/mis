  <?php

  include VIEWPATH.'includes/new_header.php';

  include VIEWPATH.'includes/new_top_menu.php';

  include VIEWPATH.'includes/new_menu_principal.php';

  ?>

  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <?php

    include 'includes/Menu_Liste_Medicament_Pharmacie.php';

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

                <h3 class="card-title">Liste des medicament par pharmacie</h3>

              </div>

              <!-- /.card-header -->

              <!-- form start -->



              <div class="card-body table-responsive">


                <input type="hidden" name="STATUS_PAIEMENT" id="STATUS_PAIEMENT" value="<?=$STATUS_PAIEMENT?>">

                <input type="hidden" name="YEAR" id="YEAR" value="<?=$YEAR?>">

                <table id="mytable" class="table table-bordered table-striped table-hover">
                  <thead>
                    <tr>
                      <th>Structure</th>
                      <th>Nombre</th>
                      <th>Consultation</th>
                      <th>Paye</th>
                      <th>A paye</th>
                      <th>Ann&eacute;e</th>
                      <th>Mois</th>
                      <th>Options</th>
                    </tr>
                  </thead> 
                  <tbody>
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


    <div class="modal fade" id="desactcat" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Liste des Medicaments pris</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <table class='table tabless' id='tabless'><thead>
              <tr>
                <th>Affili&eacute;</th>
                <th>Patient</th>
                <th>Medicament</th>
                <th>Date </th>
                <th>Borderaux</th>
                <th>Q</th>
                <th>PT</th>
                <th>PT MIS</th>
                <th>Groupe</th>
              </tr>
            </thead><tbody>
            </tbody></table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
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

  <script>

    $(document).ready(function() {

      $('.tabless').DataTable();

    } );

  </script>

  <script>
    $(document).ready(function()
    {
      liste();

    });

    function liste(argument) {

      gettotal();

      var ANNEE=$('#ANNEE').val();
      var MOIS=$('#MOIS').val();


      var STATUS_PAIEMENT=$('#STATUS_PAIEMENT').val();

      var row_count ="1000000";

      $("#mytable").DataTable({
        "processing":true,
        "destroy" : true,
        "serverSide":true,
        "order":[],
        "ajax":{
          url:"<?php echo base_url('consultation/Liste_Medicament_Pharmacie/liste');?>",
          type:"POST",
          data:{ANNEE:ANNEE,STATUS_PAIEMENT:STATUS_PAIEMENT,MOIS:MOIS},
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


  <script>

    function gettotal() {


      var ANNEE=$('#ANNEE').val();

      if (ANNEE=='') 
      {
       ANNEE=$('#YEAR').val();

     }

     var STATUS_PAIEMENT=$('#STATUS_PAIEMENT').val();


     $.post('<?php echo base_url('consultation/Liste_Medicament_Pharmacie/get_total')?>',
     {
      YEAR:ANNEE,STATUS_PAIEMENT:STATUS_PAIEMENT


    },
    function(data)
    {
     $('#total').html(data);
   });





   }

 </script>
 <script type="text/javascript">
  function get_detail_histo(id) {
    $("#desactcat").modal('show')
    
    var row_count ="1000000";

    $("#tabless").DataTable({
      "processing":true,
      "destroy" : true,
      "serverSide":true,
      "order":[],
      "ajax":{
        url:"<?php echo base_url('consultation/Liste_Medicament_Pharmacie/details_histo');?>",
        type:"POST",
        data:{id:id},
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

