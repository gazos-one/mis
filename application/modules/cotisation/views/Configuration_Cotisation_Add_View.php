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
            <?php
            if(!empty($this->session->flashdata('message')))
             echo $this->session->flashdata('message');
           ?>
           <div class="card card-primary card-tabs">
            <div class="card-header p-0 pt-1">
              <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Cotisation</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Frais d'adhesion </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#custom-tabs-one-messages" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false">Frais confection de cartes </a>
                </li>

              </ul>
            </div>

            <div class="card-body">
             <!-- <form id="FormData" action="#" method="POST"> -->
               <div class="tab-content" id="custom-tabs-one-tabContent">
                <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                 <form id="FormData" action="<?php echo base_url()?>cotisation/Configuration_Cotisation/add" method="POST" enctype="multipart/form-data">
                  <div class="row">
                    <div class="col-md-12">
                      <h4>Configuration des cotisations</h4>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="MONTANT_COTISATION">
                       Montant de la cotisation
                       <i class="text-danger"> *</i>
                     </label>
                     <input type="number" name="MONTANT_COTISATION" class="form-control" value="<?=set_value('MONTANT_COTISATION')?>" id="MONTANT_COTISATION" required>
                     <?php echo form_error('MONTANT_COTISATION', '<div class="text-danger">', '</div>'); ?>
                   </div>

                   <div class="form-group col-md-6">
                    <label for="AYANT_DROIT">
                      Ayant droit supplémentaires
                      <i class="text-danger">*</i>
                    </label>
                    <div>
                      <label class="radio-inline">
                        <input type="radio" name="AYANT_DROIT" value="1" > Oui
                      </label>
                      <label class="radio-inline">
                        <input type="radio" name="AYANT_DROIT" value="2" checked> Non
                      </label>
                    </div>
                    <?php echo form_error('AYANT_DROIT', '<div class="text-danger">', '</div>'); ?>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="ID_GROUPE">
                     Groupe
                     <i class="text-danger"> *</i> 
                   </label>
                   <select class="form-control select2"  aria-describedby="emailHelp" name="ID_GROUPE" id="ID_GROUPE" required >
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
                  <font color="red" id="erID_GROUPE"></font>
                </div>

                <div class="form-group col-md-6">
                  <label for="ID_CATEGORIE_COTISATION_MEMBRE">
                   Categorie
                   <i class="text-danger"> *</i> 
                   <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modalcat">
                    (Ajouter nouvelle categorie)
                  </button>
                </label>
                <select class="form-control select2"  aria-describedby="emailHelp" name="ID_CATEGORIE_COTISATION" id="ID_CATEGORIE_COTISATION_MEMBRE" onchange="get_nombre_membre()" required >
                  <option value="">-- Sélectionner --</option>
                  <?php
                  foreach ($categorie as $key => $value) { 
                    ?>
                    <option value="<?=$value['ID_CATEGORIE_ASSURANCE']?>"><?=$value['DESCRIPTION']?></option>
                    <?php
                  } 
                  ?>
                </select>
                <?php echo form_error('ID_CATEGORIE_COTISATION_MEMBRE', '<div class="text-danger">', '</div>'); ?>
              </div>

              <div class="form-group col-md-6">
                <label for="">Nombre membre <i class="text-danger"> *</i>

                </label>

                <input type="number" name="NOMBRE" id="NOMBRE"  class="form-control" >
              </div>

              <div class="form-group col-md-6">
                <label for="">Periode <i class="text-danger"> *</i>

                </label>

                <input type="month" name="ID_PERIODE_COTISATION" id="ID_PERIODE_COTISATION" class="form-control" required>


                <?php echo form_error('ID_PERIODE_COTISATION', '<div class="text-danger">', '</div>'); ?>
              </div>

            </div>


            <div class="row"><br>
              <div class="col-12 text-center" id="divdata" style="margin-top: 10px">
                <input type="submit" value="Enregistrer" class="btn btn-primary"/>
              </div>
            </div>
          </form>
        </div>

        <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">

         <form id="FormData" action="<?php echo base_url()?>cotisation/Configuration_Cotisation/add_addhesion" method="POST" enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-12">
              <h4>Configuration des Adhesion</h4>
            </div>

            <div class="form-group col-md-6">
              <label for="MONTANT_COTISATION">
               Montant de la cotisation
               <i class="text-danger"> *</i>
             </label>
             <input type="number" name="MONTANT_COTISATION" class="form-control" value="<?=set_value('MONTANT_COTISATION')?>" id="MONTANT_COTISATION" required>
             <?php echo form_error('MONTANT_COTISATION', '<div class="text-danger">', '</div>'); ?>
           </div>

           <div class="form-group col-md-6">
            <label for="ID_GROUPE">
             Groupe
             <i class="text-danger"> *</i> 
           </label>
           <select class="form-control select2"  aria-describedby="emailHelp" name="ID_GROUPE" id="ID_GROUPE" required >
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
          <font color="red" id="erID_GROUPE"></font>
        </div>

        <div class="form-group col-md-6">
          <label for="ID_CATEGORIE_COTISATION_MEMBRE">
           Categorie
           <i class="text-danger"> *</i> 
           <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modalcat">
            (Ajouter nouvelle categorie)
          </button>
        </label>
        <select class="form-control select2"  aria-describedby="emailHelp" name="ID_CATEGORIE_COTISATION" id="ID_CATEGORIE_COTISATION_MEMBRE" onchange="get_nombre_membre()" required >
          <option value="">-- Sélectionner --</option>
          <?php
          foreach ($categorie as $key => $value) { 
            ?>
            <option value="<?=$value['ID_CATEGORIE_ASSURANCE']?>"><?=$value['DESCRIPTION']?></option>
            <?php
          } 
          ?>
        </select>
        <?php echo form_error('ID_CATEGORIE_COTISATION_MEMBRE', '<div class="text-danger">', '</div>'); ?>
      </div>

      <div class="form-group col-md-6">
        <label for="">Nombre membre <i class="text-danger"> *</i>

        </label>

        <input type="number" name="NOMBRE" id="NOMBRE"  class="form-control" >
      </div>

      
      <div class="form-group col-md-6">
        <label for="">Periode <i class="text-danger"> *</i>

        </label>

        <input type="month" name="MOIS_COTISATION" id="MOIS_COTISATION" class="form-control" required>


        <?php echo form_error('MOIS_COTISATION', '<div class="text-danger">', '</div>'); ?>
      </div>


    </div>


    <div class="row"><br>
      <div class="col-12 text-center" id="divdata" style="margin-top: 10px">
        <input type="submit" value="Enregistrer" class="btn btn-primary"/>
      </div>
    </div>
  </form>
