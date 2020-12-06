<?php
    require("constants.php");
    $pageTitle = "Pocetna - ". siteName;
    $pageDescription = "Početna strana sajta VolontirajDonesi koji omogućava ugroženim licima tokom vanrednog stanja da zatraže pomoć putem ove platforme, takođe volonteri se mogu uključiti i pomoći istim sugrađanima koji su oglasili svoje potrebe ovde.";
    $pageRobots = 'index,nofollow';
    $pageCanonical = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    include('headtag.php');

    include('navigation.php');

    include('content.php');

    include('scripts.php');
