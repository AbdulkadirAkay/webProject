<?php
    Flight::route('POST /register', function(){
        $data = Flight::request()->data->getData();
        $data['password_hash'] = md5($data['password_hash']);
        $user = Flight::userService()->add($data);
        Flight::json($user);
      }
    );


    Flight::route('POST /login', function(){
        $login = Flight::request()->data->getData();
        $user = Flight::userService()->getUserByEmail($login['email']);
        if (isset($user['id'])){
          if($user['password_hash'] == md5($login['password_hash'])){
            unset($user['password_hash']);
            Flight::json($user, 200);
          }else{
            Flight::json(["message" => "Wrong password"], 500);
          }
        }else{
          Flight::json(["message" => "User doesn't exist"], 500);
        }
    });

    Flight::route('PUT /update/@id', function($id) {
      $data = Flight::request()->data->getData();
      

      Flight::userService()->updateProfile($id, $data['first_name'], $data['last_name'], $data['email'], md5($data['password_hash']));
    });
?>