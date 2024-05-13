<?php
    /**
    * @OA\Get(path="/getCardsByDeck/{id}", tags={"Get Cards by Deck"}, security={{"ApiKeyAuth": {}}},
    *     @OA\Parameter(in="path", name="id", description="Deck ID"),
    *     @OA\Response(response="200", description="Gets Cards for a Deck user ID")
    * )
    */
    Flight::route("GET /getCardsByDeck/@id", function($id) {
        Flight::json(Flight::cardService()->getCardsByDeck($id));
    });

    /**
    * @OA\Get(path="/getCardsById/{id}", tags={"Get Cards by Id"}, security={{"ApiKeyAuth": {}}},
    *     @OA\Parameter(in="path", name="id", description="Deck ID"),
    *     @OA\Response(response="200", description="Gets Cards for Id")
    * )
    */
    Flight::route("GET /getCardById/@id", function($id) {
        Flight::json(Flight::cardService()->get_by_id($id));
    });

    Flight::route("PUT /updateCard", function() {
        $data = Flight::request()->data->getData();

        Flight::json(Flight::cardService()->updateCard($data['id'], $data['question'], $data['answer']));
    });

          /**
    * @OA\Post(
    *     path="/addCard", 
    *     description="addCard",
    *     tags={"addCard"},
    *     @OA\RequestBody(description="addCard", required=true,
    *       @OA\MediaType(mediaType="application/json",
    *    			@OA\Schema(
    *             @OA\Property(property="question", type="string", example="question",	description="Question" ),
    *             @OA\Property(property="answer", type="string", example="answer",	description="answer" ),
    *             @OA\Property(property="deck_id", type="string", example="1",	description="Id of Deck" )
    *        )
    *     )),
    *     @OA\Response(
    *         response=200,
    *         description="Added Successfully"
    *     ),
    *     @OA\Response(
    *         response=500,
    *         description="Error"
    *     )
    * )
    */
    Flight::route("POST /addCard", function() {
        $data = Flight::request()->data->getData();

        Flight::json(Flight::cardService()->add($data));
    });

    Flight::route("DELETE /deleteCard/@id", function($id) {
        Flight::json(Flight::cardService()->delete($id));
    });

?>