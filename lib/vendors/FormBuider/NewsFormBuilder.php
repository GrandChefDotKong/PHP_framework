<?php
namespace FormBuilder;

use \AdoFram\FormBuilder;
use \AdoFram\StringField;
use \AdoFram\TextField;
use \AdoFram\MaxLengthValidator;
use \AdoFram\NotNullValidator;

class NewsFormBuilder extends FormBuilder {
	
	public function build() {
		
		$this->form->add(new StringField([
			'label' => 'Titre',
			'name' => 'titre',
			'maxLength' => 100,
			'validators' => [
				new MaxLengthValidator('Le titre spécifié est trop long (100 caractères maximum)', 100),
				new NotNullValidator('Merci de spécifier le titre de la news'),
			],
		]))
		->add(new TextField([
				'label' => 'Contenu',
			'name' => 'contenu',
			'id' => 'contenu',
			'rows' => 8,
			'cols' => 60,
			'validators' => [
				new NotNullValidator('Merci de spécifier le contenu de la news'),
			],
		]));
	}
}


