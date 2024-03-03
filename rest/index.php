<?php
    require '../vendor/autoload.php';

    Flight::route("GET /hello", function() {
        echo "hello world";
    });

    Flight::route("/", function(){
        echo "base page";
    });

    Flight::start();
?>