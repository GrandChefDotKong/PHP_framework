<?php
namespace AdoFram;

class StringField extends Field {
	
	protected $maxLength;
	protected $fieldType = 'text';
	protected $required = true;

  
	public function buildWidget() {
		
		$widget = '';
    
		if (!empty($this->errorMessage)) {
			
			$widget .= $this->errorMessage.'<br />';
		}
    
		$widget .= '<label for="'.$this->id.'">'.$this->label.'</label><input type="'.$this->fieldType.'" id="'.$this->id.'" name="'.$this->name.'"';
	
		if (!empty($this->value)) {
			
			$widget .= ' value="'.htmlspecialchars($this->value).'"';
		}
    
		if (!empty($this->maxLength)) {
			
			$widget .= ' maxlength="'.$this->maxLength.'"';
		}
		
		if ($this->required) {
			
			$widget .= ' required';
		}
    
		return $widget .= ' />  <span id="aide'.$this->id.'" ></span>';
	}
  
	public function setMaxLength($maxLength) {
		
		$maxLength = (int) $maxLength;
    
		if ($maxLength > 0) {
			
			$this->maxLength = $maxLength;
		}
		else {
			
			throw new \RuntimeException('La longueur maximale doit être un nombre supérieur à 0');
		}
	}
	
	public function setFieldType($fieldType) {
		
		if ($fieldType == 'text' || $fieldType == 'email' || $fieldType == 'password') {
			
			$this->fieldType = $fieldType;
		}
		else {
			
			throw new \RuntimeException('Le type spécifié n\'existe pas.');
		}
	}
	
	public function setRequired($fieldType) {
		
		if(is_bool($fieldType)) {
			$this->fieldType = $fieldType;
		}
		else {
			throw new \RuntimeException('Booléen uniquement.');
		}
	}	
}



