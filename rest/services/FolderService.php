<?php
  require_once 'BaseService.php';
  require_once __DIR__."/../dao/FoldersDao.class.php";

  class FolderService extends BaseService{
    public function __construct(){
        parent::__construct(new FoldersDao);
    }

    public function updateFolder($id, $folderName) {
      $this->dao->updateFolder($id, $folderName);
    }

    public function getFoldersByUser($id) {
      return $this->dao->getFoldersByUser($id);
    }
  }
?>