<?php
  require_once 'BaseDao.class.php';

  class CardsDao extends BaseDao {
    public function __construct() {
      parent::__construct("cards");
    }

    public function getCardsByFolder($id) {
     
    }

    public function updateCard($id, $question, $answer){
      return $this->query("UPDATE decks SET question = :question, answer = :answer, WHERE id = :id", ['question' =>$question, 'answer'=>$answer, 'id'=>$id]);
    }

    public function getCardsByDeck($id) {
      return $this->query("SELECT * FROM cards WHERE deck_id = :id",['id'=> $id]);
    }
  }
?>