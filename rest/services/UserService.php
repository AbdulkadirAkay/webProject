<?php
  require_once 'BaseService.php';
  require_once __DIR__."/../dao/UsersDao.class.php";

  class UserService extends BaseService{
    public function __construct(){
        parent::__construct(new UsersDao);
    }
    
    public function getUserByEmail($email){
      return $this->dao->getUserByEmail($email);
    }

    public function updateProfile($id, $firstname, $lastname, $email, $password) {
      $this->dao->updateProfile($id, $firstname, $lastname, $email, $password);
    }
  }
?>