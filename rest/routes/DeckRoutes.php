<?php
    Flight::route("GET /getDecksByFolder/@id", function($id) {
        Flight::json(Flight::deckService()->getDecksByFolder($id));
    });

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