<?php
namespace AdoFram;

class MailAddressValidator extends Validator {
	
	protected $mailRegex = "#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#";
  
	public function __construct($errorMessage) {
		
		parent::__construct($errorMessage);
    
	}
  
	public function isValid($value) {
		
		if (preg_match($this->mailRegex, $value)) {
			return true;
		}
		else {
			return false;
		}
	}
 
}



