<?php
/*

* @Developed by Dominator!?
*/
class restoreController extends Controller {
	public function index() {
	  $this->load->checkLicense();
		$this->document->setActiveSection('account');
		$this->document->setActiveItem('restore');
		
		if($this->user->isLogged()) {
			$this->session->data['error'] = "Вы уже авторизированы!";
			$this->response->redirect($this->config->url);
		}
    
    $this->data['recaptcha_client'] = $this->config->recaptcha_client;
    
		$this->getChild(array('common/loginheader', 'common/loginfooter'));
		return $this->load->view('account/restore', $this->data);
	}

	public function randomRestoreKey() {
    $symbols = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
    $result = array();
    $symbolsLength = strlen($symbols) - 1;
    for ($i = 0; $i < 8; $i++) {
      $n = rand(0, $symbolsLength);
      $result[] = $symbols[$n];
    }
    return implode($result);
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
				$email = @$this->request->post['email'];
				
				$user = $this->usersModel->getUserByEmail($email);
				$restorekey = $this->randomRestoreKey();
				
				$this->usersModel->updateUser($user['user_id'], array('user_restore_key' => md5($restorekey)));
				
				$mailLib = new mailLibrary();
				
				$mailLib->setFrom($this->config->mail_from);
				$mailLib->setSender($this->config->mail_sender);
				$mailLib->setTo($email);
				$mailLib->setSubject('Восстановление пароля');
				
				$mailData = array();
				
				$mailData['firstname'] = $user['user_firstname'];
				$mailData['lastname'] = $user['user_lastname'];
				$mailData['restorekey'] = md5($restorekey);
				$mailData['title'] = $this->config->title;
				
				$text = $this->load->view('mail/account/restore', $mailData);
				
				$mailLib->setText($text);
				$mailLib->send();
				
				$this->data['status'] = "success";
				$this->data['success'] = "На ваш E-Mail был отправлен ключ восстановления!";
			} else {
				$this->data['status'] = "error";
				$this->data['error'] = $errorPOST;
			}
		}

		return json_encode($this->data);
	}
	
	private function validatePOST() {
	  $this->load->checkLicense();
		$this->load->library('validate');
		$this->load->library('recaptcha');
		
		$validateLib = new validateLibrary();
		
    $secret = $this->config->recaptcha_server;
    $reCaptcha = new ReCaptcha($secret);
		
		$response = null;
		$result = null;
		
		$email = @$this->request->post['email'];
		
		$remote_addr = $this->request->server['REMOTE_ADDR'];
		$g_recaptcha_response = @$this->request->post['g-recaptcha-response'];
		$response = $reCaptcha->verifyResponse($remote_addr, $g_recaptcha_response);
		
		if(!$validateLib->email($email)) {
			$result = "Укажите свой реальный E-Mail!";
		}
		elseif(!($response != null && $response->success)) {
			$result = "Подтвердите, что Вы не робот!";
		}
		elseif($this->usersModel->getTotalUsers(array('user_email' => $email)) < 1) {
			$result = "Пользователь с указанным E-Mail не зарегистрирован!";
		}
		return $result;
	}
}
?>