</div>

<div class="tab-pane fade" id="custom-tabs-one-messages" role="tabpanel" aria-labelledby="custom-tabs-one-messages-tab">

 <form id="FormData" action="<?php echo base_url()?>cotisation/Configuration_Cotisation/add_frais_carte" method="POST" enctype="multipart/form-data">
  <div class="row">
    <div class="col-md-12">
      <h4>Configuration des frais de cartes</h4>
    </div>
    <div class="form-group col-md-6">
      <label for="MONTANT_COTISATION">
       Montant de la cotisation
       <i class="text-danger"> *</i>
     </label>
     <input type="number" name="MONTANT_COTISATION" class="form-control" value="<?=set_value('MONTANT_COTISATION')?>" id="MONTANT_COTISATION" required>
     <?php echo form_error('MONTANT_COTISATION', '<div class="text-danger">', '</div>'); ?>
   </div>


   <div class="form-group col-md-6">
    <label for="ID_GROUPE">
     Groupe
     <i class="text-danger"> *</i>
   </label>
   <select class="form-control select2"  aria-describedby="emailHelp" name="ID_GROUPE" id="ID_GROUPE" required >
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
  <font color="red" id="erID_GROUPE"></font>
</div>

<div class="form-group col-md-6">
  <label for="ID_CATEGORIE_COTISATION_MEMBRE">
   Categorie
   <i class="text-danger"> *</i> 
   <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modalcat">
    (Ajouter nouvelle categorie)
  </button>
</label>
<select class="form-control select2"  aria-describedby="emailHelp" name="ID_CATEGORIE_COTISATION" id="ID_CATEGORIE_COTISATION_MEMBRE" onchange="get_nombre_membre()" required >
  <option value="">-- Sélectionner --</option>
  <?php
  foreach ($categorie as $key => $value) { 
    ?>
    <option value="<?=$value['ID_CATEGORIE_ASSURANCE']?>"><?=$value['DESCRIPTION']?></option>
    <?php
  } 
  ?>
</select>
<?php echo form_error('ID_CATEGORIE_COTISATION_MEMBRE', '<div class="text-danger">', '</div>'); ?>
</div>

<div class="form-group col-md-6">
  <label for="">Nombre membre <i class="text-danger"> *</i>

  </label>

  <input type="number" name="NOMBRE" id="NOMBRE"  class="form-control" >
