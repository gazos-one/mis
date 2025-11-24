  <?php
  include VIEWPATH.'includes/new_header.php';
  include VIEWPATH.'includes/new_top_menu.php';
  include VIEWPATH.'includes/new_menu_principal.php';
  ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php
    include 'includes/Menu_Recherche.php';
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
              <!-- /.card-header -->
              <!-- form start -->

              <div class="card-body table-responsive">
               <div class="col-md-12">
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                  <label for="ID_GROUPE">
                   Groupe
                 </label>
                 <select class="form-control select2"  onchange="liste_search()" name="ID_GROUPE" id="ID_GROUPE">
                  <option value="">-- Sélectionner --</option>
                  <?php
                  foreach ($groupes as $keys) { 
                    if ($keys['ID_GROUPE']==set_value('ID_GROUPE')) {
                      ?>
                      <option value="<?=$keys['ID_GROUPE']?>" selected><?=$keys['NOM_GROUPE']?></option>
                      <?php
                    }
                    else{                            
                      ?>
                      <option value="<?=$keys['ID_GROUPE']?>"><?=$keys['NOM_GROUPE']?></option>
                      <?php
                    }
                  } 
                  ?> 
                </select>
                <br>
              </div>

            </div>
            <?php 
            if(!empty($this->session->flashdata('message')))
             echo $this->session->flashdata('message');
               // echo $this->table->generate($chamb);
           ?>

           <table id="mytable" class="table table-bordered table-striped" style="width:100%">
            <thead>
              <tr>
                <th>Nom Complet</th>
                <th>Code Affiliation</th>
                <th>CNI</th>
                <th>Date Adhésion</th>
                <th>Âge</th>
                <th>Groupe</th>
                <th>Statut</th>
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



<script>
  $(document).ready(function(){ 
    $('#message').delay(5000).hide('slow');
    liste_search();

  });
</script>



<script type="text/javascript">
  // With JQuery
  $("#ex2").slider({});

// Without JQuery
var slider = new Slider('#ex2', {});
</script>


<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->


<script>
  $(document).ready(function(){
      // Initialize the DataTable
      liste_search();

      $('#submit').click(function(event){
          event.preventDefault(); // Prevent the default form submission
          handleFormSubmission();
        });
    });

  function liste_search() {
    var url = "<?= base_url() ?>recherche/Recherche/search_data/";

    var customRadio = $("input[name='customRadio']:checked").val();
    var ageMin = $('#ageMin').val();  
    var ageMax = $('#ageMax').val();  
    var ID_GROUPE = $('#ID_GROUPE').val();  

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
          customRadio: customRadio,
          ageMin: ageMin,
          ageMax: ageMax,
          ID_GROUPE: ID_GROUPE

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

  function handleFormSubmission() {
    var radioValue = $("input[name='customRadio']:checked").val();
    var ageMin = $('#ageMin').val();
    var ageMax = $('#ageMax').val();
    console.log(ageMax)

    // Validate inputs...
    if (!radioValue) {
      $('#chec_error').text("Veuillez sélectionner une option.");
      return;
    } else {
      $('#chec_error').text('');
    }

    if (!ageMin) {
      $('#ageRange_error').text("Veuillez préciser une tranche d'âge");
      return;
    } else {
      $('#ageRange_error').text('');
    }

    
    if (!ageMax) {
      $('#ageRange_error').text("Veuillez préciser une tranche d'âge");
      return;
    } else {
      $('#ageRange_error').text('');
    }
    liste_search();

    // Make sure to refresh the DataTable with the new filters
    // $('#mytable').DataTable().draw(); // This will trigger the DataTable to fetch new data
  }
</script>

<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
  })
  </script
</body>
</html>
