<?php
/*
Copyright (c) 2014 LiteDevel

Данная лицензия разрешает лицам, получившим копию данного программного обеспечения
и сопутствующей документации (в дальнейшем именуемыми «Программное Обеспечение»),
безвозмездно использовать Программное Обеспечение в  личных целях, включая неограниченное
право на использование, копирование, изменение, добавление, публикацию, распространение,
также как и лицам, которым запрещенно использовать Програмное Обеспечение в коммерческих целях,
предоставляется данное Программное Обеспечение,при соблюдении следующих условий:

Developed by LiteDevel
*/
class editController extends Controller {
	public function index($commentid = null) {
		$this->load->checkLicense();
		$this->document->setActiveSection('admin');
		$this->document->setActiveItem('newscomments');
		
		if(!$this->user->isLogged()) {
			$this->session->data['error'] = "Вы не авторизированы!";
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 3) {
			$this->session->data['error'] = "У вас нет доступа к данному разделу!";
			$this->response->redirect($this->config->url);
		}
		
		$this->load->model('newsComments');
		
		$error = $this->validate($commentid);
		if($error) {
			$this->session->data['error'] = $error;
			$this->response->redirect($this->config->url . 'admin/news/comments/index');
		}
		
		$comment = $this->newsCommentsModel->getNewsCommentById($commentid);
		
		$this->data['comment'] = $comment;
		
		$this->getChild(array('common/header', 'common/footer'));
		return $this->load->view('admin/news/comments/edit', $this->data);
	}
	
	public function ajax($commentid = null) {
		$this->load->checkLicense();
		if(!$this->user->isLogged()) {  
	  		$this->data['status'] = "error";
			$this->data['error'] = "Вы не авторизированы!";
			return json_encode($this->data);
		}
		if($this->user->getAccessLevel() < 3) {
			$this->data['status'] = "error";
			$this->data['error'] = "У вас нет доступа к данному разделу!";
			return json_encode($this->data);
		}
		
		$this->load->model('newsComments');
		
		$error = $this->validate($commentid);
		if($error) {
			$this->data['status'] = "error";
			$this->data['error'] = $error;
			return json_encode($this->data);
		}
		
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
			$errorPOST = $this->validatePOST();
			if(!$errorPOST) {
				$text = @$this->request->post['text'];
				
				$commentData = array(
					'news_comment_text'		=> $text
				);
				
				$this->newsCommentsModel->updateNewsComment($commentid, $commentData);
				
				$this->data['status'] = "success";
				$this->data['success'] = "Вы успешно отредактировали комментарий новости!";
			} else {
				$this->data['status'] = "error";
				$this->data['error'] = $errorPOST;
			}
		}

		return json_encode($this->data);
	}
	
	public function delete($commentid = null) {
		$this->load->checkLicense();
		$this->document->setActiveSection('admin');
		$this->document->setActiveItem('newscomments');
		
		if(!$this->user->isLogged()) {
			$this->session->data['error'] = "Вы не авторизированы!";
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 3) {
			$this->session->data['error'] = "У вас нет доступа к данному разделу!";
			$this->response->redirect($this->config->url);
		}
		
		$this->load->model('newsComments');
		
		$error = $this->validate($commentid);
		if($error) {
			$this->session->data['error'] = $error;
			$this->response->redirect($this->config->url . 'admin/news/comments/index');
		}
		
		$this->newsCommentsModel->deleteNewsComment($commentid);
		
		$this->session->data['success'] = "Вы успешно удалили комментарий новости!";
		$this->response->redirect($this->config->url . 'admin/news/comments/index');
		return null;
	}
	
	private function validate($commentid) {
		$this->load->checkLicense();
		$result = null;
		
		if(!$this->newsCommentsModel->getTotalNewsComments(array('news_comment_id' => (int)$commentid))) {
			$result = "Запрашиваемый комментарий новости не существует!";
		}
		return $result;
	}
	
	private function validatePOST() {
		$this->load->checkLicense();
		$this->load->library('validate');
		
		$validateLib = new validateLibrary();
		
		$result = null;
		
		$text = @$this->request->post['text'];
		
		if (mb_strlen(trim($text)) < 10 || mb_strlen(trim($text)) > 350) {
			$result = "Текст комментария должен содержать от 10 до 350 символов!";
		}
		return $result;
	}
}
?>
