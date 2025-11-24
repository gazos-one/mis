<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-sm-12">
                <h3>Critère de recherche</h3>
            </div>
            <br><!-- /.col -->
            <div class="col-sm-3">    
            </div>
            <div class="col-sm-8">
                <form id="FormData" method="POST">
                    <div class="container">
                        <div class="row align-items-center">

                            <!-- Checkbox Section -->
                            <div class="col-sm-4">
                                <div class="custom-control custom-radio d-inline-block">
                                    <input class="custom-control-input" type="radio" name="customRadio" id="customRadio1" value="0">
                                    <label for="customRadio1" class="custom-control-label">Afilié</label>
                                </div>
                                <div class="custom-control custom-radio d-inline-block ml-3">
                                    <input class="custom-control-input" type="radio" name="customRadio" id="customRadio2" value="1">
                                    <label for="customRadio2" class="custom-control-label">Ayant Droit</label>
                                </div>
                                <span id="chec_error" style="color: red;"></span>
                            </div>
                            <div class="col-sm-4">
                                <label for="ageMin">Intervalle d'âge</label><br>
                                <b></b>
                                <input id="ageMin" name="ageMin" type="number" class="span2"  min="0" max="60" step="1" style="width: 60px;"/>
                                <b>à</b>
                                <input id="ageMax" name="ageMax" type="number" class="span2"  min="0" max="60" step="1" style="width: 60px;"/>
                                <b></b>
                                <span id="ageRange_error" style="color: red;"></span>
                            </div>
                            <!-- Submit Button -->
                            <div class="col-sm-4">
                                <button id="submit" type="submit" class="btn btn-primary mt-3">Rechercher</button>
                            </div>
                        </div>
                    </div>
                </form>
                <p>Choisissez entre "Afilié" et "Ayant Droit" et spécifiez un intervalle d'âge.</p>
                <div id="result" style="margin-top: 20px;"></div> <!-- Area to display results -->
            </div><!-- /.col -->
        </div>
    </div><!-- /.container-fluid -->
</div>

