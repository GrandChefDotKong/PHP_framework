<?php

namespace Model;

use \AdoFram\Manager;
use \Entity\Message;

abstract class MessagesManager extends Manager {
	
	/**
	 * Méthode permettant d'ajouter un commentaire
	 * @param $message Le commentaire à ajouter
	 * @return void
	*/
	abstract protected function add(Message $message);
	
  
	/**
	 * Méthode permettant d'enregistrer un commentaire.
	 * @param $message Le commentaire à enregistrer
	 * @return void
	*/
	public function save(Message $message) {
		
		if ($message->isValid()) {
			
			$message->isNew() ? $this->add($message) : $this->modify($message);
		}
		else {
			
		throw new \RuntimeException('Le message doit être validé pour être enregistré');
		}
	}
	
	/**
	 * Méthode permettant de récupérer une liste de commentaires.
	 * @param $news La news sur laquelle on veut récupérer les commentaires
	 * @return array
	*/
	abstract public function getListOf($id);
	
}

