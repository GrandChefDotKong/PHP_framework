<?php
namespace Model;

use \Entity\Message;

class MessagesManagerPDO extends MessagesManager {
	
	protected function add(Message $message) {
		
		$q = $this->dao->prepare('INSERT INTO chat SET auteur = :auteur, contenu = :contenu, date = NOW()');
    
		$q->bindValue(':auteur', $message->auteur());
		$q->bindValue(':contenu', $message->contenu());
    
		$q->execute();
    
		$message->setId($this->dao->lastInsertId());
	}
	
	public function getListOf($id) {
		
		if (!ctype_digit($id)) {
			throw new \RuntimeException('L\'identifiant de la news passé doit être un nombre entier valide');
		}
    
		$q = $this->dao->prepare('SELECT id, auteur, contenu, date FROM chat WHERE id > :id  ORDER BY id');
		$q->bindValue(':id', $id, \PDO::PARAM_INT);
		$q->execute();
    
		$q->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Message');
    
		$messages = $q->fetchAll();

		foreach ($messages as $message) {
			
			$message->setDate(new \DateTime($message->date()));
		}

		return $messages;
	}
}



