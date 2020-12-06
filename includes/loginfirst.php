<?php

    $pageTitle = "Greška - prvo se ulogujte";
    $pageDescription = "";
    $pageRobots = 'noindex,nofollow';
    $pageCanonical = "";
    include('headtag.php');
    include('navigation.php');

    ?>

<div style="width:100%; text-align: center; position:absolute;">
    <div class="row mt-5">
        <div class="col-md-12">
            <div class="error-template">
                <h1>
                    Greška - prvo se ulogujte!</h1>
                <h2>
                    Ako nemate nalog registrujte se.</h2>
                <div class="error-actions">
                    <a href="<?php echo SITE_URL."prijavljivanje.php"; ?>" class="btn btn-primary btn-lg">
                        Prijavi se </a><a href="<?php echo SITE_URL."registracija.php"; ?>" class="btn btn-default btn-lg"> Registruj se </a>
                </div>
            </div>
        </div>
    </div>
</div>



<?php   include('scripts.php');