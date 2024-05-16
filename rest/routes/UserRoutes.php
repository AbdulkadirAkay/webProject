<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

/**
* register user
*/
/**
* @OA\Post(
*     path="/register",
*     description="Register to the system",
*     tags={"Register"},
*     @OA\RequestBody(description="Basic user info", required=true,
*       @OA\MediaType(mediaType="application/json",
*    			@OA\Schema(
*           @OA\Property(property="first_name", type="string", example="John"),
*           @OA\Property(property="last_name", type="string", example="Doe"),
*    				@OA\Property(property="email", type="string", example="test12@gmail.com"),
*    				@OA\Property(property="password_hash", type="string", example="123456",	description="Password" ),
*    				)
*     )),
*     @OA\Response(
*         response=200,
*         description="JWT Token on successful response"
*     ),
*     @OA\Response(
*         response=404,
*         description="Wrong Password | User doesn't exist"
*     )
* )
*/
    Flight::route('POST /register', function(){
        $data = Flight::request()->data->getData();
        $data['password_hash'] = md5($data['password_hash']);
        $user = Flight::userService()->add($data);
        Flight::json($user);
      }
    );


      /**
    * @OA\Post(
    *     path="/login", 
    *     description="Login",
    *     tags={"Login"},
    *     @OA\RequestBody(description="Login", required=true,
    *       @OA\MediaType(mediaType="application/json",
    *    			@OA\Schema(
    *             @OA\Property(property="email", type="string", example="user@email.com",	description="User email" ),
    *             @OA\Property(property="password", type="string", example="12345678",	description="Password" ),
    *        )
    *     )),
    *     @OA\Response(
    *         response=200,
    *         description="Logged in successfuly"
    *     ),
    *     @OA\Response(
    *         response=500,
    *         description="Error"
    *     )
    * )
    */
        Flight::route('POST /login', function(){
      $login = Flight::request()->data->getData();
      $user = Flight::userService()->getUserByEmail($login['email']);
      if (isset($user['id'])){
        if($user['password_hash'] == md5($login['password_hash'])){
          unset($user['password_hash']);
          $jwt = JWT::encode($user, Config::JWT_SECRET(), 'HS256');
          Flight::json(['token' => $jwt]);
        }else{
          Flight::json(["message" => "Wrong password"], 404);
        }
      }else{
        Flight::json(["message" => "User doesn't exist"], 404);
      }
    });
    

      /**
    * @OA\Put(
    *     path="/update/{id}", 
    *     description="Update Profile",
    *     tags={"Update"},
    *     @OA\RequestBody(description="Update Profile", required=true,
    *       @OA\MediaType(mediaType="application/json",
    *    			@OA\Schema(
    *           @OA\Property(property="first_name", type="string", example="John"),
    *           @OA\Property(property="last_name", type="string", example="Doe"),
    *    				@OA\Property(property="email", type="string", example="test12@gmail.com"),
    *    				@OA\Property(property="password_hash", type="string", example="123456",	description="Password" ),
    *        )
    *     )),
    *     @OA\Response(
    *         response=200,
    *         description="Update in successfuly"
    *     ),
    *     @OA\Response(
    *         response=500,
    *         description="Error"
    *     )
    * )
    */
    Flight::route('PUT /update/@id', function($id) {
      $data = Flight::request()->data->getData();
      

      Flight::userService()->updateProfile($id, $data['first_name'], $data['last_name'], $data['email'], md5($data['password_hash']));
    });
?>