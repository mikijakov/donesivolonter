
<div class="card register-form-home mt-2" id="register-form-home">
    <h2 class="form-title ml-auto mr-auto">Registracija</h2>
    <form class="register-form m-2" id="register-form" action="includes/register-inc.php" method="post">
        <div class="form-group">
            <label for="register_fullname">Vaše ime i prezime</label> 
            <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text">
                <i class="fa fa-user-circle-o"></i>
                </div>
            </div> 
            <input id="register_fullname" name="register_fullname" placeholder="Ime i prezime" type="text" class="form-control" required="required">
            </div>
        </div>
        <div class="form-group">
            <label for="register_phonenum">Vaš broj telefona</label> 
            <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text">
                <i class="fa fa-phone"></i>
                </div>
            </div> 
            <input id="register_phonenum" name="register_phonenum" placeholder="Primer formata 0641112244" type="tel" pattern="[0-9]{9,11}" class="form-control" required="required">
            </div>
        </div>
        <div class="form-group">
            <label for="register_email">Vaša email adresa</label> 
            <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text">
                <i class="fa fa-envelope-o"></i>
                </div>
            </div> 
            <input id="register_email" name="register_email" placeholder="Email adresa" type="email" required="required" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label for="register_password">Vaša lozinka - minimum 8 karaktera</label> 
            <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text">
                <i class="fa fa-lock"></i>
                </div>
            </div> 
            <input id="register_password" name="register_password" placeholder="Lozinka" type="password" class="form-control" required="required">
            </div>
        </div>
        <div class="form-group">
            <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text">
                <i class="fa fa-lock"></i>
                </div>
            </div> 
            <input id="register_passrepeat" name="register_passrepeat" placeholder="Ponovite lozinku" type="password" class="form-control" required="required">
            </div>
        </div>
        <div class="form-group">
            <label>Izaberite tip naloga</label> 
            <div>
            <div class="custom-control custom-radio custom-control-inline">
                <input name="register_accounttype" id="register_accounttype_0" type="radio" class="custom-control-input" value="korisnik" required="required"> 
                <label for="register_accounttype_0" class="custom-control-label">Korisnik</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <input name="register_accounttype" id="register_accounttype_1" type="radio" class="custom-control-input" value="volonter" required="required"> 
                <label for="register_accounttype_1" class="custom-control-label">Volonter</label>
            </div>
            </div>
        </div>
        <div class="form-group">
            <div>
            <div class="custom-control custom-checkbox custom-control-inline">
                <input name="register_terms" id="register_terms_0" type="checkbox" required="required" class="custom-control-input"> 
                <label for="register_terms_0" class="custom-control-label">Prihvatam sve <a href="#" id="term" class="term-service" data-toggle="modal" data-target="#exampleModalLong">uslove korišćenja.</a></label>
            </div>
            </div>
        </div> 
        <?php
            if (isset($_GET['greska'])) { 
                $errors = getErrorMessages(); ?>
                <div class="form-group alert alert-danger">
                    <?php echo $errors[$_GET['greska']];
                ?></div> <?php
            }
        ?>
        <div class="form-row">
            <input name="register_submit" type="submit" class="btn btn-primary" value="Registruj se">
            <a id="card-login" class="card-login btn btn-secondary ml-2" href="#">Već imam registrovan nalog.</a>
        </div>
    </form>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Uslovi korišćenja</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Saglasan sam da sajt (VolontirajDonesi) koristi moju lokaciju i kolačiće za poboljšanje korisničkog iskustva.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Zatvori</button>
      </div>
    </div>
  </div>
</div>

