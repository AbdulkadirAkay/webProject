<?php
    /**
    * @OA\Get(path="/getDecksByFolder/{id}", tags={"Get Decks by Folder"}, security={{"ApiKeyAuth": {}}},
    *     @OA\Parameter(in="path", name="id", description="Folder ID"),
    *     @OA\Response(response="200", description="Gets Decks for a Folder user ID")
    * )
    */
    Flight::route("GET /getDecksByFolder/@id", function($id) {
        Flight::json(Flight::deckService()->getDecksByFolder($id));
    });
    
    /**
    * @OA\Get(path="/getDeckById/{id}", tags={"Get Deck by Id"}, security={{"ApiKeyAuth": {}}},
    *     @OA\Parameter(in="path", name="id", description="ID"),
    *     @OA\Response(response="200", description="Gets Deck for a user ID")
    * )
    */
    Flight::route("GET /getDeckById/@id", function($id) {
        Flight::json(Flight::deckService()->get_by_id($id));
    });


    Flight::route("PUT /updateDeck", function() {
        $data = Flight::request()->data->getData();

        Flight::json(Flight::deckService()->updateDeck($data['id'], $data['deck_name']));
    });

    Flight::route("POST /addDeck", function() {
        $data = Flight::request()->data->getData();

        Flight::json(Flight::deckService()->add($data));
    });

    Flight::route("DELETE /deleteDeck/@id", function($id) {
        Flight::json(Flight::deckService()->delete($id));
    });

?>