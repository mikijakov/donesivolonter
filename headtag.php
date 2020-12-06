<?php
    if (isset($alreadyStarted) && $alreadyStarted != true) {
        session_start();
    }
    else {
        session_start();
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $pageTitle; ?></title>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="description" content="<?php echo $pageDescription; ?>">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

        <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"> -->
        <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

        <link rel="stylesheet" href="css/main.css">
        
        <?php  
            if($pageCanonical)
            {
                echo '<link rel="canonical" href="' . $pageCanonical . '">';
            }
            if($pageRobots)
            {
                echo '<meta name="robots" content="' . $pageRobots . '">';
            }
        ?>
    


    </head>
    <body>