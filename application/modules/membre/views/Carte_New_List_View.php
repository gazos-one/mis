  <?php
  include VIEWPATH.'includes/new_header.php';
  include VIEWPATH.'includes/new_top_menu.php';
  include VIEWPATH.'includes/new_menu_principal.php';
  ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php
    include 'includes/Menu_Carte.php';
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
                <h3 class="card-title">Liste des Cartes des affili&eacute;s</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->

              <!-- <form id="FormData" action="<?php echo base_url()?>membre/Carte_New/listing" method="POST"> -->
            <div class="col-md-12 row">
              
              
              <div class="col-md-12">
                <label for="ANNE">
                             Ann&eacute; d'affiliation
                          </label>
                          <select class="form-control"  onchange="get_liste()" name="DATE_ADHESION" id="DATE_ADHESION">
                          <option value="">-- Sélectionner --</option>
                          <?php
                          foreach ($anne_aff as $keys) { 
                            if ($keys['DATE_ADHESION']==$DATE_ADHESION) {
                              ?>
                              <option value="<?=$keys['DATE_ADHESION']?>" selected><?=$keys['DATE_ADHESION']?></option>
                              <?php
                            }
                            else{                            
                              ?>
                              <option value="<?=$keys['DATE_ADHESION']?>"><?=$keys['DATE_ADHESION']?></option>
                              <?php
                              }
                           } 
                           ?> 
                          </select><br>
              </div>

              <!-- <div class="col-md-3">
                <label for="IS_TAKEN">
                             Carte Prise
                          </label>
                        <select class="form-control"  onchange="recherche()" name="IS_TAKEN" id="IS_TAKEN">
                          <option value="3" <?php if ($IS_TAKEN == 3) {echo 'selected';} ?>>Tout</option>
                          <option value="1" <?php if ($IS_TAKEN == 1) {echo 'selected';} ?>>Prise</option>  
                          <option value="0" <?php if ($IS_TAKEN == 0) {echo 'selected';} ?>>Non Prise</option>
                        </select>
                        <br>
              </div> -->

              <!-- <div class="col-md-3">
                <label for="PROVINCE_ID">
                             Groupe
                          </label>
                          <select class="form-control"  onchange="province(this)" name="DATE_ADHESION" id="DATE_ADHESION">
                          <option value="">-- Sélectionner --</option>
                          <?php
                          foreach ($anne_aff as $keys) { 
                              ?>
                              <option value="<?=$keys['DATE_ADHESION']?>"><?=$keys['DATE_ADHESION']?></option>
                              <?php
                           } 
                           ?> 
                          </select><br>
              </div> -->

              <!-- <div class="col-md-3">
                <label for="ID_GROUPE">
                             Groupe
                          </label>
                          <select class="form-control"  onchange="recherche()" name="ID_GROUPE" id="ID_GROUPE">
                          <option value="">-- Tout --</option>
                          <?php
                          foreach ($groupe as $value) { 
                            if ($ID_GROUPE == $value['ID_GROUPE']) {
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
              </div> -->

              <!-- <div class="col-md-3">
                <label for="STATUS">
                             Actif
                          </label>
                          <select class="form-control"  onchange="recherche()" name="STATUS" id="STATUS">
                          <option value="1" <?php if ($STATUS == 1) {echo 'selected';} ?>>Oui</option>
                          <option value="0" <?php if ($STATUS == 0) {echo 'selected';} ?>>Non</option>
                          </select>
                          <br>
              </div> -->
              <!-- <div class="col-md-2">
                <label for="ID_CATEGORIE_ASSURANCE">
                             Categorie Assurance
                          </label>
                          <select class="form-control"  onchange="recherche()" name="ID_CATEGORIE_ASSURANCE" id="ID_CATEGORIE_ASSURANCE">
                          <option value="">-- Sélectionner --</option>
                           <?php
                          foreach ($acategorie as $keys) { 
                            if ($keys['ID_CATEGORIE_ASSURANCE'] == $ID_CATEGORIE_ASSURANCE) {
                              ?>
                              <option value="<?=$keys['ID_CATEGORIE_ASSURANCE']?>"><?=$keys['DESCRIPTION']?></option>
                              <?php
                            }
                            else{
                              ?>
                              <option value="<?=$keys['ID_CATEGORIE_ASSURANCE']?>"><?=$keys['DESCRIPTION']?></option>
                              <?php
                              }
                           } 
                           ?>
                          </select><br>
              </div> -->
              
            
            </div>
            <!-- </form> -->

 <div class="card-body table-responsive">




       <?php 
             if(!empty($this->session->flashdata('message')))
               echo $this->session->flashdata('message');
              //  echo $this->table->generate($chamb);
            ?>
  <table id="example1" class="table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th>Nom</th>
        <th>Code</th>
        <th>CNI</th>
        <th>Debut</th>
        <th>Fin</th>
        <th>AD</th>
        <th>Groupe</th>
        <th>Status</th>
        <th>Option</th>
      </tr>
    </thead>
    <tbody class="tbody">
     
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
  <div class="modal" id="get_client_affilie_modal" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
       <h5> Membre de la carte</h5>
       <div>    
        <i class="close fa fa-remove float-left text-primary" data-dismiss="modal"></i>  
        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>

      </div>
    </div>
    <div class="modal-body">
      <div class="table-responsive">
        <table id='mytable2' class="table table-bordered table-striped table-hover table-condensed " style="width: 100%;">
          <thead>
          <tr>
          <td>Nom & Prenom</td>
           <td>CNI</td>
           <td>Date Naissance</td>
           <td>Sexe</td>
           <td>Residence</td>
           <td>GS</td>
           <td>Validite carte</td>
           </tr>
          </thead>
          <tbody id="table2">

          </tbody>

        </table>

      </div>

    </div>
  </div>
</div>
</div>


<div class="modal" id="modificationduree_modal" role="dialog">
    <div class="modal-dialog modal-lg ">
      <div class="modal-content">
        <div class="modal-header">
         <h5> Modification de la durree des assurances </h5>
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
<!-- 
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
</script> -->


</body>
</html>
<!-- <script>
function recherche(selectElement) {
  document.getElementById("FormData").submit();
}
</script> -->
<script> 
 $(document).ready(function(){
  get_liste()   
  // alert('jjj');
}); 
 
</script>

<script>
// $(document).ready(function(){
  function get_liste() {
    $('#message_m').delay('slow').fadeOut(3000);
$('#msgs').delay('slow').fadeOut(3000);
    var row_count ="1000000";
    var DATE_ADHESION=$('#DATE_ADHESION').val();
    // alert(DATE_ADHESION);
    if (DATE_ADHESION=="") {
      DATE_ADHESION=0;
    }
    // if (IS_TAKEN=="") {
    //   IS_TAKEN=3;
    // }

 // var url_link='requerant/List_Requerant/liste/'+DATE_PRELEVEMENT+"/"+SEXE_ID+"/"+REQUERANT_STATUT_ID+"/"+COUNTRY_ID;
 var url_link='<?=base_url()?>membre/Carte_New/listing/'+DATE_ADHESION;
$("#example1").DataTable({
        // "processing":true,
        // "serverSide":true,
        "processing":true,
      "serverSide":true,
       "destroy" : true, 
        "order": [[0, "desc" ]],
        "ajax":{
            url:url_link,
            type:"POST",
            data:{

              DATE_ADHESION:DATE_ADHESION,
            // DATE_PRELEVEMENT:DATE_PRELEVEMENT,


            } 
        },
    lengthMenu: [[10,50, 100, row_count], [10,50, 100, "All"]],
    pageLength: 10,
        "columnDefs":[{
            "targets":[],
            "orderable":true
        }],

                  dom: 'Bfrtlip',
    buttons: [
    ],
       language: {
                "sProcessing":     "<div class='progress active'><div class='progress-bar progress-bar-striped progress-bar-animated' role='progressbar' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' style='width: 75%'></div></div>",
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
  

   
// }); 
  </script>
  <script type="text/javascript">
    function send_modif(argument) {
    
    var date1=$('#DEBUT_SUR_LA_CARTE').val();
    var date2=$('#FIN_SUR_LA_CARTE').val();
    
 
    var statut=1;


    if (date1.trim() ==='') {
    statut=0;
    $('#erDEBUT_SUR_LA_CARTE').html("Champ obligatoire");

    }else{
  
    $('#erDEBUT_SUR_LA_CARTE').html("");
 
    }

    if (date2.trim() ==='') {
    statut=0;
    $('#erFIN_SUR_LA_CARTE').html("Champ obligatoire");

    }else{
   
    $('#erFIN_SUR_LA_CARTE').html("");
 
    }

    var date3 = new Date($('#DEBUT_SUR_LA_CARTE').val());
    var date4 = new Date($('#FIN_SUR_LA_CARTE').val());

   if (date4 < date3) {
   statut=0;
   $('#erFIN_SUR_LA_CARTE').html("La date fin doit etre superieur a la date debut.");
   } else {
  
   $('#erFIN_SUR_LA_CARTE').html("");
   }
   


    var myform=document.getElementById('FormDatachange');
    if (statut==1) {
    myform.submit();
    }



    }
    
  </script>

<script>
// THIS FUNCTION IS
  
  function modificationduree(id)
  {
   
   $("#modificationduree_modal").modal("show");


  //  var selectElement = document.getElementById("ID_TYPE_STRUCTURE");
  //     var selectedOption = selectElement.options[selectElement.selectedIndex];
  //     var selectedText = selectedOption.textContent;
  //     $('#ID_TYPE_STRUCTURE_NEW').val(selectedText);


      $.post('<?php echo base_url('membre/Carte_New/modificationduree')?>',
          {id:id},
          function(data){
            $('#resultatmodif').html(data);
          });

//    var row_count ="1000000";
//    table=$("#mytable3").DataTable({
//     "processing":true,
//     "destroy" : true,
//     "serverSide":true,
//     "oreder":[[ 0, 'desc' ]],
//     "ajax":{
//       url:"<?=base_url()?>configuration/Client/modificationduree/"+id,
//       type:"POST"
//     },
//     lengthMenu: [[10,50, 100, row_count], [10,50, 100, "All"]],
//     pageLength: 10,
//     "columnDefs":[{
//       "targets":[],
//       "orderable":false
//     }],
//     dom: 'Bfrtlip',
//     buttons: ['excel', 'pdf'],  

//     language: {
//       "sProcessing":     "Traitement en cours...",
//       "sSearch":         "Rechercher&nbsp;:",
//       "sLengthMenu":     "Afficher MENU &eacute;l&eacute;ments",
//       "sInfo":           "Affichage de l'&eacute;l&eacute;ment START &agrave; END sur TOTAL &eacute;l&eacute;ments",
//       "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
//       "sInfoFiltered":   "(filtr&eacute; de MAX &eacute;l&eacute;ments au total)",
//       "sInfoPostFix":    "",
//       "sLoadingRecords": "Chargement en cours...",
//       "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
//       "sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
//       "oPaginate": {
//         "sFirst":      "Premier",
//         "sPrevious":   "Pr&eacute;c&eacute;dent",
//         "sNext":       "Suivant",
//         "sLast":       "Dernier"
//       },
//       "oAria": {
//         "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
//         "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
//       }
//     }

//   });


 }

 function get_client_affilie(id)
 {
    // alert(id)
   $("#get_client_affilie_modal").modal("show");

   var row_count ="1000000";
   table=$("#mytable2").DataTable({
    "processing":true,
    "destroy" : true,
    "serverSide":true,
    "oreder":[[ 0, 'desc' ]],
    "ajax":{
      url:"<?=base_url()?>membre/Carte_New/get_client_affilie/"+id,
      type:"POST"
    },
    lengthMenu: [[10,50, 100, row_count], [10,50, 100, "All"]],
    pageLength: 10,
    "columnDefs":[{
      "targets":[],
      "orderable":false
    }],
    dom: 'Bfrtlip',
    buttons: ['excel', 'pdf'],  

    language: {
      "sProcessing":     "Traitement en cours...",
      "sSearch":         "Rechercher&nbsp;:",
      "sLengthMenu":     "Afficher MENU &eacute;l&eacute;ments",
      "sInfo":           "Affichage de l'&eacute;l&eacute;ment START &agrave; END sur TOTAL &eacute;l&eacute;ments",
      "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
      "sInfoFiltered":   "(filtr&eacute; de MAX &eacute;l&eacute;ments au total)",
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
<!-- <script>
function recherche(selectElement) {
  document.getElementById("FormData").submit();
}
</script> -->