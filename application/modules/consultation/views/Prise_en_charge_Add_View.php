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
            <?php 
            if(!empty($this->session->flashdata('message')))
             echo $this->session->flashdata('message');
           ?>
           <div class="card card-primary">


             <div class="card-body">
               <!-- <form id="FormData" action="#" method="POST"> -->
                 <form id="FormData" action="<?php echo base_url()?>consultation/Pdf_prise_en_charge/add" method="POST" enctype="multipart/form-data">
                  <div class="row">

                    <div class="form-group col-md-12">
                      <label for="ID_CONSULTATION_TYPE">
                       Type de consultation
                       <i class="text-danger"> *</i> 

                     </label>
                     <select class="form-control" name="ID_CONSULTATION_TYPE" id="ID_CONSULTATION_TYPE" >
                      <option value="">-- Sélectionner --</option>
                      <?php
                      foreach ($tconsultation as $key => $value) { 
                        ?>
                        <option value="<?=$value['ID_CONSULTATION_TYPE']?>"><?=$value['DESCRIPTION']?></option>
                        <?php
                      } 
                      ?>
                    </select>
                    <?php echo form_error('ID_CONSULTATION_TYPE', '<div class="text-danger">', '</div>'); ?>
                  </div>

                  <div class="form-group col-md-4">
                    <label for="ID_TYPE_STRUCTURE">
                     Categorie Structure
                   </label>
                   <select class="form-control" name="ID_TYPE_STRUCTURE" id="ID_TYPE_STRUCTURE" onchange="getstructure(this)">
                    <option value="">-- Sélectionner --</option>
                    <?php
                    foreach($periode as $commun){
                     ?>
                     <option value="<?=$commun["ID_TYPE_STRUCTURE"]?>"><?=$commun["DESCRIPTION"]?></option>
                     <?php
                   }
                   ?>

                 </select>
                 <?php echo form_error('ID_TYPE_STRUCTURE', '<div class="text-danger">', '</div>'); ?>
               </div>
               <div class="form-group col-md-4">
                <label for="">Structure sanitaire  <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modalsm">
                  (Ajout nouveau Structure sanitaire)
                </button>

              </label>
              <select class="form-control select2" name="ID_STRUCTURE" id="ID_STRUCTURE">
                <option value="">-- Sélectionner --</option>

              </select>

              <?php echo form_error('ID_STRUCTURE', '<div class="text-danger">', '</div>'); ?>
            </div>

            <div class="form-group col-md-4">
              <label for="">Groupe <i class="text-danger"> *</i>

              </label>

              <select class="form-control select2" name="ID_GROUPE" id="ID_GROUPE" onchange="getaffilie_by_group(this)">
                <option value="">-- Sélectionner --</option>
                <?php
                foreach ($groupe as $key => $value) { 
                  ?>
                  <option value="<?=$value['ID_GROUPE']?>"><?=$value['NOM_GROUPE']?></option>
                  <?php
                } 
                ?>
              </select>

              <?php echo form_error('ID_GROUPE', '<div class="text-danger">', '</div>'); ?>
            </div>

            <div class="form-group col-md-4">
              <label for="">Affili&eacute; <i class="text-danger"> *</i>

              </label>

              <select class="form-control select2" name="TYPE_AFFILIE" id="TYPE_AFFILIE" onchange="getaffilie(this)">
                <option value="">-- Sélectionner --</option>

              </select>

              <?php echo form_error('TYPE_AFFILIE', '<div class="text-danger">', '</div>'); ?>
            </div>


            <div class="form-group col-md-4">
              <label for="" id="AFFILIE"> Personne soigné <i class="text-danger"> *</i></label>
              <select class="form-control select2" name="ID_MEMBRE" id="ID_MEMBRE" onchange="getpourcentage(this)">
                <option value="">-- Sélectionner --</option>

              </select>

              <?php echo form_error('ID_MEMBRE', '<div class="text-danger">', '</div>'); ?>
            </div>

            <div class="form-group col-md-4">
              <label for="DATE_CONSULTATION"> Date consultation <i class="text-danger"> *</i></label>
              <input type="date"  max=""  class="form-control" id="DATE_CONSULTATION" name="DATE_CONSULTATION" value="<?=set_value('DATE_CONSULTATION') ?>">

              <?php echo form_error('DATE_CONSULTATION', '<div class="text-danger">', '</div>'); ?>
            </div>

          




          </div>


          <div class="row"><br>
            <div class="col-12 text-center" id="divdata" style="margin-top: 10px">
              <input type="submit" value="Enregistrer" class="btn btn-primary"/>
            </div>
          </div>
        </form>
      </div> 
    </div>


    <div class="modal fade" id="modalsm">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Ajout nouveau structure sanitaire</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="myformsassuree" method="POST" onsubmit="addstucture();return false" accept-charset="utf-8" enctype="multipart/form-data">
              <div class="row">
                <div class="form-group col-md-12">
                  <label for="ID_TYPE_STRUCTURE_NEW">
                   Categorie
                   <i class="text-danger"> *</i>
                 </label>

                 <input type="hidden" name="ID_TYPE_STRUCTURE_ID" class="form-control" value="" id="ID_TYPE_STRUCTURE_ID" readonly="readonly">

                 <input type="text" name="ID_TYPE_STRUCTURE_NEW" class="form-control" value="" id="ID_TYPE_STRUCTURE_NEW" readonly="readonly">

                 <?php echo form_error('ID_TYPE_STRUCTURE_NEW', '<div class="text-danger">', '</div>'); ?>
               </div>
               <div class="form-group col-md-12">
                <label for="NOMSTRUCTURE">
                 Structure Sanitaire
                 <i class="text-danger"> *</i>
               </label>
               <input type="text" name="NOMSTRUCTURE" class="form-control" value="" id="NOMSTRUCTURE">
               <?php echo form_error('NOMSTRUCTURE', '<div class="text-danger">', '</div>'); ?>
             </div>
             <div class="form-group col-md-6">
              <label for="PROVINCE_ID">
               Province
               <i class="text-danger"> *</i>
             </label>
             <select class="form-control"  onchange="province(this)" name="PROVINCE_ID" id="PROVINCE_ID">
              <option value="">-- Sélectionner --</option>
              <?php
              foreach ($province as $key => $value) { 
                ?>
                <option value="<?=$value['PROVINCE_ID']?>"><?=$value['PROVINCE_NAME']?></option>
                <?php
              } 
              ?>
            </select>
            <?php echo form_error('PROVINCE_ID', '<div class="text-danger">', '</div>'); ?>
          </div>
          <div class="form-group col-md-6">
            <label for="COMMUNE_ID">
             Commune
             <i class="text-danger"> *</i>
           </label>
           <select class="form-control"  aria-describedby="emailHelp" name="COMMUNE_ID" id="COMMUNE_ID">
            <option value="">-- Sélectionner --</option>
            <?php
            foreach ($commune as $key => $value) { 
              ?>
              <option value="<?=$value['COMMUNE_ID']?>"><?=$value['COMMUNE_NAME']?></option>
              <?php
            } 
            ?>
          </select>
          <?php echo form_error('COMMUNE_ID', '<div class="text-danger">', '</div>'); ?>
        </div>



      </div>                                    
    </div>
    <div class="modal-footer justify-content-between">
      <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
      <input type="submit" value="Enregistrer" class="btn btn-primary"/>
    </div>
  </div>
