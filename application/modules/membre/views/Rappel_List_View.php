  <?php
  include VIEWPATH.'includes/new_header.php';
  include VIEWPATH.'includes/new_top_menu.php';
  include VIEWPATH.'includes/new_menu_principal.php';
  ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-4">
            <h1 class="m-0 text-dark">Liste des membres ayants des contrats expires</h1>
          </div><!-- /.col -->
          <div class="col-sm-8">
            <ol class="breadcrumb float-sm-right">
            <li><a class="btn btn-danger">Activer les notifications de rappel ?</a></li>
    
            </ol>

          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
           
            <!-- jquery validation -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->

 <div class="card-body table-responsive">


<table id="mytable" class="table table-bordered table-striped table-hover">
                  <thead>
                  <tr>
                    <th>#</th>
              <th>Nom</th>
              <th>Code</th>
              <th>CNI </th>
              <th>Fin sur la carte</th>
              <th>Tel</th>
              <th>Groupe</th>
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


<div class="modal" id="modificationgroupe" role="dialog">
    <div class="modal-dialog modal-lg ">
      <div class="modal-content">
        <div class="modal-header">
         <h5> Modification du groupe de l'affilié</h5>
         <div >    
          <i class="close fa fa-remove float-left text-primary" data-dismiss="modal"></i>  
          <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
          </button>

        </div>
      </div>
      <div class="modal-body">
        <div class="table-responsive" id="resultatmodif">
          <!-- <table id='mytable3' class="table table-bordered table-striped table-hover table-condensed " style="width: 100%;"> -->
            <!-- <thead>
              <tr>
                <th>#</th>
                <th>ASSURANCES</th>
              </tr>
            </thead> -->
            <!-- <tbody id="table3">

            </tbody> -->

          <!-- </table> -->

        </div>

      </div>
    </div>
  </div>
</div>


<div class="modal" id="modif_date" role="dialog">
    <div class="modal-dialog modal-lg ">
      <div class="modal-content">
        <div class="modal-header">
         <h5> Modification de la date fin pour une carte</h5>
         <div >    
          <i class="close fa fa-remove float-left text-primary" data-dismiss="modal"></i>  
          <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
          </button>

        </div>
      </div>
      <div class="modal-body">
        <div class="table-responsive" id="resultatmodif2">
         
        </div>

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
  $(document).ready(function()
  {
  my_liste();
  });

    function my_liste() {

    var row_count ="1000000";

    $("#mytable").DataTable({
      "processing":true,
      "destroy" : true,
      "serverSide":true,
      "order":[],
      "ajax":{
        url:"<?php echo base_url('membre/Rappel/liste');?>",
        type:"POST",
        data:{},
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

 <script type="text/javascript">
      function recherche() {
        var form = document.getElementById("FormData");
        form.submit();
      }
    </script>

<script type="text/javascript">
  function get_modal(id) {
  
   $("#modificationgroupe").modal("show");



      $.post('<?php echo base_url('membre/Membre/modificationgroupe')?>',
          {id:id},
          function(data){
            $('#resultatmodif').html(data);
          });
  }
</script>

<script type="text/javascript">
  function send_modif(argument) {
   var ID_GROUPE=$('#ID_GROUPE2').val();
   var ID_MEMBRE=$('#ID_MEMBRE').val();

   var statut=1;
  

   if (ID_GROUPE=="") {
    statut=0;
    $("#erID_GROUPE").html("Champ obligatoire");
   }else{
    $("#erID_GROUPE").html("");
   }



    var myform=document.getElementById('FormDatachange');
    if (statut==1) {
    myform.submit();
    }



  }
</script>

<script type="text/javascript">
  function get_membre2(id) 
  {
    
     $("#modif_date").modal("show");

      $.post('<?php echo base_url('membre/Membre/modif_date')?>',
          {id:id},
          function(data){
            $('#resultatmodif2').html(data);
          });
  }
</script>
</html>
