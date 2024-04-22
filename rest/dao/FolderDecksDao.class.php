<?php
  require_once 'BaseDao.class.php';

  class FolderDecksDao extends BaseDao {
    public function __construct() {
      parent::__construct("folder_decks");
    }

    public function getFolderDeckByFolder($id) {
      return $this->query("SELECT * FROM folder_decks WHERE folder_id = :folderId", ['folderId' => $id]);
    }

    public function getFolderDeckByDeck($id) {
      return $this->query("SELECT * FROM folder_decks WHERE deck_id = :deckId", ['deckId' => $id]);
    }

    public function deleteByFolder($id) {
      $this->query("DELETE FROM folder_decks WHERE folder_id = :folderId", ['folderId' => $id]);
    }

    public function deleteByDeck($id) {
      $this->query("DELETE FROM folder_decks WHERE deck_id = :deckId", ['deckId' => $id]);
    }
  }
?>