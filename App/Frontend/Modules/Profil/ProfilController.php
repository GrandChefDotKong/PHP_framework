<?php
namespace App\Frontend\Modules\Profil;

use \AdoFram\BackController;
use \AdoFram\HTTPRequest;
use \Entity\Member;
use \FormBuilder\UpdateMailAddressFormBuilder;
use \FormBuilder\UpdatePasswordFormBuilder;
use \AdoFram\FormHandler;


class ProfilController extends BackController {
	
	public function executeShow(HTTPRequest $request) {
		
		$this->checkAccess();
		
		// $member = $this->managers->getManagerOf('News')->getUnique($request->getData('id'));
	 
		$this->page->addVar('title', 'Mon Profil');
		
	}
	
	public function executeUpdateMail(HTTPRequest $request) {
		
		$this->checkAccess();
		
		$this->page->addVar('title', 'Mon Profil');
		
		// Si le formulaire a été envoyé.
		if ($request->method() == 'POST') {
			$member = new Member([
				'password' => $request->postData('password'),
				'mailAddress' => $request->postData('mailAddress'),
				'id' => $_SESSION['id'],
			]);
		}
		else {
			$member = new Member;
		}
		
		$formBuilder = new UpdateMailAddressFormBuilder($member);
		$formBuilder->build();
	 
		$form = $formBuilder->form();
		
		try {
	 
			if ($request->method() == 'POST' && $form->isValid()) {
				if(!$this->managers->getManagerOf('Members')->updateMail($member)) {
					$this->app->user()->setFlash('Mot de passe incorecte !');
					$this->app->httpResponse()->redirect('/Web/mapage-update-mail.html');
				}
			
				$_SESSION['mailAddress'] = $member->mailAddress();
			
				$this->app->user()->setFlash('Changement effectué !');
				$this->app->httpResponse()->redirect('/Web/mapage-show.html');
			}
	 
		}
		catch (\PDOException $e) {
			
			if($e->getCode() == 23000) {
				$this->app->user()->setFlash("Un compte utilisant cette adresse existe déjà !");
				$this->app->httpResponse()->redirect('/Web/mapage-update-mail.html');
			} 
		}
	 
		$this->page->addVar('member', $member);
		$this->page->addVar('form', $form->createView());
		$this->page->addVar('title', 'Update Mail');
	}

	public function executeUpdatePassword(HTTPRequest $request) {
		
		$this->checkAccess();
		
		$this->page->addVar('title', 'Mon Profil');
		
		// Si le formulaire a été envoyé.
		if ($request->method() == 'POST') {
		
			$member = new Member([
				'password' => $request->postData('password'),
				'id' => $_SESSION['id'],
			]);
		}
		else {
			$member = new Member;
		}
		
		$formBuilder = new UpdatePasswordFormBuilder($member);
		$formBuilder->build();
	 
		$form = $formBuilder->form();

		if ($request->method() == 'POST' && $form->isValid()) {
			if(!$this->managers->getManagerOf('Members')->updatePassword($member)) {
				$this->app->user()->setFlash('Mot de passe incorect !');
				$this->app->httpResponse()->redirect('/Web/mapage-update-password.html');
			}
			
			$_SESSION['password'] = $member->password();
			
			$this->app->user()->setFlash('Changement effectué !');
			$this->app->httpResponse()->redirect('/Web/mapage-show.html');
		}
	 
		$this->page->addVar('member', $member);
		$this->page->addVar('form', $form->createView());
		$this->page->addVar('title', 'Update Mail');
	}
	
	public function checkAccess() {
		
		if(!$this->app->user()->isAuthenticated()) {
			$this->app->user()->setFlash('Vous devez être connecté !');
			$this->app->httpResponse()->redirect('/Web/login.html');
		}
	}	
}





