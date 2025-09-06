<?php
/*
* @LitePanel
* @Version: 1.0.1
* @Date: 12.02.2014
* @Developed by RossyBAN
*/
class createController extends Controller {

	public function index() {
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
		
		$this->getChild(array('common/header', 'common/footer'));
		return $this->load->view('admin/news/create', $this->data);
	}
	
	public function ajax() {
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
		
		$this->load->library('mail');
		
		$this->load->model('news');
		$this->load->model('users');
		
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
			$errorPOST = $this->validatePOST();
			if(!$errorPOST) {
				$name = @$this->request->post['name'];
				$text = @$this->request->post['text'];
				$comments = @$this->request->post['comments'];
				$type = @$this->request->post['type'];
				$mailing = @$this->request->post['mailing'];
				
				$userid = $this->user->getId();
				
				$newsData = array(
					'user_id'			  => $userid,
					'news_title'		=> $name,
					'news_text'			=> $text,
					'news_comments'			=> $comments,
					'news_type'			=> $type
				);
				$this->newsModel->createNews($newsData);
				
				if($mailing) {
				  $users = $this->usersModel->getUsers(array('user_mailing' => 1));
				  
				  $mailLib = new mailLibrary();
					
					$mailLib->setFrom($this->config->mail_from);
				  $mailLib->setSender($this->config->mail_sender);
				  
				  foreach($users as $item) {
					  $mailLib->setTo($item['user_email']);
					  $mailLib->setSubject($name);
					
					  $mailData = array();
					  
					  $mailData['firstname'] = $item['user_firstname'];
					  $mailData['lastname'] = $item['user_lastname'];
					  $mailData['text'] = $text;
					  $mailData['title'] = $this->config->title;
					
					  $mailtext = $this->load->view('mail/news/addNews', $mailData);
					
					  $mailLib->setText($mailtext);
					  $mailLib->send();
					}
				}
				
				$this->data['status'] = "success";
				$this->data['success'] = "Вы успешно создали новость!";
			} else {
				$this->data['status'] = "error";
				$this->data['error'] = $errorPOST;
			}
		}

		return json_encode($this->data);
	}
	
	private function validatePOST() {
		$this->load->checkLicense();
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
