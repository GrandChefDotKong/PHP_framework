<?php
namespace App\Frontend\Modules\News;
 
use \AdoFram\BackController;
use \AdoFram\HTTPRequest;
use \Entity\Comment;
use \FormBuilder\CommentFormBuilder;
use \AdoFram\FormHandler;
use \AdoFram\BBCode;
 
class NewsController extends BackController {
	
	public function executeIndex(HTTPRequest $request) {


		$nombreNews = $this->app->config()->get('nombre_news');
		$nombreCaracteres = $this->app->config()->get('nombre_caracteres');
		$firstPage = 0;
		
		if($request->getData('idPage') > 0) {
			$firstPage = ($request->getData('idPage') - 1) * $nombreNews;
		}
	 
		// On récupère le manager des news.
		$manager = $this->managers->getManagerOf('News');
	 
		$listeNews = $manager->getList($firstPage, $nombreNews);
		
		if (empty($listeNews)) {	
			$this->app->httpResponse()->redirect404();
		}
		
		$nombrePage = $manager->count() / $nombreNews;
		if($manager->count() % $nombreNews != 0) {
			$nombrePage++;
		}
	 
		foreach ($listeNews as $news) {
			
			if (strlen($news->contenu()) > $nombreCaracteres) {
				
				$debut = substr($news->contenu(), 0, $nombreCaracteres);
				$debut = substr($debut, 0, strrpos($debut, ' ')) . '...';
	 
				$news->setContenu($debut);
			}
		}
	 
		// On ajoute la variable $listeNews à la vue.
		$this->page->addVar('listeNews', $listeNews);
		$this->page->addVar('nombrePage', $nombrePage);
	}
	 
	public function executeShow(HTTPRequest $request) {
		
		$news = $this->managers->getManagerOf('News')->getUnique($request->getData('id'));
	 
		if (empty($news)) {	
			$this->app->httpResponse()->redirect404();
		}
		
		$news->resizeImage(200);
		
		$this->page->addVar('title', $news->titre());
		$this->page->addVar('news', $news);
		$this->page->addVar('comments', $this->managers->getManagerOf('Comments')->getListOf($news->id()));
	
	}
	 
	public function executeInsertComment(HTTPRequest $request) {
		
		// Si le formulaire a été envoyé.
		if ($request->method() == 'POST') {
			
			$bbcode = new BBCode;
			$content = $bbcode->bbcodeToHtml($request->postData('contenu'));
			
			
			$comment = new Comment([
				'news' => $request->getData('news'),
				'auteur' => $_SESSION['pseudo'],
				'contenu' => $content
			]);
		}
		else {
			$comment = new Comment;
		}
	 
		$formBuilder = new CommentFormBuilder($comment);
		$formBuilder->build();
	 
		$form = $formBuilder->form();
	 
		$formHandler = new FormHandler($form, $this->managers->getManagerOf('Comments'), $request);
	 
		if ($formHandler->process()) {
			
			$this->app->user()->setFlash('Le commentaire a bien été ajouté, merci !');
	 
			$this->app->httpResponse()->redirect('news-'.$request->getData('news').'.html');
		}
	 
		$this->page->addVar('comment', $comment);
		$this->page->addVar('form', $form->createView());
		$this->page->addVar('title', 'Ajout d\'un commentaire');
	}
	
	public function executeUpdateComment(HTTPRequest $request) {
		
		$this->page->addVar('title', 'Modification d\'un commentaire');
		
		$comment = $this->managers->getManagerOf('Comments')->get($request->getData('id'));
		
		if ($comment->auteur() != $_SESSION['pseudo']) {
			$this->app->user()->setFlash('Seul l\'auteur d\'un commentaire peut le modifier');
			$this->app->httpResponse()->redirect('/');
		}
		
		if ($request->method() == 'POST') {
			$comment = new Comment([
				'id' => $request->getData('id'),
				'auteur' => $_SESSION['pseudo'],
				'contenu' => $request->postData('contenu')
			]);
		}
 
		$formBuilder = new CommentFormBuilder($comment);
		$formBuilder->build();
 
		$form = $formBuilder->form();
 
		$formHandler = new FormHandler($form, $this->managers->getManagerOf('Comments'), $request);
 
		if ($formHandler->process()) {
			$this->app->user()->setFlash('Le commentaire a bien été modifié');
			$this->app->httpResponse()->redirect('/');
		}
 
		$this->page->addVar('form', $form->createView());
	}
	
	public function executeDeleteComment(HTTPRequest $request) {
		
		$comment = $this->managers->getManagerOf('Comments')->get($request->getData('id'));
		
		if ($comment->auteur() != $_SESSION['pseudo']) {
			$this->app->user()->setFlash('Seul l\'auteur d\'un commentaire peut le supprimer');
			$this->app->httpResponse()->redirect('/');
		}
		
		$this->managers->getManagerOf('Comments')->delete($request->getData('id'));
		$this->app->user()->setFlash('Le commentaire a bien été supprimé !');
		$this->app->httpResponse()->redirect('.');
	}
}








