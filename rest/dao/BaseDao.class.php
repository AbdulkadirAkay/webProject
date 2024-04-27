<?php
  require_once __DIR__."/../Config.class.php";
  
  class BaseDao {
    private $conn;
    private $table_name;

    public function __construct($table_name) {
      try {
        $db_info = array(
          'host' => Config::DB_HOST(),
          'port' => Config::DB_PORT(),
          'name' => Config::DB_SCHEMA(),
          'user' => Config::DB_USERNAME(),
          'pass' => Config::DB_PASSWORD()
          );

          $options = array(
  
          );

        $this->table_name = $table_name;

        $this->conn = new PDO( 'mysql:host=' . $db_info['host'] . ';port=' . $db_info['port'] . ';dbname=' . $db_info['name'], $db_info['user'], $db_info['pass'], $options );
        
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch(PDOException $e) {
        echo "Connection failed " . $e->getMessage();
      }
    }

    //Get all from entity
    public function get_all() {
      $stmt = $this->conn->prepare("SELECT * FROM " . $this->table_name);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Get by ID
    public function get_by_id($id) {
      $stmt = $this->conn->prepare("SELECT * FROM ".$this->table_name." WHERE id = :id");
      $stmt->execute(['id' => $id]);
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return reset($result);
    }

    //Delete
    public function delete($id){
      $stmt = $this->conn->prepare("DELETE FROM " . $this->table_name . " WHERE id=:id");
      $stmt->bindParam(':id', $id); // SQL injection prevention
      $stmt->execute();
    }

    //Add
    public function add($entity){
      $query = "INSERT INTO " . $this->table_name . " (";
      foreach ($entity as $column => $value) {
        $query .= $column.", ";
      }
      $query = substr($query, 0, -2);
      $query .= ") VALUES (";
      foreach ($entity as $column => $value) {
        $query .= ":".$column.", ";
      }
      $query = substr($query, 0, -2);
      $query .= ")";
  
      $stmt= $this->conn->prepare($query);
      $stmt->execute($entity); // sql injection prevention
      $entity['id'] = $this->conn->lastInsertId();
      return $entity;
    }

    public function query($query, $params){
      $stmt = $this->conn->prepare($query);
      $stmt->execute($params);
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
  
    public function query_unique($query, $params){
      $results = $this->query($query, $params);
      return reset($results);
    }
  }
?>