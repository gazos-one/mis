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
            <div class="card card-primary card-tabs">
              <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="configuration-tabs" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#cotisation-content" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Cotisation</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#adhesion-content" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Frais d'adhesion </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#carte-content" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false">Frais confection de cartes </a>
                  </li>

                </ul>
              </div>

              <div class="card-body">
              

                <div class="row">
            <div class="form-group col-sm-4">
                          <label for="MOIS">
                        ANNEE - MOIS
                             <i class="text-danger"> *</i>
                          </label>
                          <input type="month" id="MOIS" name="MOIS" class="form-control"  value="<?=set_value('MOIS');?>" id="MOIS"  onchange="relais()">
            </div>


              <div class="col-md-4">
                <label for="ID_GROUPE">Croupe </label>
                  <select class="form-control"  onchange="relais()" name="ID_GROUPE" id="ID_GROUPE"  onchange="subb()">
                  <option value="">-- Sélectionner --</option>
                          <?php
                          foreach ($groupe as $value) { 
                            if (set_value('ID_GROUPE') == $value['ID_GROUPE']) {
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
           
            </div>


            
          </div>
                 <div class="tab-content" id="custom-tabs-one-tabContent">
                  <div class="tab-pane fade show active" id="cotisation-content" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                    <div class="card-body table-responsive">
                     
                      <table id="mytable" class="table table-bordered table-striped  table-hover">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Groupe</th>
                            <th>Periode</th>
                            <th>Categorie</th>
                            <th>Nombre membre</th>
                            <th>Prix unitaire</th>
                            <th>Montant total</th>
                            <th>Options</th>
                          </tr>
                        </thead> 
                        <tbody>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="adhesion-content" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                    <div class="card-body table-responsive">
                      <table id="mytable_adhesion" class="table table-bordered table-striped  table-hover">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Groupe</th>
                            <th>Periode</th>
                            <th>Categorie</th>
                            <th>Nombre membre</th>
                            <th>Prix unitaire</th>
                            <th>Montant total</th>
                            <th>Options</th>
                          </tr>
                        </thead> 
                        <tbody>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="carte-content" role="tabpanel" aria-labelledby="custom-tabs-one-messages-tab">
                   <div class="card-body table-responsive">
                     <table id="mytable_carte" class="table table-bordered table-striped  table-hover">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Groupe</th>
                          <th>Periode</th>
                          <th>Categorie</th>
                          <th>Nombre membre</th>
                          <th>Prix unitaire</th>
                          <th>Montant total</th>
                          <th>Options</th>
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
      </div>
    </div>

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

<script>

  $(document).ready(function() {

    $('.tabless').DataTable();

  } );

</script>

<script>
  
function relais(argument) {

   liste();
   liste_adhesion();
   liste_carte();


}

</script>

<script>
  $(document).ready(function()
  {
    liste();
  // Gestionnaire d'événement pour les onglets
  $('#configuration-tabs a').on('shown.bs.tab', function (e) {
    var target = $(e.target).attr("href");
    
    if (target === '#adhesion-content' && !$.fn.DataTable.isDataTable('#mytable_adhesion')) {
      liste_adhesion();
    } 
    else if (target === '#carte-content' && !$.fn.DataTable.isDataTable('#mytable_carte')) {
      liste_carte();
    }
  });
  });

  function liste(argument) {

    var MOIS=$('#MOIS').val();
    var ID_GROUPE=$('#ID_GROUPE').val();


  
    var row_count ="1000000";

    $("#mytable").DataTable({
      "processing":true,
      "destroy" : true,
      "serverSide":true,
      "order":[],
      "ajax":{
        url:"<?php echo base_url('cotisation/Configuration_Cotisation/liste');?>",
        type:"POST",
        data:{MOIS:MOIS,ID_GROUPE:ID_GROUPE},
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


  function liste_adhesion(argument) {

    var MOIS=$('#MOIS').val();
    var ID_GROUPE=$('#ID_GROUPE').val();

    var row_count ="1000000";

    $("#mytable_adhesion").DataTable({
      "processing":true,
      "destroy" : true,
      "serverSide":true,
      "order":[],
      "ajax":{
        url:"<?php echo base_url('cotisation/Configuration_Cotisation/liste_adhesion');?>",
        type:"POST",
        data:{MOIS:MOIS,ID_GROUPE:ID_GROUPE},
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

  function liste_carte(argument) {
  
    var MOIS=$('#MOIS').val();
    var ID_GROUPE=$('#ID_GROUPE').val();


    var row_count ="1000000";

    $("#mytable_carte").DataTable({
      "processing":true,
      "destroy" : true,
      "serverSide":true,
      "order":[],
      "ajax":{
        url:"<?php echo base_url('cotisation/Configuration_Cotisation/liste_carte');?>",
        type:"POST",
        data:{MOIS:MOIS,ID_GROUPE:ID_GROUPE},
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

</body>

</html>

