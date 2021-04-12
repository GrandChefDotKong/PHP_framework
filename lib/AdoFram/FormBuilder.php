<?php
namespace AdoFram;

abstract class FormBuilder  {
	
	protected $form;
	
	public function __construct(Entity $entity = null) {
		
		if($entity != null) {
			$this->setForm(new Form($entity));
		}
		else {
			$this->setForm(new Form());
		}
	}
  
	abstract public function build();
	
	public function setForm(Form $form) {
		
		$this->form = $form;
	}
  
	public function form() {
		return $this->form;
	}
}