</form>
</div>
</div>


<div class="modal fade" id="modalcoar">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Ajout nouveau Centre Optique</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="myformsassuree" method="POST" onsubmit="addcentreoptique();return false" accept-charset="utf-8" enctype="multipart/form-data">
          <div class="row">

           <div class="form-group col-md-12">
            <label for="DESCRIPTION">
             Centre optique
             <i class="text-danger"> *</i>
           </label>
           <input type="text" name="DESCRIPTION" class="form-control" value="" id="DESCRIPTION">
           <?php echo form_error('DESCRIPTION', '<div class="text-danger">', '</div>'); ?>
         </div>
         <div class="form-group col-md-6">
          <label for="PROVINCE_ID">
           Province
           <i class="text-danger"> *</i>
         </label>
         <select class="form-control"  onchange="provinces(this)" name="PROVINCE_IDCO" id="PROVINCE_IDCO">
          <option value="">-- Sélectionner --</option>
          <?php
          foreach ($province as $key => $value) { 
            ?>
            <option value="<?=$value['PROVINCE_ID']?>"><?=$value['PROVINCE_NAME']?></option>
            <?php
          } 
          ?>
        </select>
        <?php echo form_error('PROVINCE_IDCO', '<div class="text-danger">', '</div>'); ?>
      </div>
      <div class="form-group col-md-6">
        <label for="COMMUNE_ID">
         Commune
         <i class="text-danger"> *</i>
       </label>
       <select class="form-control"  aria-describedby="emailHelp" name="COMMUNE_IDCO" id="COMMUNE_IDCO">
        <option value="">-- Sélectionner --</option>
        <?php
        foreach ($commune as $key => $value) { 
          ?>
          <option value="<?=$value['COMMUNE_ID']?>"><?=$value['COMMUNE_NAME']?></option>
          <?php
        } 
        ?>
      </select>
      <?php echo form_error('COMMUNE_IDCO', '<div class="text-danger">', '</div>'); ?>
    </div>



  </div>                                    
</div>
<div class="modal-footer justify-content-between">
  <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
  <input type="submit" value="Enregistrer" class="btn btn-primary"/>
</div>
</div>
</form>
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
<!-- jQuery -->

