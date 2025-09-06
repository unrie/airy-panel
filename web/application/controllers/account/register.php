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
class registerController extends Controller {
	public function index() {
		$this->load->checkLicense();
		$this->document->setActiveSection('account');
		$this->document->setActiveItem('register');
		
		if($this->user->isLogged()) {
			$this->session->data['error'] = "Вы уже авторизированы!";
			$this->response->redirect($this->config->url);
		}
    
    $this->data['recaptcha_client'] = $this->config->recaptcha_client;
    
		$this->getChild(array('common/loginheader', 'common/loginfooter'));
		return $this->load->view('account/register', $this->data);
	}
	
	public function ajax() {
		$this->load->checkLicense();
		if($this->user->isLogged()) {  
	  		$this->data['status'] = "error";
			$this->data['error'] = "Вы уже авторизированы!";
			return json_encode($this->data);
		}
		
		$this->load->library('mail');
		$this->load->model('users');
		
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
			$errorPOST = $this->validatePOST();
			if(!$errorPOST) {
			  $firstname = @$this->request->post['firstname'];
				$lastname = @$this->request->post['lastname'];
				$email = @$this->request->post['email'];
				$mailing = @$this->request->post['mailing'];
				$password = @$this->request->post['password'];
				
				$userData = array(
					'user_email'		=> $email,
					'user_password'		=> md5($password),
					'user_firstname'	=> $firstname,
					'user_lastname'		=> $lastname,
					'user_status'		=> 1,
					'user_balance'		=> 0,
					'user_mailing'		=> $mailing,
					'user_theme'		=> 0,
					'user_access_level'	=> 1
				);
				
				$this->usersModel->createUser($userData);
				
				$mailLib = new mailLibrary();
				
				$mailLib->setFrom($this->config->mail_from);
				$mailLib->setSender($this->config->mail_sender);
				$mailLib->setTo($email);
				$mailLib->setSubject('Регистрация аккаунта');
				
				$mailData = array();
				
				$mailData['firstname'] = $firstname;
				$mailData['lastname'] = $lastname;
				$mailData['email'] = $email;
				$mailData['password'] = $password;
				$mailData['title'] = $this->config->title;
				
				$text = $this->load->view('mail/account/register', $mailData);
				
				$mailLib->setText($text);
				$mailLib->send();
				
				$this->data['status'] = "success";
				$this->data['success'] = "Вы успешно зарегистрировались!";
			} else {
				$this->data['status'] = "error";
				$this->data['error'] = $errorPOST;
			}
		}

		return json_encode($this->data);
	}
	
	private function validatePOST() {
	
		$this->load->library('validate');
		$this->load->library('recaptcha');
		
		$validateLib = new validateLibrary();
		
		$secret = $this->config->recaptcha_server;
    $reCaptcha = new ReCaptcha($secret);
		
		$response = null;
		$result = null;
		
		$firstname = @$this->request->post['firstname'];
		$lastname = @$this->request->post['lastname'];
		$email = @$this->request->post['email'];
		$mailing = @$this->request->post['mailing'];
		$password = @$this->request->post['password'];
		$password2 = @$this->request->post['password2'];
		
		$remote_addr = $this->request->server['REMOTE_ADDR'];
		$g_recaptcha_response = @$this->request->post['g-recaptcha-response'];
		$response = $reCaptcha->verifyResponse($remote_addr, $g_recaptcha_response);
		
		if(!$validateLib->firstname($firstname)) {
			$result = "Укажите свое реальное имя!";
		}
		elseif(!$validateLib->lastname($lastname)) {
			$result = "Укажите свою реальную фамилию!";
		}
		elseif(!$validateLib->email($email)) {
			$result = "Укажите свой реальный E-Mail!";
		}
		elseif(!$validateLib->mailing($mailing)) {
			$result = "Укажите допустимый статус рассылки!";
		}
		elseif(!$validateLib->password($password)) {
			$result = "Пароль должен содержать от 6 до 32 латинских букв, цифр и знаков <i>,.!?_-</i>!";
		}
		elseif($password != $password2) {
			$result = "Введенные вами пароли не совпадают!";
		}
		elseif(!($response != null && $response->success)) {
			$result = "Подтвердите, что Вы не робот!";
		}
		elseif($this->usersModel->getTotalUsers(array('user_email' => $email))) {
			$result = "Указанный E-Mail уже зарегистрирован!";
		}
		return $result;
	}
}
?>
