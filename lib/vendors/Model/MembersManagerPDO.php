<?php
namespace Model;

use \Entity\Member;

class MembersManagerPDO extends MembersManager {
	
	public function getList($debut = -1, $limite = -1) {
	  
		$sql = 'SELECT id, name, mailAddress, password, privilegeId, dateInscription FROM members ORDER BY id DESC';
		
		if ($debut != -1 || $limite != -1) {
		
		$sql .= ' LIMIT '.(int) $limite.' OFFSET '.(int) $debut;
		}
    
		$requete = $this->dao->query($sql);
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Member');
    
		$listeMember = $requete->fetchAll();
    
		foreach ($listeMember as $member) {
			
			$member->setDateAjout(new \DateTime($member->dateAjout()));
			$member->setDateModif(new \DateTime($member->dateModif()));
		}
    
		$requete->closeCursor();
    
		return $listeMember;
	}
	
	public function getUnique($id) {
		
		$requete = $this->dao->prepare('SELECT id, name, mailAddress, password, privilegeId, dateInscription FROM members WHERE id = :id');
		$requete->bindValue(':id', (int) $id, \PDO::PARAM_INT);
		$requete->execute();
    
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Member');
    
		if ($member = $requete->fetch()) {
			
			$member->setDateInscription(new \DateTime($member->dateInscription()));
      
			return $member;
		}
    
		return null;
	}
	
	public function getMember($mailAddress, $password) {
		
		$requete = $this->dao->prepare('SELECT id, name, mailAddress, password, privilegeId, dateInscription FROM members WHERE mailAddress = :mailAddress');
		$requete->bindValue(':mailAddress', $mailAddress);
		$requete->execute();
    
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Member');
    
		if ($member = $requete->fetch()) {
			$member->setDateInscription(new \DateTime($member->dateInscription()));
			
			// Comparaison du pass envoyé via le formulaire avec la base
            if(password_verify($password, $member->password())) {
				return $member;
			}

		}
    
		return null;
	}
	
	public function count() {
		
		return $this->dao->query('SELECT COUNT(*) FROM members')->fetchColumn();
	}

	protected function add(Member $member) {
		
		// Hachage du mot de passe
		$pass_hache = password_hash($member->password(), PASSWORD_DEFAULT);
		
		$requete = $this->dao->prepare('INSERT INTO members SET name = :name, password = :password, mailAddress = :mailAddress, dateInscription = NOW()');
    
		$requete->bindValue(':name', $member->name());
		$requete->bindValue(':password', $pass_hache);
		$requete->bindValue(':mailAddress', $member->mailAddress());
		$requete->execute();
	}
	
	public function saveHash($hash, $mailAddress) {

		$requete = $this->dao->prepare('INSERT INTO mailConf SET hashMail = :hashMail, mailAddress = :mailAddress');
		$requete->bindValue(':hashMail', $hash);
		$requete->bindValue(':mailAddress', $mailAddress);
		$requete->execute();
	}

	public function validMember($hash) {

		$requete = $this->dao->prepare('UPDATE members INNER JOIN mailConf ON mailConf.mailAddress = members.mailAddress SET members.privilegeId = :privilegeId WHERE mailConf.hashMail = :hashMail');
		$requete->bindValue(':privilegeId', 4);
		$requete->bindValue(':hashMail', $hash);
		$requete->execute();
		
	}
	
	public function deleteHash($hash) {
		
		$this->dao->prepare('DELETE FROM mailConf WHERE hashMail = :hash');
		$requete->bindValue(':hash', $hash);
		$requete->execute();
	}

	protected function checkIfExist(Member $member) {
		
		$requete = $this->dao->prepare('SELECT COUNT(*) AS exist FROM members WHERE mailAddress = :mailAddress');
		$requete->bindValue(':mailAddress', $member->mailAddress());
    
		$requete->execute();
		
		if($donnees = $requete->fetch() > 0) {
			return true;
		}
		
		return false;
	}
	
	protected function checkPassword(Member $member) {
		
		echo $member->mailAddress();
		$requete = $this->dao->prepare('SELECT password FROM members WHERE id = :id');
		$requete->bindValue(':id', $member->id());
		$requete->execute();
		
		$password = $requete->fetch();
			
			
		// Comparaison du pass envoyé via le formulaire avec la base
		if(password_verify($member->password(), $password['password'])) {
			return true;
		}
        
    
		return false;
	}
	
	protected function modify(Member $member) {
		
		$requete = $this->dao->prepare('UPDATE members SET name = :name, password = :password, mailAddress = :mailAddress, statut = :statut WHERE id = :id');
    
		$requete->bindValue(':name', $member->name());
		$requete->bindValue(':password', $member->password());
		$requete->bindValue(':mailAddress', $member->mailAddress());
		$requete->bindValue(':privilegeId', $member->privilege_id());
		$requete->bindValue(':id', $member->id(), \PDO::PARAM_INT);
    
		$requete->execute();
	}
	
	public function updateMail(Member $member) {
		
		if(!$this->checkPassword($member)) {
			return false;
		}
		
		$requete = $this->dao->prepare('UPDATE members SET mailAddress = :mailAddress WHERE id = :id');

		$requete->bindValue(':mailAddress', $member->mailAddress());
		$requete->bindValue(':id', $member->id(), \PDO::PARAM_INT);
    
		$requete->execute();
		
		return true;
	}
	
	public function updatePassword(Member $member) {
		
		// Hachage du mot de passe
		$pass_hache = password_hash($member->password(), PASSWORD_DEFAULT);

		
		$requete = $this->dao->prepare('UPDATE members SET password = :password WHERE id = :id');

		$requete->bindValue(':password', $pass_hache);
		$requete->bindValue(':id', $member->id());
    
		$requete->execute();
		
		return true;
	}

	public function delete($id) {
		
		$this->dao->exec('DELETE FROM members WHERE id = '.(int) $id);
	}
}


