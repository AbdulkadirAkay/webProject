<?php

class Config {
    public static function DB_HOST(){
      return 'localhost';
    }

    public static function DB_USERNAME(){
      return 'root';
    }

    public static function DB_PASSWORD(){
      return 'root717';
    }

    public static function DB_SCHEMA(){
      return 'flashcards';
    }

    public static function DB_PORT() {
        return "3306";
    }

    public static function JWT_SECRET(){
      return Config::get_env("JWT_SECRET", "ezcb9s8UcF");
    }

    public static function get_env($name, $default){
      return isset($_ENV[$name]) && trim($_ENV[$name]) != '' ? $_ENV[$name] : $default;
     }
}
?>