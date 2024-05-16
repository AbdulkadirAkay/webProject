<?php
    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;

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

    Flight::route('/*', function(){

        //return TRUE;
        //perform JWT decode
        $path = Flight::request()->url;
        if ($path == '/login' || $path == '/register' || $path == '/docs.json' || $path == '/landing' || $path == '/profile' || $path == '/' || $path == '/home') return TRUE;
        $headers = getallheaders();
        if (@!$headers['Authorization']){
            Flight::json(["message" => $path], 403);
            Flight::json(["message" => "Authorization is missing"], 403);
            return FALSE;
        }else{
            try {
                $decoded = (array)JWT::decode($headers['Authorization'], new Key(Config::JWT_SECRET(), 'HS256'));
                Flight::set('user', $decoded);
                return TRUE;
            } catch (\Exception $e) {
                Flight::json(["message" => "Authorization token is not valid"], 403);
                return FALSE;
            }
        }
      });

    Flight::route("/home", function() {
        require_once "../home.html";
    });

    Flight::route("/", function() {
        Flight::redirect('/landing');
    });

    Flight::route("/landing", function() {
        require_once "../index.html";
    });

    Flight::route('GET /docs.json', function(){
        $openapi = \OpenApi\scan('routes');
        header('Content-Type: application/json');
        echo $openapi->toJson();
      });

    require './routes/UserRoutes.php';
    require './routes/FolderRoutes.php';
    require './routes/FolderDeckRoutes.php';
    require './routes/DeckRoutes.php';
    require './routes/CardRoutes.php';

    Flight::start();
?>