<?php
    /**
    * @OA\Get(path="/getFoldersByUser/{id}", tags={"Get Folders by Id"}, security={{"ApiKeyAuth": {}}},
    *     @OA\Parameter(in="path", name="id", description="User ID"),
    *     @OA\Response(response="200", description="Gets Folders for User Id")
    * )
    */
    Flight::route("GET /getFoldersByUser/@id", function($id) {
        Flight::json(Flight::folderService()->getFoldersByUser($id));
    });

    Flight::route("GET /getFolderById/@id", function($id) {
        Flight::json(Flight::folderService()->get_by_id($id));
    });


    Flight::route("PUT /updateFolder", function() {
        $data = Flight::request()->data->getData();

        Flight::json(Flight::folderService()->updateFolder($data['id'], $data['folder_name']));
    });

    Flight::route("POST /addFolder", function() {
        $data = Flight::request()->data->getData();

        Flight::json(Flight::folderService()->add($data));
    });

    Flight::route("DELETE /deleteFolder/@id", function($id) {
        Flight::json(Flight::folderService()->delete($id));
    });

?>