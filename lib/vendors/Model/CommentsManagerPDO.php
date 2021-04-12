<?php
namespace Model;

use \Entity\Comment;

class CommentsManagerPDO extends CommentsManager {
	
	protected function add(Comment $comment) {
		
		$q = $this->dao->prepare('INSERT INTO comments SET news = :news, auteurId = :auteurId, contenu = :contenu, date = NOW()');
    
		$q->bindValue(':news', $comment->news(), \PDO::PARAM_INT);
		$q->bindValue(':auteurId', $_SESSION['id'], \PDO::PARAM_INT);
		$q->bindValue(':contenu', $comment->contenu());
    
		$q->execute();
    
		$comment->setId($this->dao->lastInsertId());
	}
	
	public function getListOf($news) {
		
		if (!ctype_digit($news)) {
			throw new \RuntimeException('L\'identifiant de la news passé doit être un nombre entier valide');
		}
    
		$q = $this->dao->prepare('SELECT comments.id, comments.news, members.name auteur, comments.contenu, comments.date FROM comments INNER JOIN members ON members.id = comments.auteurId WHERE news = :news');
		$q->bindValue(':news', $news, \PDO::PARAM_INT);
		$q->execute();
    
		$q->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Comment');
    
		$comments = $q->fetchAll();
    
		foreach ($comments as $comment) {
			
			$comment->setDate(new \DateTime($comment->date()));
		}
    
		return $comments;
	}
	
	public function getCountOf($news) {
		
		if (!ctype_digit($news)) {
			throw new \RuntimeException('L\'identifiant de la news passé doit être un nombre entier valide');
		}
			
		$this->dao->prepare('SELECT COUNT(*) FROM comments WHERE news = :news');
		$q->bindValue(':news', $news, \PDO::PARAM_INT);
		$q->execute();
    
		$commentsNumber = $q->fetchAll();
    
		return $commentsNumber;
	}
	
	public function deleteFromNews($news) {
		 
		$this->dao->exec('DELETE FROM comments WHERE news = '.(int) $news);
	}
	
	protected function modify(Comment $comment) {
		
		$q = $this->dao->prepare('UPDATE comments SET auteurId = :auteurId, contenu = :contenu WHERE id = :id');
    
		$q->bindValue(':auteurId', $_SESSION['id']);
		$q->bindValue(':contenu', $comment->contenu());
		$q->bindValue(':id', $comment->id(), \PDO::PARAM_INT);
    
		$q->execute();
	}
  
	public function get($id) {
		
		$q = $this->dao->prepare('SELECT comments.id, comments.news, members.name auteur, comments.contenu, comments.date FROM comments INNER JOIN members ON members.id = comments.auteurId WHERE comments.id = :id');
		$q->bindValue(':id', (int) $id, \PDO::PARAM_INT);
		$q->execute();
    
		$q->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Comment');
    
		return $q->fetch();
	}
	
	public function delete($id) {
		
		$this->dao->exec('DELETE FROM comments WHERE id = '.(int) $id);
	}
}




