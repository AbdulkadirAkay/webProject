<?php
  require_once 'BaseDao.class.php';

  class DecksDao extends BaseDao {
    public function __construct() {
      parent::__construct("decks");
    }


    public function updateDeck($id, $deckname){
      return $this->query("UPDATE decks SET deck_name = :deckname WHERE id = :id", ['deckname'=>$deckname, 'id'=>$id]);
    }

    public function getDecksByFolder($id) {
      return $this->query("SELECT d.id, d.deck_name FROM decks d JOIN folder_decks fd ON d.id = fd.deck_id JOIN folders f ON f.id = fd.folder_id WHERE f.id = :id", ['id'=>$id]);
    }
  }
?>