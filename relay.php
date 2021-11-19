<html<!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
        <title>Resgister</title>
    </head>

    <body>
        <?php
        system("gpio -g mode 4 out");
        system("gpio -g write 4 0");
        sleep(1);
        system("gpio -g write 4 1");
        header( "location: http://http://192.168.1.100/MAC-Web/register/inside.php" );
        ?>
    </body>