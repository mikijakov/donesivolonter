<?php
    if (isset($_POST['id'])) {
        require "dbset.php";
        
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

        $sql = "SELECT latitude, longitude FROM dostave WHERE id=?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        if ($stmt->error) {
            echo "Greska u uspostavljanju veze s bazom";
        }
        if ($result = $stmt->get_result()) {
            $row = $result->fetch_assoc();
            $lat = $row['latitude'];
            $lng = $row['longitude'];
            echo json_encode($row);
        }
        $stmt->close();
    }
    else {
        header("Location: ../index.php");
        exit();
    }