<?php
    require '../vendor/autoload.php';

    Flight::route("/home", function() {
        require_once "../home.html";
    });

    Flight::start();
?>