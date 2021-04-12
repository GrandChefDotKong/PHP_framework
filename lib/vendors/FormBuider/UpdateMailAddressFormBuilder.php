<?php
namespace FormBuilder;

use \AdoFram\FormBuilder;
use \AdoFram\StringField;
use \AdoFram\TextField;
use \AdoFram\MaxLengthValidator;
use \AdoFram\NotNullValidator;
use \AdoFram\MailAddressValidator;

class UpdateMailAddressFormBuilder extends FormBuilder {
	
	public function build() {
		
		$this->form->add(new StringField([
			'label' => 'Password',
			'name' => 'password',
			'fieldType' => 'password',
			'validators' => [
				new NotNullValidator('Merci de spécifier votre mot de passe'),
			],
		]))
			->add(new StringField([
			'label' => 'Nouvelle adresse mail',
			'name' => 'mailAddress',
			'fieldType' => 'email',
			'validators' => [
				new NotNullValidator('Merci de spécifier votre adresse email'),
				new MailAddressValidator('Merci de spécifier une adresse email valide !'),
			],
		]));
	}
}