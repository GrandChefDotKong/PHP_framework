<?php
namespace App\Frontend\Modules\Game;

use \AdoFram\BackController;
use \AdoFram\HTTPRequest;
use \Entity\Member;


class GameController extends BackController {
	
	public function executeList(HTTPRequest $request) {
	 
		$this->page->addVar('title', 'Game List');
		
	}

	public function executeSnake(HTTPRequest $request) {
		
		// $this->checkAccess();
	 
		$this->page->addVar('title', 'Snake Game');
		
	}

	public function executeJump(HTTPRequest $request) {
		
		// $this->checkAccess();
	 
		$this->page->addVar('title', 'Infinite Runner Game');
		
	}
	
	public function checkAccess() {
		
		if(!$this->app->user()->isAuthenticated()) {
			$this->app->user()->setFlash('Vous devez être connecté !');
			$this->app->httpResponse()->redirect('/Web/login.html');
		}
	}	
}





