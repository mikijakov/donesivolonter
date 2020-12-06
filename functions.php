<?php

    function isErrorURI($errorCode) {

    }

    //Funkcija koja vraca false ukoliko je nesto iz niza prazno
    function checkEmptyInput($post) {

        foreach ($post as $key => $value) {
            if (empty($post[$key])) {
                return false;
            }
        }

        return true;
    }

    function registerValidate($post) {

        $valid = checkEmptyInput($post);

        $name = $_POST['register_fullname'];
        $phone = $_POST['register_phonenum'];
        $email = $_POST['register_email'];
        $password = $_POST['register_password'];
        $rePassword = $_POST['register_passrepeat'];
        $termsCheck = $_POST['register_terms'];
        $accountType = $_POST['register_accounttype'];

        $errorCodes = array();

        if($valid == true) {
            if ($password != $rePassword) {
                $errorCodes[] = "lozinkanejednaka";
                $valid = false;
            }
            
            if (! isset($error_message)) {
                if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errorCodes[] = "mailformat";
                    $valid = false;
                }
            }
            
            if (! isset($error_message)) {
                if (! isset($termsCheck)) {
                    $errorCodes[] = "uslovi";
                    $valid = false;
                }
            }

            if (! strlen($password) < 8) {
                if (! isset($termsCheck)) {
                    $errorCodes[] = "kratkalozinka";
                    $valid = false;
                }
            }
        }
        else {
            $errorCodes[] = "sveobavezno";
        }

        $array = array();
        array_push($array, $valid, $errorCodes);

        return $array;
    }


    function executeSqlCode($sql, $conn) {
        
    }

    function timeElapsed ($time)
    {

        $time = time() - $time; // Time elapsed from that moment in seconds
        $time = ($time < 1) ? 1 : $time;
        $names = array (
            31536000 => 'godina',
            12960000 => 'meseci',
            5184000 => 'meseca',
            2592000 => 'mesec',
            604800 => 'nedelje',
            172800 => 'dana',
            86400 => 'dan',
            18000 => 'sati',
            7200 => 'sata',
            3600 => 'sat',
            120 => 'minuta',
            60 => 'minut',
            5 => 'sekundi',
            2 => 'sekunde',
            1 => 'sekund'
        );

        foreach ($names as $unit => $text) {
            if ($time < $unit) continue;
            $numberOfUnits = floor($time / $unit);
            return $numberOfUnits.' '.$text;
        }

    }


    function translateType($type) {
        switch ($type) {
          case "food-type":
            echo "Hrana";
            break;
          case "medics-type":
            echo "Lekovi";
            break;
          default:
            echo "Drugo";
            break;
        }
      } 

    function acceptedCodes($code) {
        switch ($code) {
            case -1: 
                echo "Zahtev nije prihvaćen.";
                break;
            case 1: 
                echo "Zahtev je prihvaćen od volontera.";
                break;
            case 2: 
                echo "Zahtev je arhiviran (Isporuka uspešna).";
                break;
            case 3: 
                echo "Zahtev je arhiviran (Isporuka neuspešna).";
                break;
            case 4: 
                echo "Zahtev je izbrisan.";
                break;
            default:
                echo "Zahtev nije prihvaćen.";
                break;
        }
    }

    function endDeliveryButtons($acceptedCode, $postID) {
        
        switch ($acceptedCode) {
            case -1: 
                echo "<button class=\"btn btn-danger delete_delivery\" id=\"delete_delivery_$postID\">Izbriši zahtev</button>";
                break;
            case 0:
                echo "<button class=\"btn btn-success end_delivery\" id=\"end_delivery_$postID\">Završi dostavu</button>";
                break;
            case 1: 
                echo "<button class=\"btn btn-success success_delivery\" id=\"success_delivery_$postID\">Zadovoljan sam</button>";
                echo "<button class=\"btn btn-danger unsuccessful_delivery\" id=\"unsuccessful_delivery_$postID\">Nisam zadovoljan</button>";
                break;
            default:
                break;
        }
    }