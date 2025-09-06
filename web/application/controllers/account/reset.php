<?php
/*

* @Developed by Dominator!?
*/
class resetController extends Controller {
	public function index() {
	  $this->load->checkLicense();
		$this->document->setActiveSection('account');
		$this->document->setActiveItem('reset');
		
		if($this->user->isLogged()) {
			$this->session->data['error'] = "Вы уже авторизированы!";
			$this->response->redirect($this->config->url);
		}
    
		$this->getChild(array('common/loginheader', 'common/loginfooter'));
		return $this->load->view('account/reset', $this->data);
	}
	
	public function ajax() {
	  $this->load->checkLicense();
		if($this->user->isLogged()) {  
	  		$this->data['status'] = "error";
			$this->data['error'] = "Вы уже авторизированы!";
			return json_encode($this->data);
		}
		
		$this->load->model('users');
		
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
			$errorPOST = $this->validatePOST();
			if(!$errorPOST) {
				$password = @$this->request->post['password'];
				$restorekey = @$this->request->post['restorekey'];
				
				$user = $this->usersModel->getUserByRestoreKey($restorekey);
				
				$this->usersModel->updateUser($user['user_id'], array('user_password' => md5($password), 'user_restore_key' => null));
				
				$this->data['status'] = "success";
				$this->data['success'] = "Вы успешно изменили пароль от аккаунта!";
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
		
		$validateLib = new validateLibrary();
		
		$result = null;
		
		$password = @$this->request->post['password'];
		$password2 = @$this->request->post['password2'];
		$restorekey = @$this->request->post['restorekey'];
		
		if(!$validateLib->password($password)) {
			$result = "Пароль должен содержать от 6 до 32 латинских букв, цифр и знаков <i>,.!?_-</i>!";
		}
		elseif($password != $password2) {
			$result = "Введенные вами пароли не совпадают!";
		}
		elseif(!$validateLib->md5($restorekey)) {
			$result = "Укажите реальный ключ восстановления!";
		}
		elseif($this->usersModel->getTotalUsers(array('user_restore_key' => $restorekey)) < 1) {
			$result = "Указанный ключ восстановления неверный!";
		}
		return $result;
	}
}
?>
