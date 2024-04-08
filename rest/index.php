<?php
    require '../vendor/autoload.php';

    Flight::route("/home", function() {
        require_once "../home.html";
    });

    Flight::route("GET /folders", function() {
        $jsonData = file_get_contents("./data.json");

        header('Content-Type: application/json');

        // Output the JSON data
        echo $jsonData;
    });

    Flight::start();
?>