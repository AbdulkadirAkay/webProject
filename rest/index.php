<?php
    require '../vendor/autoload.php';

    Flight::route("/home", function() {
        require "../home.html";
    });

    Flight::start();
?>