</div>

<div class="form-group col-md-6">
  <label for="">Periode <i class="text-danger"> *</i>

  </label>

  <input type="month" name="MOIS_COTISATION" id="MOIS_COTISATION" class="form-control" required>


  <?php echo form_error('MOIS_COTISATION', '<div class="text-danger">', '</div>'); ?>
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
</div>
</div>
</div>
</div>
<!-- /.row -->
</div><!-- /.container-fluid -->
</section>
<!-- /.content -->



<div class="modal fade" id="modalcat">
  <div class="modal-dialog">
    <form id="myformsassuree" method="POST" onsubmit="addcategorie();return false" accept-charset="utf-8" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Ajout d'une nouvelle categorie</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
           <div class="form-group col-md-12">
            <label for="NOMMETIER">
             Categorie
             <i class="text-danger"> *</i>
           </label>
           <input type="text" name="DESCRIPTION_CAT" class="form-control" value="" id="DESCRIPTION_CAT">
           <?php echo form_error('DESCRIPTION_CAT', '<div class="text-danger">', '</div>'); ?>
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



<div class="modal fade" id="modalper">
  <div class="modal-dialog">
    <form id="myformsassuree" method="POST" onsubmit="addperiode();return false" accept-charset="utf-8" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Ajout d'une nouvelle periode</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
           <div class="form-group col-md-12">
            <label for="NOMMETIER">
             Periode
             <i class="text-danger"> *</i>
           </label>
           <input type="text" name="DESCRIPTION_PER" class="form-control" value="" id="DESCRIPTION_PER">
           <?php echo form_error('DESCRIPTION_PER', '<div class="text-danger">', '</div>'); ?>
         </div>
         <div class="form-group col-md-12">
          <label for="NOMMETIER">
           Nb Jours
           <i class="text-danger"> *</i>
         </label>
         <input type="number" name="NB_JOURS" class="form-control" value="" id="NB_JOURS">
         <?php echo form_error('NB_JOURS', '<div class="text-danger">', '</div>'); ?>
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
<!-- <script>

     function province(va){
      var provine_id= $(va).val();
      $.post('<?php echo base_url('membre/Membre/get_commune')?>',
          {provine_id:provine_id},
          function(data){
            $('#COMMUNE_ID').html(data);
          });
     }
   </script> -->

   <script>

    function addcategorie(val){
      var DESCRIPTION_CAT= $('#DESCRIPTION_CAT').val();

      $.post('<?php echo base_url('cotisation/Configuration_Cotisation/addCategorie')?>',
      {
        DESCRIPTION:DESCRIPTION_CAT
      },
      function(data){
            // alert(data);
            $('#ID_CATEGORIE_COTISATION_MEMBRE').html(data); 
            $('#ID_CATEGORIE_COTISATION_MEMBRE').selectpicker('refresh');
          });
      $('#modalcat').modal('hide');

    }

  </script>

  <script type="text/javascript">

   function get_nombre_membre(argument) {

    var ID_CATEGORIE_COTISATION_MEMBRE= $('#ID_CATEGORIE_COTISATION_MEMBRE').val();
    var ID_GROUPE= $('#ID_GROUPE').val();

    // if (ID_GROUPE==" ") {
    // $('#erID_GROUPE').html("Le groupe est obligatoire !!");  
    // }else{ 

     $.post('<?php echo base_url('cotisation/Configuration_Cotisation/get_nombre')?>',
     {
      ID_CATEGORIE_COTISATION_MEMBRE:ID_CATEGORIE_COTISATION_MEMBRE,
      ID_GROUPE:ID_GROUPE
    },
    function(data){
            // alert(data);
            // $('#test').val(data); 
            $('#NOMBRE').val(data); 
          });
    // }
    
  }


</script>


<script>

  function addperiode(val){
    var DESCRIPTION_PER= $('#DESCRIPTION_PER').val();
    var NB_JOURS= $('#NB_JOURS').val();


    $.post('<?php echo base_url('cotisation/Configuration_Cotisation/addPeriode')?>',
    {
      DESCRIPTION:DESCRIPTION_PER,
      NB_JOURS:NB_JOURS
    },
    function(data){
            // alert(data);
            $('#ID_PERIODE_COTISATION').html(data); 
            $('#ID_PERIODE_COTISATION').selectpicker('refresh');
          });
    $('#modalper').modal('hide');

  }

</script>


<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
  })
</script>