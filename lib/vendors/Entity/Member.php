<?php
namespace Entity;

use \AdoFram\Entity;

class Member extends Entity {
	
	protected $id,
			  $name,
			  $password,
              $mailAddress,
			  $privilegeId,
              $dateInscription;

	const NAME_INVALIDE = 1;
	const PASSWORD_INVALIDE = 2;
	const MAIL_INVALIDE = 3;
	const ID_INVALIDE = 4;

	public function isValid() {
		
		return !(empty($this->name) || empty($this->password) || empty($this->mailAddress));
	}


	// SETTERS //
	
	public function setId($id) {
		
		if (empty($name)) {
			$this->erreurs[] = self::ID_INVALIDE;
		}

		$this->id = (int) $id;
	}

	public function setName($name) {
		
		if (!is_string($name) || empty($name)) {	
			$this->erreurs[] = self::NAME_INVALIDE;
		}

		$this->name = $name;
	}

	public function setPassword($password) {
		
		if (!is_string($password) || empty($password)) {	
			$this->erreurs[] = self::PASSWORD_INVALIDE;
		}

		$this->password = $password;
	}

	public function setMailAddress($mailAddress) {
		
		if (!is_string($mailAddress) || empty($mailAddress)) {	
			$this->erreurs[] = self::MAIL_INVALIDE;
		}

		$this->mailAddress = $mailAddress;
	}
	
	public function setPrivilegeId($privilegeId) {
		
		if (empty($privilegeId)) {
			$this->privilegeId = 5;
		}

		$this->privilegeId = $privilegeId;
	}

	public function setDateInscription(\DateTime $dateInscription) {
		
		$this->dateInscription = $dateInscription;
	}


	// GETTERS //
	
	public function id() {
		
		return $this->id;
	}

	public function name() {
		
		return $this->name;
	}

	public function password() {
		
		return $this->password;
	}

	public function mailAddress() {
		
		return $this->mailAddress;
	}
	
	public function privilegeId() {
		
		return $this->privilegeId;
	}

	public function dateInscription() {
		
		return $this->dateInscription;
	}

}