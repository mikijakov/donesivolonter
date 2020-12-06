<?php
    require "dbset.php";
    
    $center_lat = $_GET["lat"];
    $center_lng = $_GET["lng"];

    //start of xml
    $dom = new DOMDocument("1.0");
    $node = $dom->createElement("markers");
    $parnode = $dom->appendChild($node);

    
    // Search the rows in the markers table
    $sql = "SELECT id, latitude, longitude, ( 6371 * acos( cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin( radians( latitude ) ) ) ) AS distance FROM dostave WHERE userAccepted < 1 HAVING distance < 10 ORDER BY distance LIMIT 0 , 20";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param('ddd', $center_lat, $center_lng, $center_lat);
    $stmt->execute();
    if ($stmt->error) {
        echo "Greska u uspostavljanju veze sa bazom!";
    }
    if ($result = $stmt->get_result()) {
        
        header("Content-type: text/xml");
        // Iterate through the rows, adding XML nodes for each
        while ($row = $result->fetch_assoc()) {
            $node = $dom->createElement("marker");
            $newnode = $parnode->appendChild($node);
            $newnode->setAttribute("id", $row['id']);
            $newnode->setAttribute("lat", $row['latitude']);
            $newnode->setAttribute("lng", $row['longitude']);
        }
        $stmt->close();
        echo $dom->saveXML();
    }
?>