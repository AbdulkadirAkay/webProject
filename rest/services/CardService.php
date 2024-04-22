<?php
  require_once 'BaseService.php';
  require_once __DIR__."/../dao/CardsDao.class.php";

  class CardService extends BaseService{
    public function __construct(){
        parent::__construct(new CardsDao);
    }

    public function updateCard($id, $question, $answer) {
        $this->dao->updateCard($id, $question, $answer);
      }

      public function getCardsByDeck($id) {
        return $this->dao->getCardsByDeck($id);
      }
  }
?>