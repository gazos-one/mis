  <?php
  include VIEWPATH.'includes/new_header.php';
  include VIEWPATH.'includes/new_top_menu.php';
  include VIEWPATH.'includes/new_menu_principal.php';
  ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php
    include 'includes/Menu_Groupe.php';
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
            <div class="card-header">
              <h3 class="card-title">Modification d'un groupe d'affilié</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->

            <div class="card-body">
             <form id="FormData" action="<?php echo base_url()?>membre/Groupe/update" method="POST">
              <input type="hidden" name="ID_GROUPE" class="form-control" value="<?php echo $selected['ID_GROUPE']?>" id="ID_GROUPE">
              <div class="row">
               <div class="form-group col-md-6">
                <label for="DESCRIPTION">
                 Nom du groupe
                 <i class="text-danger"> *</i>
               </label>
               <input type="text" name="NOM_GROUPE" class="form-control" value="<?php echo $selected['NOM_GROUPE']?>" id="NOM_GROUPE">
               <?php echo form_error('NOM_GROUPE', '<div class="text-danger">', '</div>'); ?>
             </div>
             <div class="form-group col-md-6">
              <label for="ID_TYPE_STRUCTURE">
               Date d'enregistrement
               <i class="text-danger"> *</i>
             </label>
             <input type="date" name="DATE_ENREGISTREMENT" class="form-control" value="<?php echo $selected['DATE_ENREGISTREMENT']?>" id="DATE_ENREGISTREMENT">
             <?php echo form_error('DATE_ENREGISTREMENT', '<div class="text-danger">', '</div>'); ?>
           </div>

           <div class="form-group col-md-6">
            <label for="DESCRIPTION">
             NIF
             <i class="text-danger"> *</i>
           </label>
           <input type="text" name="NIF" class="form-control" value="<?php echo $selected['NIF']?>" id="NIF">
           <?php echo form_error('NIF', '<div class="text-danger">', '</div>'); ?>
         </div>
         <div class="form-group col-md-6">
          <label for="DESCRIPTION">
           Residence
           <i class="text-danger"> *</i>
         </label>
         <input type="text" name="RESIDENCE" class="form-control" value="<?php echo $selected['RESIDENCE']?>" id="RESIDENCE">
         <?php echo form_error('RESIDENCE', '<div class="text-danger">', '</div>'); ?>
       </div>


     </div>
     <div class="row" style="margin-top: 5px">
      <div class="col-10" id="divdata" class="text-center">
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

 function province(va){
  var provine_id= $(va).val();
  $.post('<?php echo base_url('saisie/Structure_Sanitaire/get_commune')?>',
    {provine_id:provine_id},
    function(data){
      $('#COMMUNE_ID').html(data);
    });
}
</script>