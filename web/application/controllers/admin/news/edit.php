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
	public function index($newsid = null) {
		$this->load->checkLicense();
		$this->document->setActiveSection('admin');
		$this->document->setActiveItem('news');
		
		if(!$this->user->isLogged()) {
			$this->session->data['error'] = "Вы не авторизированы!";
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 3) {
			$this->session->data['error'] = "У вас нет доступа к данному разделу!";
			$this->response->redirect($this->config->url);
		}
		
		$this->load->model('news');
		
		$error = $this->validate($newsid);
		if($error) {
			$this->session->data['error'] = $error;
			$this->response->redirect($this->config->url . 'admin/news/index');
		}
		
		$news = $this->newsModel->getNewsById($newsid);
		
		$this->data['news'] = $news;
		
		$this->getChild(array('common/header', 'common/footer'));
		return $this->load->view('admin/news/edit', $this->data);
	}
	
	public function ajax($newsid = null) {
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
		
		$this->load->model('news');
		
		$error = $this->validate($newsid);
		if($error) {
			$this->data['status'] = "error";
			$this->data['error'] = $error;
			return json_encode($this->data);
		}
		
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
			$errorPOST = $this->validatePOST();
			if(!$errorPOST) {
				$name = @$this->request->post['name'];
				$text = @$this->request->post['text'];
				$comments = @$this->request->post['comments'];
				$type = @$this->request->post['type'];
				
				$newsData = array(
					'news_title'		=> $name,
					'news_text'			=> $text,
					'news_comments'			=> $comments,
					'news_type'			=> $type
				);
				
				$this->newsModel->updateNews($newsid, $newsData);
				
				$this->data['status'] = "success";
				$this->data['success'] = "Вы успешно отредактировали новость!";
			} else {
				$this->data['status'] = "error";
				$this->data['error'] = $errorPOST;
			}
		}

		return json_encode($this->data);
	}
	
	public function delete($newsid = null) {
		$this->load->checkLicense();
		$this->document->setActiveSection('admin');
		$this->document->setActiveItem('news');
		
		if(!$this->user->isLogged()) {
			$this->session->data['error'] = "Вы не авторизированы!";
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 3) {
			$this->session->data['error'] = "У вас нет доступа к данному разделу!";
			$this->response->redirect($this->config->url);
		}
		
		$this->load->model('news');
		
		$error = $this->validate($newsid);
		if($error) {
			$this->session->data['error'] = $error;
			$this->response->redirect($this->config->url . 'admin/news/index');
		}
		
		$this->newsModel->deleteNews($newsid);
		
		$this->session->data['success'] = "Вы успешно удалили новость!";
		$this->response->redirect($this->config->url . 'admin/news/index');
		return null;
	}
	
	private function validate($newsid) {
		$this->load->checkLicense();
		$result = null;
		
		if(!$this->newsModel->getTotalNews(array('news_id' => (int)$newsid))) {
			$result = "Запрашиваемая новость не существует!";
		}
		return $result;
	}
	
	private function validatePOST() {
		$this->load->checkLicense();
		$this->load->library('validate');
		
		$validateLib = new validateLibrary();
		
		$result = null;
		
		$name = @$this->request->post['name'];
		$text = @$this->request->post['text'];
		$comments = @$this->request->post['comments'];
		$type = @$this->request->post['type'];
		
		if(mb_strlen(trim($name)) < 6 || mb_strlen(trim($name)) > 32) {
			$result = "Заголовок новости должно содержать от 6 до 32 символов!";
		}
		elseif(mb_strlen(trim($text)) < 10 || mb_strlen(trim($text)) > 350) {
			$result = "Текст новости должен содержать от 10 до 350 символов!";
		}
		elseif($comments < 0 || $comments > 1) {
			$result = "Укажите допустимый статус комментариев!";
		}
		elseif($type != 'primary' xor $type != 'success' xor $type != 'danger' xor $type != 'warning' xor $type != 'info') {
			$result = "Укажите допустимый тип новости!";
		}
		return $result;
	}
}
?>
