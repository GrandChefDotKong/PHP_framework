<?php
namespace AdoFram;

use \Entity\Member;

session_start();

class User {
	
	public function getAttribute($attr) {
		
		return isset($_SESSION[$attr]) ? $_SESSION[$attr] : null;
	}

	public function getFlash() {
		
		$flash = $_SESSION['flash'];
		unset($_SESSION['flash']);

		return $flash;
	}

	public function hasFlash() {
		
		return isset($_SESSION['flash']);
	}

	public function isAuthenticated() {
		
		return isset($_SESSION['auth']) && $_SESSION['auth'] === true;
	}

	public function isAdministrator() {
		
		if(isset($_SESSION['privilege'])) {
			if($_SESSION['privilege'] == 1 || $_SESSION['privilege'] == 2) {
				return true;
			}
		}
		
		return false;
	}

	public function setAttribute($attr, $value) {
		
		$_SESSION[$attr] = $value;
	}

	public function setAuthenticated($authenticated = true) {
		
		if (!is_bool($authenticated)) {
			throw new \InvalidArgumentException('La valeur spécifiée à la méthode User::setAuthenticated() doit être un boolean');
		}
		
		$_SESSION['auth'] = $authenticated;
	}

	public function setFlash($value) {
		
		$_SESSION['flash'] = $value;
		echo 'ty';
	}
	
	public function connectUser($member) {
		
		$this->setAuthenticated(true);
		
		$_SESSION['id'] = $member->id();
		$_SESSION['pseudo'] = $member->name();
		$_SESSION['mailAddress'] = $member->mailAddress();
		$_SESSION['privilege'] = $member->privilegeId();
		$_SESSION['password'] = $member->password();
		
	}
	
	public function disconnectUser() {
		
		$this->setAuthenticated(false);
		
		$_SESSION = array();
		session_destroy();	
	}
	
}


