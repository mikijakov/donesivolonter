<?php
    if (isset($_POST['login_submit'])) {

        require 'dbset.php';

        $mailphone = $_POST['login_mailphone'];
        $pass = $_POST['login_password'];

        if (empty($mailphone) || empty($pass)) {
            header("Location: ../index.php?greska=sveobavezno");
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

                mysqli_stmt_bind_param($stmt, "ss", $mailphone, $mailphone);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                
                if ($row = mysqli_fetch_assoc($result)) {
                    $pwdCheck = password_verify($pass, $row['pass']);
                    if ($pwdCheck == false) {
                        header("Location: ../index.php?greska=netacnalozinka");
                        exit();
                    }
                    else if ($pwdCheck == true) {
                        session_start();
                        $_SESSION['fullname'] = $row['fullname'];
                        $_SESSION['userID'] = $row['id'];
                        $_SESSION['userMail'] = $row['enail'];
                        $_SESSION['userPhone'] = $row['phonenum'];
                        $_SESSION['acceptedDelivery'] = $row['acceptedDelivery'];
                        $_SESSION['deliveryRequests'] = $row['deliveryRequests'];
                        $_SESSION['deliveryReqID'] = $row['deliveryReqID'];
                        $_SESSION['acctype'] = $row['acctype'];

                        header("Location: ../index.php?uspesno=logovanje");
                        exit();
                    }
                    else {
                        header("Location: ../index.php?greska=nepostojecikorisnik");
                        exit();
                    }
                }
                else {
                    header("Location: ../index.php?greska=nepostojecikorisnik");
                    exit();
                }
            }
        }

} else {
    header("Location: ../index.php");
    exit();
}
/* 
    Copyright  Mihailo Jakovljevic X Nanotouch 
*/
?>