<?php 

    if(isset($_POST['register_submit'])) {

        require 'dbset.php';
        require_once('../functions.php');

        // Validacija forme - form validation
        $name = $_POST['register_fullname'];
        $phone = $_POST['register_phonenum'];
        $email = $_POST['register_email'];
        $password = $_POST['register_password'];
        $rePassword = $_POST['register_passrepeat'];
        $termsCheck = $_POST['register_terms'];
        $accountType = $_POST['register_accounttype'];

        $array = registerValidate($_POST);
        $valid = $array[0];
        $errorCodes = $array[1];
        // Izvrsena validacija - validation completed
        
        if ($valid == false) {
            $errors = "";
            foreach ($errorCodes as $code) {
                $errors .= "greska=" . $code;
            }
            header("Location: ../index.php?".$errors);
            exit();
        }
        else {

            $sql = "SELECT * FROM korisnici WHERE email=? OR phonenum=?;";
            $stmt = mysqli_stmt_init($connection);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../index.php?greska=dbgreska");
                exit();
            }
            else {
                mysqli_stmt_bind_param($stmt, "ss", $email, $phone);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $resultCheck = mysqli_stmt_num_rows($stmt);
                if ($resultCheck > 0) {
                    header("Location: ../index.php?greska=postojiuser");
                    exit();
                }
                else {
                    $sql = "INSERT INTO korisnici (fullname, pass, email, phonenum, acctype) VALUES (?, ?, ?, ?, ?)";
                    $stmt = mysqli_stmt_init($connection);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        header("Location: ../index.php?greska=dbgreska");
                        exit();
                    }
                    else {
                        $hashpw = password_hash($password, PASSWORD_DEFAULT);

                        mysqli_stmt_bind_param($stmt, "sssss", $name, $hashpw, $email, $phone, $accountType);
                        mysqli_stmt_execute($stmt);
                        header("Location: ../index.php?uspesno=registracija");
                        exit();
                    }
                }

            }

        }
        $_POST['register_submit'] = NULL;
        mysqli_stmt_close($stmt);
        mysqli_close($connection);
    }
    else {
        header("Location: ../index.php");
        exit();
    }