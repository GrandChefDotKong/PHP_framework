<?php
namespace App\Backend\Modules\Connexion;

use \AdoFram\BackController;
use \AdoFram\HTTPRequest;
use \Entity\Member;
use \FormBuilder\ConnexionFormBuilder;
use \FormBuilder\RegisterFormBuilder;
use \AdoFram\FormHandler;


class ConnexionController extends BackController {
	
	public function executeLogin(HTTPRequest $request) {
		
		if($this->app->user()->isAuthenticated()) {
			$this->app->user()->setFlash('Vous étes déjà connecté !');
			$this->app->httpResponse()->redirect('/monsupersite/Web/');
			return;
		}
		
		// Si le formulaire a été envoyé.
		if ($request->method() == 'POST') {
			$member = new Member([
				'mailAddress' => $request->postData('mailAddress'),
				'password' => $request->postData('password'),
			]);
		}
		else {
			$member = new Member;
		}
		
		$formBuilder = new ConnexionFormBuilder($member);
		$formBuilder->build();
	 
		$form = $formBuilder->form();
	 
		if ($request->method() == 'POST' && $form->isValid()) {
			$member = $this->managers->getManagerOf('Members')->getMember($member->mailAddress(), $member->password());
			
			if($member == null) {
				$this->app->user()->setFlash('Mot de passe ou adresse mail incorecte !');
				$this->app->httpResponse()->redirect('/monsupersite/Web/login.html');
			}
			
			$this->app->user()->connectUser($member);
			$this->app->user()->setFlash('Bienvenu '. $_SESSION['pseudo'] .'. Vous étes connecté !');
			$this->app->httpResponse()->redirect('/monsupersite/Web/');
		}
	 
		$this->page->addVar('member', $member);
		$this->page->addVar('form', $form->createView());
		$this->page->addVar('title', 'Connexion');
	}
	
	public function executeRegister(HTTPRequest $request) {
		
		if ($request->method() == 'POST') {
			$member = new Member([
				'name' => $request->postData('name'),
				'mailAddress' => $request->postData('mailAddress'),
				'password' => $request->postData('password'),
			]);
		}
		else {
			$member = new Member;
		}
	 
		$formBuilder = new RegisterFormBuilder($member);
		$formBuilder->build();
	 
		$form = $formBuilder->form();
	 
		$formHandler = new FormHandler($form, $this->managers->getManagerOf('Members'), $request);
		
		try {
	 
			if ($formHandler->process()) {
				$this->app->user()->setFlash('Vous étes inscrit !');
				$this->app->httpResponse()->redirect('/monsupersite/Web/login.html');
			}
	 
		}
		catch (\PDOException $e) {
			if($e->getCode() == 23000) {
				$this->app->user()->setFlash("Un compte utilisant cette adresse existe déjà !");
				$this->app->httpResponse()->redirect('/monsupersite/Web/register.html');
			} 
		}
		
		$this->page->addVar('member', $member);
		$this->page->addVar('form', $form->createView());
		$this->page->addVar('title', 'Inscription');
	} 
	
	public function executeLogout(HTTPRequest $request) {
		
		$this->app->user()->disconnectUser();
		$this->app->user()->setFlash('Vous étes déconnecté !');
		$this->app->httpResponse()->redirect('/monsupersite/Web/login.html');

	}
}





