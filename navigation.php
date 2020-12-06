<nav class="navbar navbar-expand-lg navbar-dark bg-dark navbar-fixed-top">
  <a class="navbar-brand mb-0 h1" href="<?php echo SITE_URL; ?>">
    <img src="/images/mainlogo-nav.png" height="33" alt="Logo volontirajdonesi">
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Otvori navigaciju">
    <span class="navbar-toggler-icon"></span>
  </button>
  
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <a class="nav-link disabled collapsed-item mb-sm-1" href="#" tabindex="-1" aria-disabled="true">#OstaniKodKuće</a>
    <ul class="navbar-nav ml-auto">

      <?php
        if (isset($_SESSION['userID'])) { ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle collapsed-item mb-sm-1" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Nalog <?php echo $_SESSION['fullname']; ?>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="#" aria-disabled="true">Podešavanja</a>
              <a class="dropdown-item" href="#" aria-disabled="true">Pošalji utisak</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item text-danger" id="logoutmenow" href="<?php echo SITE_URL."odjava.php"?>">Odjavi se</a>
            </div>
          </li>
          
          <?php  } 
          else { ?>
            <li class="nav-item">
              <a class="card-login btn btn-outline-primary align-middle mr-1 collapsed-item mb-sm-1" id="card-login" href="#">Prijavljivanje</a>
            </li>
            <li class="nav-item">
              <a class="card-register btn btn-outline-success align-middle collapsed-item mb-sm-1" id="card-register" href="#">Registracija</a>
            </li>
         <?php } ?>

    </ul>
    
  </div>
</nav>