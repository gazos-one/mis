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

     <form>

          <div class="col-sm-12">


                   
            



            

          </div>

          </form>
            <!-- jquery validation -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Resultat</h3>
              </div>


              <div class="card-body table-responsive">


            <div class="row">
                  <div class="form-group col-md-2">
                    <label for="ID_TYPE_STRUCTURE">
                     Categorie Structure
                   </label>
                   <select class="form-control" name="ID_TYPE_STRUCTURE" id="ID_TYPE_STRUCTURE" onchange="getstructure(this),liste_search()">
                    <option value="">-- Sélectionner --</option>
                    <?php
                    foreach($periode as $commun){
                     ?>
                     <option value="<?=$commun["ID_TYPE_STRUCTURE"]?>"><?=$commun["DESCRIPTION"]?></option>
                     <?php
                   }
                   ?>

                 </select>
                 
               </div>
               <div class="form-group col-md-2">
                <label for="">Structure sanitaire </label>
              <select class="form-control select2" name="ID_STRUCTURE" id="ID_STRUCTURE" onchange="liste_search()">
                <option value="">-- Sélectionner --</option>

              </select>

            
            </div>

            <div class="form-group col-md-2">
              <label for="">Groupe <i class="text-danger"> *</i>

              </label>

            <select class="form-control select2" name="ID_GROUPE" id="ID_GROUPE" onchange="liste_search()">
                <option value="">-- Sélectionner --</option>
                <?php
                foreach ($groupe as $key => $value) { 
                  ?>
                  <option value="<?=$value['ID_GROUPE']?>"><?=$value['NOM_GROUPE']?></option>
                  <?php
                } 
                ?>
            </select>

             
            </div>
              
              <div class="form-group col-sm-2">

              <label for="ANNEE">

                          Ann&eacute;e

                          </label>

                      <input type="number" id="year" name="year" 
               min="1900" max="2099" step="1" 
               placeholder="YYYY" value="2025" class="form-control"  onblur="liste_search()">
                      </div>

                   
           


            <div class="form-group col-sm-3">

              <label for="ANNEE">

                        Mois

                          </label>

                    <input type="number" id="month" name="month" 
               min="0" max="12" step="1" 
               placeholder="MM" value="0" class="form-control" onblur="liste_search()">
                      </div>

                     </div>


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
  function send(argument) {
    alert('ok')
  }

</script>
  <script>

   function getstructure(va){
    var ID_TYPE_STRUCTURE= $(va).val();
    $('#ID_TYPE_STRUCTURE_ID').val(ID_TYPE_STRUCTURE);



    var selectElement = document.getElementById("ID_TYPE_STRUCTURE");
    var selectedOption = selectElement.options[selectElement.selectedIndex];
    var selectedText = selectedOption.textContent;
    $('#ID_TYPE_STRUCTURE_NEW').val(selectedText);


    $.post('<?php echo base_url('consultation/Pdf_prise_en_charge/getstructure')?>',
      {ID_TYPE_STRUCTURE:ID_TYPE_STRUCTURE},
      function(data){
        $('#ID_STRUCTURE').html(data);
      });
  }
</script>
<script>
  $(document).ready(function(){
      // Initialize the DataTable
      liste_search();

    });

  function liste_search() {
    var url = "<?= base_url() ?>consultation/Pdf_prise_en_charge/listing/";

    var ID_PHARMACIE = $('#ID_PHARMACIE').val();  
    var STATUT_PAIE = $('#STATUT_PAIE').val();
    var year = $('#year').val();
    var month = $('#month').val();

    var ID_TYPE_STRUCTURE = $('#ID_TYPE_STRUCTURE').val();
    var ID_STRUCTURE = $('#ID_STRUCTURE').val();
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
          ID_PHARMACIE: ID_PHARMACIE, 
          STATUT_PAIE: STATUT_PAIE,
          year:year,
          month:month,
          ID_TYPE_STRUCTURE:ID_TYPE_STRUCTURE,
          ID_STRUCTURE:ID_STRUCTURE,
          ID_GROUPE:ID_GROUPE,
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
