<?php
namespace Model;

use \AdoFram\Manager;
use \Entity\Member;

abstract class MembersManager extends Manager {
	
  /**
   * Méthode retournant une liste de membres demandée
   * @param $debut int Le premièr membre à sélectionner
   * @param $limite int Le nombre de membre à sélectionner
   * @return array La liste des membres. Chaque entrée est une instance de Member.
   */
	abstract public function getList($debut = -1, $limite = -1);
  
  
  /**
   * Méthode retournant un membre précis.
   * @param $id int L'identifiant de la membre à récupérer
   * @return Member Le membre demandé
   */
	abstract public function getUnique($id);
  
  
  /**
   * Méthode renvoyant le nombre de membre total.
   * @return int
   */
	abstract public function count();
	
	
  /**
   * Méthode permettant d'ajouter un membre.
   * @param $member Member Le membre à ajouter
   * @return void
   */
	abstract protected function add(Member $member);
  
  /**
   * Méthode permettant d'enregistrer un membre.
   * @param $member Member le membre à enregistrer
   * @see self::add()
   * @see self::modify()
   * @return void
   */
	public function save(Member $member) {
		
		if ($member->isValid()) {
			$member->isNew() ? $this->add($member) : $this->modify($member);
		}
		else {
			
			throw new \RuntimeException('Le membre doit être validé pour être enregistré');
		}
	}
	
  /**
   * Méthode permettant de modifier un membre.
   * @return void
   */
	abstract protected function modify(Member $member);
  
}


