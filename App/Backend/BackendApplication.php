<?php
namespace App\Backend;

use \AdoFram\Application;

class BackendApplication extends Application {
	
	public function __construct() {
		
		parent::__construct();

		$this->name = 'Backend';
	}

	public function run() {
		
		if ($this->user->isAdministrator()) {
			
			$controller = $this->getController();
			$controller->execute();

			$this->httpResponse->setPage($controller->page());
			$this->httpResponse->send();
		}
		else {
			
			// $controller = new Modules\Connexion\ConnexionController($this, 'Connexion', 'login');
			
			$this->user()->setFlash('Espace réservé aux administrateurs !');
			$this->httpResponse()->redirect('/login.html');
		}
	}
}




