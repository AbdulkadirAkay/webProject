<?php
  require_once 'BaseService.php';
  require_once __DIR__."/../dao/DecksDao.class.php";

  class DeckService extends BaseService{
    public function __construct(){
        parent::__construct(new DecksDao);
    }

    public function updateDeck($id, $deckName) {
        $this->dao->updateDeck($id, $deckName);
      }
    
      public function getDecksByFolder($id) {
        return $this->dao->getDecksByFolder($id);
      }
  }
?>