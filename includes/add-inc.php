<?php
    session_start();
    
    if (isset($_POST['submit-delivery'])) {
        //includes
        require 'dbset.php';
        require_once('../functions.php');

        $address = $_POST['address-delivery'];
        $typeDelivery = $_POST['select-type'];
        $deliveryDetails = $_POST['delivery-details'];
        $lat = $_POST["lat"];
        $lng = $_POST['lng'];
        $userID = $_SESSION['userID'];

        if (isset($_POST['acceptDel'])) {
            $accepting = filter_input(INPUT_POST, 'acceptDel', FILTER_VALIDATE_BOOLEAN);
        } else {
            $accepting = false;
        }

        if (isset($lat) && isset($lng)) {
            if (!empty($address) && !empty($typeDelivery) && !empty($deliveryDetails)) {
                $sql = "INSERT INTO dostave (addressDelivery, deliveryType, details, userCreated, timeStarted, longitude, latitude) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_stmt_init($connection);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: card.php?greska=dbgreska");
                    exit();
                }
                else {
                    $time = time();
                    mysqli_stmt_bind_param($stmt, "sssiidd", $address, $typeDelivery, $deliveryDetails, $userID, $time, $lng, $lat);
                    mysqli_stmt_execute($stmt);
                    $insertID = mysqli_insert_id($connection);
                    $_SESSION['deliveryRequests'] = 1;
                    mysqli_stmt_close($stmt);

                    $sql = "UPDATE korisnici SET deliveryRequests = 1, deliveryReqID = ? WHERE id=?";
                    $stmt = $connection->prepare($sql);
                    $stmt->bind_param('ii', $insertID ,$_SESSION['userID']);
                    $stmt->execute();
                    if ($stmt->error) {
                    echo "Greska u uspostavljanju veze sa bazom!";
                    }
                    $stmt->close();
                    header("Location: card.php?uspesno=dodato");
                    exit();
                }

                $_POST['submit-delivery'] = NULL;
                mysqli_stmt_close($stmt);
                mysqli_close($connection);
            }
            else {
                header("Location: card.php?greska=prazanUnos");
                exit();
            }
        }
        else {
            header("Location: card.php?greska=nemaadrese");
            exit();
        }
        
    }
    else {
        header("Location: ../index.php");
        exit();
    }