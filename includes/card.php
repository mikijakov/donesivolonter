<?php
  include "dbset.php";
  include "../constants.php";
  require '../functions.php';
  
  //debugging
  /* ini_set('display_errors', 'On');
  error_reporting(E_ALL | E_STRICT);
  mysqli_report(MYSQLI_REPORT_ALL); */
  // end of debugging settings

  session_start();
  // acceptDel se salje kada volonter prihvata i kad korisnik salje zahtev
  if (isset($_POST['acceptDel'])) {
    $accepting = filter_input(INPUT_POST, 'acceptDel', FILTER_VALIDATE_BOOLEAN);
  } else {
    $accepting = false;
  }
  

  if (isset($_SESSION['userID'])) {
    if ($_SESSION['acctype'] == 'volonter') {

      $sql = "SELECT acceptedDelivery, deliveryReqID FROM korisnici WHERE id=?;";
      $stmt = $connection->prepare($sql);
      $stmt->bind_param('i', $_SESSION['userID']);
      $stmt->execute();

      if ($result = $stmt->get_result()) {
        $row = $result->fetch_assoc();
        $_SESSION['acceptedDelivery'] = $row['acceptedDelivery'];
        $_SESSION['deliveryReqID'] = $row['deliveryReqID'];
        $stmt->close();
      }

      if ($_SESSION['acceptedDelivery'] < 1 && $accepting !== true) {
        $myLatitude = filter_input(INPUT_POST, 'mylat', FILTER_VALIDATE_FLOAT);
        $myLongitude = filter_input(INPUT_POST, 'mylng', FILTER_VALIDATE_FLOAT);
      
        $sql = "SELECT id, details, deliveryType, timeStarted, latitude, longitude, ( 6371 * acos( cos( radians($myLatitude) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians($myLongitude) ) + sin( radians($myLatitude) ) * sin( radians( latitude ) ) ) ) AS distance FROM dostave WHERE userAccepted < 1 HAVING distance < 10 ORDER BY distance LIMIT 0 , 20";
      
        $result = mysqli_query($connection, $sql);
        if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            $distance = $row['distance'];
            $typeDelivery = $row['deliveryType'];
            $vreme = $row['timeStarted'];
            $detailsDelivery = $row['details']; ?>

            <div class="card border-dark mt-3" style="width: 90%; margin: 0 auto;">
              <div class="card-header text-success"><?php echo round($distance, 2); ?> km od tebe</div>
              <div class="card-body text-dark">
                <h5 class="card-title">Vrsta: <?php translateType($typeDelivery); ?></h5>
                <p class="card-text">Potrebno: <?php echo $detailsDelivery; ?></p>
              </div>
              <div class="card-footer bg-transparent border-dark">
                <button id="accept_delivery_<?php echo $row['id'];?>"class="btn btn-success accept_delivery">Prihvati</button>
                <button id="show_map_<?php echo $row['id']; ?>" class="btn btn-outline-secondary show_map">Prikaži na mapi</button>
                <span class="card-text ml-auto" style="padding: .375rem .75rem; float:right; line-height: 1.5;">Pre <?php echo timeElapsed($vreme); ?></span>
              </div>
            </div> <?php
          }
        }
        else {
          ?>
          <div class="card text-white bg-success mt-3" style="width: 90%; margin: 0 auto;">
            <div class="card-body">
              <h5 class="card-title">Nema pronađenih zahteva u tvojoj okolini!</h5>
            </div>
          </div>
          <?php
        }
      }
      else {
          $acceptedID = filter_input(INPUT_POST, 'postID', FILTER_VALIDATE_INT);
          $myLatitude = filter_input(INPUT_POST, 'mylat', FILTER_VALIDATE_FLOAT);
          $myLongitude = filter_input(INPUT_POST, 'mylng', FILTER_VALIDATE_FLOAT);

          if ($accepting == true) {
            $sql = "UPDATE korisnici SET acceptedDelivery = 1, deliveryReqID = ? WHERE id=?";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param('ii', $acceptedID ,$_SESSION['userID']);
            $stmt->execute();
            if ($stmt->error) {
              echo "Greska u uspostavljanju veze sa bazom!";
            }
            $_SESSION['deliveryReqID'] = $acceptedID;
            $_SESSION['acceptedDelivery'] = 1;
            $stmt->close();
          }


          if (isset($_SESSION['deliveryReqID'])) {
            $sql = "SELECT * FROM dostave WHERE id=?;";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param('i', $_SESSION['deliveryReqID']);
            $stmt->execute();
            
            //$stmt->close();
            if ($result = $stmt->get_result()) {
              $row = $result->fetch_assoc();

              $distance = ( 6371 * acos( cos( deg2rad($myLatitude) ) * cos( deg2rad( $row['latitude'] ) ) * cos( deg2rad( $row['longitude'] ) - deg2rad($myLongitude) ) + sin( deg2rad($myLatitude) ) * sin( deg2rad( $row['latitude'] ) ) ) );
              $typeDelivery = $row['deliveryType'];
              $detailsDelivery = $row['details'];
              $addressDelivery = $row['addressDelivery'];
              $vreme = $row['timeStarted'];
              $createdID = $row['userCreated'];

              $stmt->close();

              $sql = "SELECT phonenum FROM korisnici WHERE id = ?";
              $stmt = $connection->prepare($sql);
              if ($stmt !== false) {
                $stmt->bind_param('i', $createdID);
                $stmt->execute();
                if ($result = $stmt->get_result()) {
                  $korisnik = $result->fetch_assoc();
                  
                  $phoneDelivery = $korisnik['phonenum'];
                  ?>
                  <div class="card border-dark mt-3" style="width: 90%; margin: 0 auto;">
                    <div class="card-header text-success"><?php echo round($distance, 2); ?> km od tebe</div>
                    <div class="card-body text-dark">
                      <h5 class="card-title">Vrsta: <?php translateType($typeDelivery); ?></h5>
                      <h6 class="card-title">Adresa: <?php echo $addressDelivery; ?></h5>
                      <h6 class="card-title">Broj telefona: <?php echo $phoneDelivery; ?></h5>
                      <p class="card-text">Potrebno: <?php echo $detailsDelivery; ?></p>  
                    </div>
                    <div class="card-footer bg-transparent border-dark">
                      <?php endDeliveryButtons(0, $row['id']); ?>
                      <button class="btn btn-outline-secondary show_map" id="show_map_<?php echo $row['id']; ?>">Prikaži na mapi</button>
                      <span class="card-text ml-auto" style="padding: .375rem .75rem; float:right; line-height: 1.5;">Pre <?php echo timeElapsed($vreme); ?></span>
                    </div>
                  </div> <?php
                  $stmt->close();
                }
              }
            }
          }
      }
    } else if ($_SESSION['acctype'] == 'korisnik') {
        if ($_SESSION['deliveryRequests'] < 1 && $accepting !== true) {
      ?>
      <div class="card mx-auto mt-5">
            <h4 class="mx-auto">Dodaj zahtev za dostavu</h2>
            <div class="bd-example mr-2 ml-2">
                <form class="delivery-form" id="delivery-form">
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
      <?php
        } else {
          // izvrsiti ubacivanje u bazu podataka i azurirati korisnika koji dodaje inaca ako nije accepting onda prikazati taj zahtev u sidebar
          $sql = "SELECT * FROM dostave WHERE userCreated = ? AND userAccepted < 2";
          $stmt = $connection->prepare($sql);
          if ($stmt !== false) {
            $stmt->bind_param('i', $_SESSION['userID']);
            $stmt->execute();
            if ($result = $stmt->get_result()) {
              $row = $result->fetch_assoc();
              
              $requestID = $row['id'];
              $addressDelivery = $row['addressDelivery'];
              $typeDelivery = $row['deliveryType'];
              $detailsDelivery = $row['details'];
              $timeStarted = $row['timeStarted'];
              $volunteerAccepted = $row['userAccepted'];  ?>

              <div class="card border-dark mt-3" style="width: 90%; margin: 0 auto;">
                <div class="card-header text-success">Adresa: <?php echo $addressDelivery; ?></div>
                <div class="card-body text-dark">
                  <h5 class="card-title">Vrsta: <?php translateType($typeDelivery); ?></h5>
                  <h6 class="card-title">Status: <?php echo acceptedCodes($volunteerAccepted); ?></h5>
                  <p class="card-text">Potrebno: <?php echo $detailsDelivery; ?></p>  
                </div>
                <div class="card-footer bg-transparent border-dark">
                  <?php endDeliveryButtons($volunteerAccepted, $requestID); ?>
                  <span class="card-text ml-auto" style="padding: .375rem .75rem; float:right; line-height: 1.5;">Pre <?php echo timeElapsed($timeStarted); ?></span>
                </div>
              </div>
              
              <?php
              $stmt->close();
            }
          }
        }
    }
  }
  else { 
  }


