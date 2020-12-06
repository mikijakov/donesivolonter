<div class="col-12 col-md-6 ml-auto mr-auto mt-5">
            <div class="bd-example">
                <form action="includes/add-inc.php" method="POST" class="delivery-form" id="delivery-form">
                    <div class="form-group">
                        <label for="address-delivery">Adresa dostave</label> 
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text btn text-success" id="locateme" data-toggle="tooltip" data-placement="top" title="Koristi trenutnu lokaciju">
                                    <i class="fa fa-map-marker mr-1"></i>
                                </div>
                            </div>
                            <input id="address-delivery" name="address-delivery" placeholder="Ulica, broj i grad" value="" type="text" aria-describedby="address-deliveryHelpBlock" required="Obavezno polje" class="form-control">
                        </div>
                        <span id="address-deliveryHelpBlock" class="form-text text-muted">Unesite tačnu adresu na kojoj želite da vam bude dostavljena pomoć</span>
                        <div id="locationerror" class="form-group alert alert-danger hidden geolocation-error mt-1"></div>
                    </div>
                    <div class="form-group">
                        <label for="select-type">Izaberite tip dostave</label> 
                        <div>
                            <select id="select-type" name="select-type" class="custom-select" required="Obavezno polje" aria-describedby="select-typeHelpBlock">
                                <option value="food-type">Hrana</option>
                                <option value="medics-type">Lekovi</option>
                                <option value="other-type">Drugo</option>
                            </select> 
                            <span id="select-typeHelpBlock" class="form-text text-muted">Ponuđeno: hrana, lekovi, ili nešto drugo...</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="delivery-details">Detalji dostave</label> 
                        <textarea id="delivery-details" name="delivery-details" cols="40" rows="5" class="form-control" aria-describedby="delivery-detailsHelpBlock" required="Obavezno polje"></textarea> 
                        <span id="delivery-detailsHelpBlock" class="form-text text-muted">Ovde opišite šta vam je potrebno</span>
                    </div> 
                    <div class="form-group">
                        <button id="submit-delivery" name="submit-delivery" type="submit" class="btn btn-primary">Pošalji zahtev</button>
                    </div>
                </form>
            </div>
        </div>