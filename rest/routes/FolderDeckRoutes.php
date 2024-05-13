<?php

    /**
    * @OA\Get(path="/getFolderDeckByFolder/{id}", tags={"Get FolderDeck by Folder"}, security={{"ApiKeyAuth": {}}},
    *     @OA\Parameter(in="path", name="id", description="Folder ID"),
    *     @OA\Response(response="200", description="Gets FolderDeck for a Folder user ID")
    * )
    */
    Flight::route("GET /getFolderDeckByFolder/@id", function($id) {
        Flight::json(Flight::folderDeckService()->getFolderDeckByFolder($id));
    });

    /**
    * @OA\Get(path="/getFolderDeckByDeck/{id}", tags={"Get FolderDeck by Deck"}, security={{"ApiKeyAuth": {}}},
    *     @OA\Parameter(in="path", name="id", description="Deck ID"),
    *     @OA\Response(response="200", description="Gets FolderDeck for a Deck user ID")
    * )
    */
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