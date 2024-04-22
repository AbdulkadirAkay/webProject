<?php
    Flight::route("GET /getFolderDeckByFolder/@id", function($id) {
        Flight::json(Flight::folderDeckService()->getFolderDeckByFolder($id));
    });

    Flight::route("GET /getFolderDeckByDeck/@id", function($id) {
        Flight::json(Flight::folderDeckService()->getFolderDeckByDeck($id));
    });

    Flight::route("POST /addFolderDeck", function() {
        $data = Flight::request()->data->getData();

        Flight::json(Flight::folderDeckService()->add($data));
    });

    Flight::route("DELETE /deleteFolderDeckByFolder/@id", function($id) {
        Flight::json(Flight::folderDeckService()->deleteByFolder($id));
    });

    Flight::route("DELETE /deleteFolderDeckByDeck/@id", function($id) {
        Flight::json(Flight::folderDeckService()->deleteByDeck($id));
    });

?>