<?php
namespace FormBuilder;

use \AdoFram\FormBuilder;
use \AdoFram\StringField;
use \AdoFram\TextField;
use \AdoFram\MaxLengthValidator;
use \AdoFram\NotNullValidator;
use \AdoFram\MailAddressValidator;

class UpdatePasswordFormBuilder extends FormBuilder {
	
	public function build() {
		
		$this->form->add(new StringField([
			'label' => 'Nouveau mot de passe',
			'name' => 'password',
			'fieldType' => 'password',
			'validators' => [
				new NotNullValidator('Merci de spécifier votre mot de passe'),
			],
		]));
	}
}
