<?php
    Flight::route("GET /getCardsByDeck/@id", function($id) {
        Flight::json(Flight::cardService()->getCardsByDeck($id));
    });

    Flight::route("GET /getCardById/@id", function($id) {
        Flight::json(Flight::cardService()->get_by_id($id));
    });


    Flight::route("PUT /updateCard", function() {
        $data = Flight::request()->data->getData();

        Flight::json(Flight::cardService()->updateCard($data['id'], $data['question'], $data['answer']));
    });

    Flight::route("POST /addCard", function() {
        $data = Flight::request()->data->getData();

        Flight::json(Flight::cardService()->add($data));
    });

    Flight::route("DELETE /deleteCard/@id", function($id) {
        Flight::json(Flight::cardService()->delete($id));
    });

?>