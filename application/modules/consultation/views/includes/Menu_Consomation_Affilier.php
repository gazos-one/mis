   <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-4">
          <h1 class="m-0 text-dark"><?php echo $stitle;?></h1>
        </div>
        <div class="col-sm-6">
          <form id="FormData" >
            <div class="row form-group col-md-12">


              <div class=" form-group col-sm-3">
                <label for="ANNEE">
                  Ann&eacute;e 
                </label>
                <select class="form-control" name="ANNEE" id="ANNEE" onchange="getlist(this);liste(this)">
                  <option value="">-- Sélectionner --</option>
                  <?php
                  foreach ($annee as $key => $value) { 
                    if (set_value('ANNEE') == $value['ANNEE']) {?>
                      <option value="<?=$value['ANNEE']?>" selected><?=$value['ANNEE']?></option>
                      <?php
                              # code...
                    }
                    else{
                      ?>
                      <option value="<?=$value['ANNEE']?>"><?=$value['ANNEE']?></option>
                      <?php
                    }
                    ?>
                    
                    <?php
                  } 
                  ?>
                </select>
              </div>
              <div class="form-group col-sm-3">
                <label for="MOIS">Mois</label>
                <select class="form-control" name="MOIS" id="MOIS" onchange="getlist(this);liste(this)">
                  <option value="">-- Tous --</option>
                  <option value="01" <?= set_value('MOIS') == '01' ? 'selected' : '' ?>>01</option>
                  <option value="02" <?= set_value('MOIS') == '02' ? 'selected' : '' ?>>02</option>
                  <option value="03" <?= set_value('MOIS') == '03' ? 'selected' : '' ?>>03</option>
                  <option value="04" <?= set_value('MOIS') == '04' ? 'selected' : '' ?>>04</option>
                  <option value="05" <?= set_value('MOIS') == '05' ? 'selected' : '' ?>>05</option>
                  <option value="06" <?= set_value('MOIS') == '06' ? 'selected' : '' ?>>06</option>
                  <option value="07" <?= set_value('MOIS') == '07' ? 'selected' : '' ?>>07</option>
                  <option value="08" <?= set_value('MOIS') == '08' ? 'selected' : '' ?>>08</option>
                  <option value="09" <?= set_value('MOIS') == '09' ? 'selected' : '' ?>>09</option>
                  <option value="10" <?= set_value('MOIS') == '10' ? 'selected' : '' ?>>10</option>
                  <option value="11" <?= set_value('MOIS') == '11' ? 'selected' : '' ?>>11</option>
                  <option value="12" <?= set_value('MOIS') == '12' ? 'selected' : '' ?>>12</option>
                </select>
              </div>
              <div class="form-group col-sm-6">
                <label for="ID_GROUPE">
                  Groupe
                </label>
                <select class="form-control select2"  onchange="getlist(this);liste(this)" name="ID_GROUPE" id="ID_GROUPE">
                 <option value="">-- Tous --</option>
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
               </select>
               
             </div>

             
           </div>
         </form>
       </div>
       <div class="col-sm-2">
        <ol class="breadcrumb float-sm-right">
          <li><a class="btn <?php if($this->router->method == 'index') echo 'btn-primary';?> btn-sm" 
           href="<?=base_url('consultation/Consomation_Affilier/')?>">Liste</a></li>
         </ol>

       </div>
       <div class="col-sm-4 text-center">
        <h3 id="totalConsultation"></h3>
      </div>
      <div class="col-sm-4 text-center">
        <h3 id="totalMedicament"></h3>
      </div>
      <div class="col-sm-4 text-center">
        <h3 id="totalAll"></h3>
      </div>

    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>

