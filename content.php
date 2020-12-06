<div class="maps-cards-wrapper group-app">

    <div class="cards-stack">
        <!-- SEARCH BAR -->
        <!-- <div class="searchbar-cards">
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Traži mesta i gradove" aria-label="Search">
                    <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Pretraga</button>
                </input>
            </form>
        </div> -->
        <!-- END OF SEARCH BAR -->
        <?php
            if (isset($_GET['greska'])) { 
                $errors = getErrorMessages(); ?>
                <div class="form-group alert alert-danger mt-2" style="width: 90%; margin: 0 auto;">
                    <?php echo $errors[$_GET['greska']]; ?>
                </div> <?php
            }
        
            if (isset($_GET['uspesno'])) { 
                $success = getSuccessMessages(); ?>
                <div class="form-group alert alert-success mt-2" style="width: 90%; margin: 0 auto;">
                    <?php echo $success[$_GET['uspesno']]; ?>
                </div> <?php
            }?>

        <div id="cards-stack" style="width: 90%; margin: 0 auto;">
        </div>
        <?php
            if (!isset($_SESSION['userID'])) { ?>
                <div class="card mt-2" id="pleaselogin" style="width: 90%; margin: 0 auto;">
                    <div class="card-header">
                        Molimo vas da se ulogujete
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Ulogujte se kako biste pristupili svim sadržajima i uslugama koje vam pruža VolontirajDonesi</h5>
                        <p class="card-text">VolontirajDonesi je sajt humanitarnog karaktera koji ima za namenu da pomogne svim ugroženim licima tokom epidemije COVID-19, omogućujući korisnicima da postave do jedan zahtev za dostavu, a volonteri te zahteve mogu videti ukoliko se nalaze u njihovoj blizini. Ukoliko nemate nalog možete se registrovati.</p>
                        <button class="card-login btn btn-outline-primary align-middle mr-1 collapsed-item mb-sm-1" id="card-login">Prijavljivanje</button>
                        <a class="card-register btn btn-outline-success align-middle collapsed-item mb-sm-1" id="card-register" href="#">Registracija</a>
                    </div>
                </div> <?php
            }
        ?>
        <div class="ml-10 jusify-content-center m-5 text-primary" id="loader">
            <div class="spinner-border" role="status">
                <span class="sr-only">Učitavanje...</span>
            </div>
            <span class="ml-1"> Učitavanje...</span>
        </div>

        <div id="footer" class="copyright-wrapper text-light bg-dark">
           <span class="copyright-nt mr-auto ml-auto">Servis omogućio <a href="https://nanotouch.co">Mihailo Jakovljević</a></span> 
        </div>
    </div>

    <div class="map-place">
        <div id="main-map" style="width: 100%; height: 100%;">

        </div>
    </div>







</div>