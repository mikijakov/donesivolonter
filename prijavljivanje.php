<div class="card login-form-home mt-2" id="login-form-home">
    <h2 class="form-title mx-auto">Prijavljivanje</h2>
    <form method="POST" class="register-form" id="login-form" action="includes/login-inc.php">
        
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fa fa-user"></i>
                    </div>
                </div> 
                <input id="login_mailphone" name="login_mailphone" placeholder="Email adresa ili broj telefona" type="text" required="required" class="form-control">
            </div>
        </div>
        <div class="form-group"> 
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fa fa-lock"></i>
                    </div>
                </div> 
                <input id="login_password" name="login_password" placeholder="Lozinka" type="password" required="required" class="form-control">
            </div>
        </div>
        <!-- <div class="form-group">
            <div>
                <div class="custom-control custom-checkbox custom-control-inline">
                    <input name="login_remember" id="login_remember_0" type="checkbox" class="custom-control-input" value="remember"> 
                    <label for="login_remember_0" class="custom-control-label">Zapamti me</label>
                </div>
            </div>
        </div>  -->
        <?php
            if (isset($_GET['uspesno'])) { 
                $success = getSuccessMessages(); ?>
                <div class="form-group alert alert-success">
                    <?php echo $success[$_GET['uspesno']];
                ?></div> <?php
            }
        
            if (isset($_GET['greska'])) { 
                $errors = getErrorMessages(); ?>
                <div class="form-group alert alert-danger">
                    <?php echo $errors[$_GET['greska']];
                ?></div> <?php
            }
        ?>
        <div class="form-group">
            <button name="login_submit" id="login_submit" type="submit" class="btn btn-primary">Prijavi se</button>
        </div>
    </form>
</div>
