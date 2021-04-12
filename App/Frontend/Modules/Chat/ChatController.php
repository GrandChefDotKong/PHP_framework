<?php
namespace App\Frontend\Modules\Chat;

use \AdoFram\BackController;
use \AdoFram\HTTPRequest;
use \Entity\Message;
use \AdoFram\FormHandler;


class ChatController extends BackController {
    
    public function executeShow(HTTPRequest $request) {

        if($request->getData('id') != null) {
            $id = $request->getData('id');
        }
     
        // On récupère le manager des news.
        $manager = $this->managers->getManagerOf('Messages');
     
        $listeMessage = $manager->getListOf($id);
     
        // On ajoute la variable $listeMessage à la vue.
        $this->page->addVar('listeMessage', $listeMessage);
    }
    
    public function executePostMessage(HTTPRequest $request) {
        // Si le formulaire a été envoyé.
        if ($request->method() == 'POST') {

            $comment = new Message([
                'auteur' => htmlspecialchars($request->postData('auteur')),
                'contenu' => htmlspecialchars($request->postData('contenu'))
            ]);
     
            $manager = $this->managers->getManagerOf('Messages');
     
            $manager->save($comment);
            
            // $this->app->user()->setFlash('Le commentaire a bien été ajouté, merci !');
        }
    }
}



