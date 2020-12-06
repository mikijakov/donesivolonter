<?php

    $serverHost = "localhost";
    $dbUser = "root";
    $dbPass = "";
    $dbName = "volonterskadostava";

    $connection = mysqli_connect($serverHost, $dbUser, $dbPass, $dbName);

    if (!$connection) {
        die("Greška pri uspostavljanju veze sa bazom: ".mysqli_connect_error());
    }