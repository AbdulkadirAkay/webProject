<?php
  require_once 'BaseService.php';
  require_once __DIR__."/../dao/FolderDecksDao.class.php";

  class FolderDeckService extends BaseService{
    public function __construct(){
        parent::__construct(new FolderDecksDao);
    }

    public function getFolderDeckByFolder($id) {
      return $this->dao->getFolderDeckByFolder($id);
    }

    public function getFolderDeckByDeck($id) {
      return $this->dao->getFolderDeckByDeck($id);
    }

    public function deleteByFolder($id) {
      $this->dao->deleteByFolder($id);
    }

    public function deleteByDeck($id) {
      $this->dao->deleteByDeck($id);
    }
  }
?>