</body>
</html>
<script>
  $(document).ready(function(){ 
    $('#message').delay(5000).hide('slow');
  });
</script>


<script>

 function typeconsul(va){
  var ID_CONSULTATION_TYPE= $(va).val();
      // $('#ID_CONSULTATION_TYPE').val(ID_TYPE_STRUCTURE);

      // alert(ID_CONSULTATION_TYPE);

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

 function getaffilie(va){
  var TYPE_AFFILIE= $(va).val();
  $.post('<?php echo base_url('consultation/Pdf_prise_en_charge/getaffilie')?>',
    {TYPE_AFFILIE:TYPE_AFFILIE},
    function(data){
            // alert(data);
            $('#ID_MEMBRE').html(data);
          });
}
</script>
<script>

 function getaffilie_by_group(va){
  var ID_GROUPE= $('#ID_GROUPE').val();
  $.post('<?php echo base_url('consultation/Pdf_prise_en_charge/getaffilie_by_group')?>',
    {ID_GROUPE:ID_GROUPE},
    function(data){
            // alert(data);
            $('#TYPE_AFFILIE').html(data);
          });
}
</script>

<script>

 function getpourcentage(va){
  var ID_MEMBRE= $(va).val();
  var ID_TYPE_STRUCTURE= $('#ID_TYPE_STRUCTURE').val();
      // alert(ID_MEMBRE)
      $.post('<?php echo base_url('consultation/Pdf_prise_en_charge/getpourcentage')?>',
      {
        ID_MEMBRE:ID_MEMBRE,
        ID_TYPE_STRUCTURE:ID_TYPE_STRUCTURE
      },
      function(data){
            // alert(data);
            $('#POURCENTAGE_C').val(data);
            $('#POURCENTAGE_A').val(data);
          });
    }
  </script>


  <script>

   function calmontant(va){
      // var POURCENTAGE_A= $(va).val();
      var POURCENTAGE_A= $('#POURCENTAGE_A').val();
      var MONTANT_CONSULTATION= $('#MONTANT_CONSULTATION').val();
      var MONTANT_A_PAYERC = MONTANT_CONSULTATION - ((MONTANT_CONSULTATION * POURCENTAGE_A)/100);
      var MONTANT_A_PAYER = MONTANT_CONSULTATION - MONTANT_A_PAYERC;
      $('#MONTANT_A_PAYER').val(MONTANT_A_PAYER);
    }
  </script>
  <script>
    $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
  })
</script>

<script>

  function addstucture(val){
    var ID_TYPE_STRUCTURE_NEW= $('#ID_TYPE_STRUCTURE_ID').val();
    var NOMSTRUCTURE= $('#NOMSTRUCTURE').val();
    var PROVINCE_ID= $('#PROVINCE_ID').val();
    var COMMUNE_ID= $('#COMMUNE_ID').val();

    $.post('<?php echo base_url('consultation/Pdf_prise_en_charge/addStructure')?>',
    {
      ID_TYPE_STRUCTURE_NEW:ID_TYPE_STRUCTURE_NEW,
      NOMSTRUCTURE:NOMSTRUCTURE,
      PROVINCE_ID:PROVINCE_ID,
      COMMUNE_ID:COMMUNE_ID
    },
    function(data){
            // alert(data);
            $('#ID_STRUCTURE').html(data); 
            $('#ID_STRUCTURE').selectpicker('refresh');
          });
    $('#modalsm').modal('hide');

  }

</script>


<script>

  function addcentreoptique(val){
    var DESCRIPTION= $('#DESCRIPTION').val();
    var PROVINCE_IDCO= $('#PROVINCE_IDCO').val();
    var COMMUNE_IDCO= $('#COMMUNE_IDCO').val();

    $.post('<?php echo base_url('consultation/Pdf_prise_en_charge/addCentreOp')?>',
    {
      DESCRIPTION:DESCRIPTION,
      PROVINCE_IDCO:PROVINCE_IDCO,
      COMMUNE_IDCO:COMMUNE_IDCO
    },
    function(data){
            // alert(data);
            $('#ID_CENTRE_OPTIQUE').html(data); 
            $('#ID_CENTRE_OPTIQUE').selectpicker('refresh');
          });
    $('#modalcoar').modal('hide');

  }

</script>
<script>

  function province(va){
   var provine_id= $(va).val();
   $.post('<?php echo base_url('membre/Membre/get_commune')?>',
     {provine_id:provine_id},
     function(data){
       $('#COMMUNE_ID').html(data);
     });
 }
</script>

<script>

  function provinces(va){
   var provine_id= $(va).val();
   $.post('<?php echo base_url('membre/Membre/get_commune')?>',
     {provine_id:provine_id},
     function(data){
       $('#COMMUNE_IDCO').html(data);
     });
 }
</script>

