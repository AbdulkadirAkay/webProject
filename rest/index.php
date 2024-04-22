<?php
    require '../vendor/autoload.php';
    require 'services/UserService.php';
    require 'services/FolderService.php';
    require 'services/FolderDeckService.php';
    require 'services/DeckService.php';
    require 'services/CardService.php';

    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS, PATCH');

    Flight::register('userService', 'UserService');
    Flight::register('folderService', 'FolderService');
    Flight::register('folderDeckService', 'FolderDeckService');
    Flight::register('deckService', 'DeckService');
    Flight::register('cardService', 'CardService');

    Flight::route("/home", function() {
        require_once "../home.html";
    });

    Flight::route("/", function() {
        Flight::redirect('/landing');
    });

    Flight::route("/landing", function() {
        require_once "../index.html";
    });

    require './routes/UserRoutes.php';
    require './routes/FolderRoutes.php';
    require './routes/FolderDeckRoutes.php';
    require './routes/DeckRoutes.php';
    require './routes/CardRoutes.php';

    Flight::start();
?>