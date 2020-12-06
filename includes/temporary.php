<?php 

global $errorMessages;

function setErrorMessages($string) {
    $errorMessages[] = $string;
}

function getErrorMessages() {
    return $errorMessages;
}