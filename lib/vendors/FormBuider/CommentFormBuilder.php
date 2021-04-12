<?php
namespace FormBuilder;

use \AdoFram\FormBuilder;
use \AdoFram\StringField;
use \AdoFram\TextField;
use \AdoFram\MaxLengthValidator;
use \AdoFram\NotNullValidator;

class CommentFormBuilder extends FormBuilder {
	
	public function build() {
		$this->form->add(new TextField([
			'label' => 'Contenu',
			'name' => 'contenu',
			'id' => 'contenu',
			'rows' => 7,
			'cols' => 50,
			'validators' => [
				new NotNullValidator('Merci de spécifier votre commentaire'),
			],
		]));
	}
}


