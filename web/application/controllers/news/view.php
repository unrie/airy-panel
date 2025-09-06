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
class viewController extends Controller {
	public function index($newsid = null) {
		$this->load->checkLicense();
		$this->document->setActiveSection('news');
		$this->document->setActiveItem('index');
		
		if(!$this->user->isLogged()) {
			$this->session->data['error'] = "Вы не авторизированы!";
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 0) {
			$this->session->data['error'] = "У вас нет доступа к данному разделу!";
			$this->response->redirect($this->config->url);
		}
		
		$this->load->model('news');
		$this->load->model('newsComments');
		
		$error = $this->validate($newsid);
		if($error) {
			$this->session->data['error'] = $error;
			$this->response->redirect($this->config->url . 'news/index');
		}
		
		$news = $this->newsModel->getNewsById($newsid, array('users'));
		$comments = $this->newsCommentsModel->getNewsComments(array('news_id' => (int)$newsid), array('users'));
		$total = $this->newsCommentsModel->getTotalNewsComments(array('news_id' => (int)$newsid));
		$this->data['news'] = $news;
		$this->data['comments'] = $comments;
		$this->data['total'] = $total;
		
		$this->getChild(array('common/header', 'common/footer'));
		return $this->load->view('news/view', $this->data);
	}
	
	public function ajax($newsid = null) {
		$this->load->checkLicense();
		if(!$this->user->isLogged()) {  
	  		$this->data['status'] = "error";
			$this->data['error'] = "Вы не авторизированы!";
			return json_encode($this->data);
		}
		if($this->user->getAccessLevel() < 1) {
	  		$this->data['status'] = "error";
			$this->data['error'] = "У вас нет доступа к данному разделу!";
			return json_encode($this->data);
		}
		
		$this->load->model('news');
		$this->load->model('newsComments');
		
		$error = $this->validate($newsid);
		if($error) {
	  		$this->data['status'] = "error";
			$this->data['error'] = $error;
			return json_encode($this->data);
		}
		
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
			$errorPOST = $this->validatePOST($newsid);
			if(!$errorPOST) {
				$text = @$this->request->post['text'];
				
				$userid = $this->user->getId();
				
			  $commentData = array(
				  'news_id'			=> $newsid,
					'user_id'			=> $userid,
					'news_comment_text'	=> $text
				);
				$this->newsCommentsModel->createNewsComment($commentData);
					
				$this->data['status'] = "success";
				$this->data['success'] = "Вы успешно отправили комментарий!";
			} else {
				$this->data['status'] = "error";
				$this->data['error'] = $errorPOST;
			}
		}

		return json_encode($this->data);
	}
	
	private function validate($newsid) {
		$this->load->checkLicense();
		$result = null;
		
		if(!$this->newsModel->getTotalNews(array('news_id' => (int)$newsid))) {
			$result = "Запрашиваемая новость не существует!";
		}
		return $result;
	}
	
	private function validatePOST($newsid) {
		$this->load->checkLicense();
		$result = null;
		
		$text = @$this->request->post['text'];
		
		if (mb_strlen(trim($text)) < 10 || mb_strlen(trim($text)) > 350) {
			$result = "Текст комментария должен содержать от 10 до 350 символов!";
		}
		return $result;
	}
}
