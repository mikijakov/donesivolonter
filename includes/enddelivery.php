<?php 
    session_start();
    include "dbset.php";

    if (isset($_POST['id'])) {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        if (isset($_POST['delete']) && $_POST['delete'] == true) {

            $sql = "UPDATE korisnici SET deliveryRequests = 0, deliveryReqID = -1 WHERE id=?";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param('i', $_SESSION['userID']);
            $stmt->execute();
            if ($stmt->error) {
                echo "Greska u uspostavljanju veze sa bazom!";
            }
            $stmt->close();
            $_SESSION['deliveryReqID'] = -1;
            $_SESSION['deliveryRequests'] = 0;
            
            $sql = "UPDATE dostave SET userAccepted = 4 WHERE userCreated=? AND userAccepted < 1";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param('i', $_SESSION['userID']);
            $stmt->execute();
            if ($stmt->error) {
                echo "Greska u uspostavljanju veze sa bazom!";
            }
            $stmt->close();
            
            header("Location: card.php");
            exit();

        } else if (isset($_POST['success']) && $_POST['success'] == true) {
            
            $sql = "UPDATE dostave SET userAccepted = 2 WHERE userCreated=? AND userAccepted = 1";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param('i', $_SESSION['userID']);
            $stmt->execute();
            if ($stmt->error) {
                echo "Greska u uspostavljanju veze sa bazom!";
            }
            $stmt->close();

            $sql = "UPDATE korisnici SET rating = rating + 1, acceptedDelivery = 0, deliveryReqID = -1 WHERE deliveryReqID=? AND acctype = 'volonter'";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param('i', $_SESSION['deliveryReqID']);
            $stmt->execute();
            if ($stmt->error) {
                echo "Greska u uspostavljanju veze sa bazom!";
            }
            $stmt->close();

            $sql = "UPDATE korisnici SET deliveryRequests = 0, deliveryReqID = -1 WHERE id=?";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param('i', $_SESSION['userID']);
            $stmt->execute();
            if ($stmt->error) {
                echo "Greska u uspostavljanju veze sa bazom!";
            }
            $stmt->close();
            $_SESSION['deliveryReqID'] = -1;
            $_SESSION['deliveryRequests'] = 0;
            
            header("Location: card.php");
            exit();

        } else if (isset($_POST['unsuccessful']) && $_POST['unsuccessful'] == true) {

            $sql = "UPDATE dostave SET userAccepted = 3 WHERE userCreated=? AND userAccepted = 1";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param('i', $_SESSION['userID']);
            $stmt->execute();
            if ($stmt->error) {
                echo "Greska u uspostavljanju veze sa bazom!";
            }
            $stmt->close();

            $sql = "UPDATE korisnici SET rating = rating - 1, acceptedDelivery = 0, deliveryReqID = -1 WHERE deliveryReqID=? AND acctype = 'volonter'";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param('i', $_SESSION['deliveryReqID']);
            $stmt->execute();
            if ($stmt->error) {
                echo "Greska u uspostavljanju veze sa bazom!";
            }
            $stmt->close();

            $sql = "UPDATE korisnici SET deliveryRequests = 0, deliveryReqID = -1 WHERE id=?";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param('i', $_SESSION['userID']);
            $stmt->execute();
            if ($stmt->error) {
                echo "Greska u uspostavljanju veze sa bazom!";
            }
            $stmt->close();
            $_SESSION['deliveryReqID'] = -1;
            $_SESSION['deliveryRequests'] = 0;
            
            header("Location: card.php");
            exit();

        } else if (isset($_POST['end']) && $_POST['end'] == true) {

            // Ostace bug kad se reloguje volonter jer ce ako korisnik zavrsi a on nije bice i njemu a ako on zavrsi i uradi relog pre nego korisnik zavrsi 
            $_SESSION['deliveryReqID'] = -1;
            $_SESSION['acceptedDelivery'] = 0;

            header("Location: card.php");
            exit();

        } else {
            header("Location: ../index.php");
            exit();
        }
    } else {
        header("Location: ../index.php");
        exit();
    }