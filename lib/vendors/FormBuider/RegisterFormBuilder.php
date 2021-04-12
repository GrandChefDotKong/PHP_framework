<?php
namespace FormBuilder;

use \AdoFram\FormBuilder;
use \AdoFram\StringField;
use \AdoFram\TextField;
use \AdoFram\MaxLengthValidator;
use \AdoFram\MinLengthValidator;
use \AdoFram\NotNullValidator;
use \AdoFram\MailAddressValidator;

class RegisterFormBuilder extends FormBuilder {
	
	public function build() {
		
		$this->form->add(new StringField([
			'id' => 'pseudo',
			'label' => 'Pseudo',
			'name' => 'name',
			'maxLength' => 20,
			'validators' => [
				new NotNullValidator('Merci de spécifier votre pseudo'),
				new MaxLengthValidator('L\'auteur spécifié est trop long (20 caractères maximum)', 20),
			],
		]))
		->add(new StringField([
			'id' => 'mailAddress',
			'label' => 'Adresse mail',
			'name' => 'mailAddress',
			'fieldType' => 'email',
			'validators' => [
				new NotNullValidator('Merci de spécifier votre adresse email'),
				new MailAddressValidator('Merci de spécifier une adresse email valide !'),
			],
		]))
		->add(new StringField([
			'id' => 'password',
			'label' => 'Password',
			'name' => 'password',
			'fieldType' => 'password',
			'validators' => [
				new NotNullValidator('Merci de spécifier votre mot de passe'),
			],
		]));
	}
}