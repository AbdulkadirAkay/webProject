<?php
  require_once 'BaseDao.class.php';

  class FoldersDao extends BaseDao {
    public function __construct() {
      parent::__construct("folders");
    }

    public function updateFolder($id, $foldername){
      return $this->query("UPDATE folders SET folder_name = :foldername WHERE id = :id", ['foldername'=> $foldername, 'id' => $id]);
    }

    public function getFoldersByUser($id) {
      return $this->query("SELECT * FROM folders WHERE user_id = :id", ['id' => $id]);
    }
  }
?>