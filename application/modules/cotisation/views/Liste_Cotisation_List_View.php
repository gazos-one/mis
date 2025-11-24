  <?php
  include VIEWPATH.'includes/new_header.php';
  include VIEWPATH.'includes/new_top_menu.php';
  include VIEWPATH.'includes/new_menu_principal.php';
  ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php
    include 'includes/Menu_Liste_Cotisation.php';
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
                <h3 class="card-title">Liste des cotisation</h3>
              </div>

              <form>
          <div class="col-sm-12">
            <div class="row">
            <div class="form-group col-sm-4">
                          <label for="MOIS">
                          MOIS
                             <i class="text-danger"> *</i>
                          </label>
                          <input type="month" id="MOIS" name="MOIS" class="form-control" onchange="liste()" value="" id="MOIS">
            </div>

            <div class="form-group col-md-4">
                <label for="ID_GROUPE">
                          Société
                          </label>
                          <select class="form-control"  onchange="liste()" name="ID_GROUPE" id="ID_GROUPE">
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

              <div class="col-md-4">
                <label for="ID_CATEGORIE_COTISATION">Cat&eacute;gorie </label>
                  <select class="form-control"  onchange="liste()" name="ID_CATEGORIE_COTISATION" id="ID_CATEGORIE_COTISATION">
                  <option value="">-- Sélectionner --</option>
                          <?php
                          foreach ($cotisation as $value) { 
                            if (set_value('ID_CATEGORIE_COTISATION') == $value['ID_CATEGORIE_COTISATION']) {
                            ?>
                            <option value="<?=$value['ID_CATEGORIE_COTISATION']?>" selected><?=$value['DESCRIPTION']?></option>
                            <?php
                            }
                            else{
                              ?>
                              <option value="<?=$value['ID_CATEGORIE_COTISATION']?>"><?=$value['DESCRIPTION']?></option>
                              <?php
                              }
                           } 
                           ?>
                </select><br>
              </div>
            <!-- <div class="form-group col-md-2"><br>
                      <input type="submit" value="Chercher" class="btn btn-primary"/>
            </div> -->
            </div>

            
          </div>
          </form>
              <!-- /.card-header -->
              <!-- form start -->

 <div class="card-body table-responsive">


<input type="hidden" name="IS_RETARD" id="IS_RETARD" value="<?=$is_retard?>">

 <table id="mytable" class="table table-bordered table-striped table-hover">
                  <thead>
                  <tr>
                    <th>Membre</th>
                    <th>Montant</th>
                    <th>Cat&eacute;gorie</th>
                    <th>Mois</th>
                    <th>Societe</th>
                    <th>Enregistr&eacute; le</th>
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
  $(document).ready(function()
  {
  liste();
  });

    function liste(argument) {


    gettotal();

    var MOIS=$('#MOIS').val();
    var ID_GROUPE=$('#ID_GROUPE').val();
    var ID_CATEGORIE_COTISATION=$('#ID_CATEGORIE_COTISATION').val();
    var IS_RETARD=$('#IS_RETARD').val();


    
    
    var row_count ="1000000";

    $("#mytable").DataTable({
      "processing":true,
      "destroy" : true,
      "serverSide":true,
      "order":[],
      "ajax":{
        url:"<?php echo base_url('cotisation/Liste_Cotisation/liste');?>",
        type:"POST",
        data:{MOIS:MOIS,ID_GROUPE:ID_GROUPE,ID_CATEGORIE_COTISATION:ID_CATEGORIE_COTISATION,IS_RETARD:IS_RETARD},
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


    var MOIS=$('#MOIS').val();
    var ID_GROUPE=$('#ID_GROUPE').val();
    var ID_CATEGORIE_COTISATION=$('#ID_CATEGORIE_COTISATION').val();
     $.post('<?php echo base_url('cotisation/Liste_Cotisation/get_total1')?>',
    {
     MOIS:MOIS,ID_GROUPE:ID_GROUPE,ID_CATEGORIE_COTISATION:ID_CATEGORIE_COTISATION
    
   
    },
   function(data)
    {
   $('#chiffre').html(data);
    });



 

}

</script>


<!-- <script type="text/javascript">
      function recherche() {
        var form = document.getElementById("FormData");
        form.submit();
      }
    </script> -->

</body>
</html>
