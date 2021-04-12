<?php
namespace App\Frontend\Modules\Connexion;

use \AdoFram\BackController;
use \AdoFram\HTTPRequest;
use \Entity\Member;
use \FormBuilder\ConnexionFormBuilder;
use \FormBuilder\RegisterFormBuilder;
use \AdoFram\FormHandler;

class ConnexionController extends BackController {
	
	public function executeLogin(HTTPRequest $request) {
		
		if($this->app->user()->isAuthenticated()) {
			$this->app->user()->setFlash("You're login !");
			$this->app->httpResponse()->redirect('/');
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
				$this->app->user()->setFlash('Wrong password or mail address !');
				$this->app->httpResponse()->redirect('/login.html');
			}
			
			$this->app->user()->connectUser($member);
			$this->app->user()->setFlash('Bienvenu '. $_SESSION['pseudo'] .'. You\'re login :)');
			$this->app->httpResponse()->redirect('/');
		}
	 
		$this->page->addVar('member', $member);
		$this->page->addVar('form', $form->createView());
		$this->page->addVar('title', 'Login');
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

				$hash = $this->generateHash();
				$this->managers->getManagerOf('Members')->saveHash($hash, $member->mailAddress());
				$this->sendMail($hash, $member->mailAddress());

				$this->app->user()->setFlash("You've been registered. Please check your email box !");
				$this->app->httpResponse()->redirect('/login.html');
			}
	 
		}
		catch (\PDOException $e) {
			if($e->getCode() == 23000) {
				$this->app->user()->setFlash("An account using this mail address or name already exit !");
				$this->app->httpResponse()->redirect('/register.html');
			} 
		}
		
		$this->page->addVar('member', $member);
		$this->page->addVar('form', $form->createView());
		$this->page->addVar('title', 'Register');
	} 

	protected function generateHash() {
		$hash = "azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN1234567890_-+*:";
		$hash = str_shuffle($hash);
		$hash = substr($hash, 0, 12);
		return $hash;
	}

	protected function sendMail($hash, $mailAddress) {

		ini_set( 'display_errors', 1 );
 		error_reporting( E_ALL );
 
	    $from = "verify@adrienpauchet.000webhostapp.com";
	 
	    $to = $mailAddress;
	 
	    $subject = "Vérification PHP mail";
	 
	    $message = "Thank to register to adrienpauchet.com. To complete your registration please click the link below \n https://adrienpauchet.000webhostapp.com/verify-" . $hash  .".html";

	    $headers = "From:" . $from;
	 
	    mail($to,$subject,$message, $headers);	
	}
	
	public function executeLogout(HTTPRequest $request) {
		
		$this->app->user()->disconnectUser();
		$this->app->user()->setFlash('See ya !');
		$this->app->httpResponse()->redirect('/');

	}

	public function executeVerify(HTTPRequest $request) {

		if($request->getData('hash') != null) {
		    
			$this->managers->getManagerOf('Members')->validMember($request->getData('hash'));
			$this->managers->getManagerOf('Members')->deleteHash($request->getData('hash'));
			$this->app->user()->setFlash('Your mail address has been validated !');
			$this->app->httpResponse()->redirect('/');
		}

	}
}





