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
class loginController extends Controller {
	public function index() {
		$this->load->checkLicense();
		$this->document->setActiveSection('account');
		$this->document->setActiveItem('login');
		
		if($this->user->isLogged()) {
			$this->session->data['error'] = "Вы уже авторизированы!";
			$this->response->redirect($this->config->url);
		}

		$this->getChild(array('common/loginheader', 'common/loginfooter'));
		return $this->load->view('account/login', $this->data);
	}
	
	public function ajax() {
		$this->load->checkLicense();
		if($this->user->isLogged()) {  
	  	$this->data['status'] = "error";
			$this->data['error'] = "Вы уже авторизированы!";
			return json_encode($this->data);
		}
		
		$this->load->model('users');
		$this->load->model('authlogs');
		
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
			$errorPOST = $this->validatePOST();
			if(!$errorPOST) {
				$email = @$this->request->post['email'];
				$password = @$this->request->post['password'];
				
				if($this->user->login($email, $password)) {
					$userid = $this->user->getId();
					$ip = $this->request->server['REMOTE_ADDR'];
					
					$authlogData = array(
					'user_id'			=> $userid,
					'authlog_ip'	=> $ip,
					'authlog_status'	=> 1
				  );
					
					$this->authlogsModel->createAuthLog($authlogData);
					
					$this->data['status'] = "success";
					$this->data['success'] = "Вы успешно авторизованы!";
				} else {
					$user = $this->usersModel->getUserByEmail($email);
					$ip = $this->request->server['REMOTE_ADDR'];
					
					$authlogData = array(
					'user_id'			=> $user['user_id'],
					'authlog_ip'	=> $ip,
					'authlog_status'	=> 0
				  );
					
					$this->authlogsModel->createAuthLog($authlogData);
					
					$this->data['status'] = "error";
					$this->data['error'] = "Вы ввели не верный E-Mail или пароль!";
				}
			} else {
				$this->data['status'] = "error";
				$this->data['error'] = $errorPOST;
			}
		}

		return json_encode($this->data);
	}
	
	private function validatePOST() {
		$this->load->library('validate');
		
		$validateLib = new validateLibrary();
		
		$result = null;
		
		$email = @$this->request->post['email'];
		$password = @$this->request->post['password'];
		
		if(!$validateLib->email($email)) {
			$result = "Укажите свой реальный E-Mail!";
		}
		elseif(!$validateLib->password($password)) {
			$result = "Пароль должен содержать от 6 до 32 латинских букв, цифр и знаков <i>,.!?_-</i>!";
		}
		return $result;
	}
}
?>
