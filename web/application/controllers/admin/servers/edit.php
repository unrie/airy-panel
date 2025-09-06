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
	public function index($serverid = null) {
		$this->load->checkLicense();
		
		$this->document->setActiveSection('admin');
		$this->document->setActiveItem('edit');
		
		$this->data['activesection'] = $this->document->getActiveSection();
		$this->data['activeitem'] = $this->document->getActiveItem();
		
		if(!$this->user->isLogged()) {
			$this->session->data['error'] = "Вы не авторизированы!";
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 2) {
			$this->session->data['error'] = "У вас нет доступа к данному разделу!";
			$this->response->redirect($this->config->url);
		}
		
		$this->load->model('servers');
		
		$error = $this->validate($serverid);
		if($error) {
			$this->session->data['error'] = $error;
			$this->response->redirect($this->config->url . 'admin/servers/index');
		}
		
		$server = $this->serversModel->getServerById($serverid);
		$this->data['server'] = $server;
		
		$this->getChild(array('common/header', 'common/footer'));
		return $this->load->view('admin/servers/edit', $this->data);
	}
	
	public function ajax($serverid = null) {
		$this->load->checkLicense();
		if(!$this->user->isLogged()) {  
	  		$this->data['status'] = "error";
			$this->data['error'] = "Вы не авторизированы!";
			return json_encode($this->data);
		}
		if($this->user->getAccessLevel() < 2) {
			$this->data['status'] = "error";
			$this->data['error'] = "У вас нет доступа к данному разделу!";
			return json_encode($this->data);
		}
		
		$this->load->model('servers');
		
		$error = $this->validate($serverid);
		if($error) {
			$this->data['status'] = "error";
			$this->data['error'] = $error;
			return json_encode($this->data);
		}
		
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
			$errorPOST = $this->validatePOST();
			if(!$errorPOST) {
				$editpassword = @$this->request->post['editpassword'];
				$password = @$this->request->post['password'];
				$monitoring = @$this->request->post['monitoring'];
				$autoup = @$this->request->post['autoup'];
				
				$server = $this->serversModel->getServerById($serverid);
				
				$serverData = array(
					'server_monitoring'		=> (int)$monitoring,
					'server_auto_up'		=> (int)$autoup
				);
				
				if($editpassword) {
				  if($server['server_status'] == 1) {
				    $serverData['server_password'] = $password;
				
				    $this->serversModel->updateServer($serverid, $serverData);
				    $result = $this->serversModel->execServerAction($serverid, 'updatepassword');
				    if($result['status'] == "OK") {
					    $this->data['status'] = "success";
					    $this->data['success'] = "Вы успешно отредактировали сервер!";
				    } else {
					    $this->data['status'] = "error";
					    $this->data['error'] = $result['description'];
				    }
				  } else {
			      $this->data['status'] = "error";
				    $this->data['error'] = "Сервер должен быть выключен!";
		      }
				} else {
				  $this->serversModel->updateServer($serverid, $serverData);
				  $this->data['status'] = "success";
					$this->data['success'] = "Вы успешно отредактировали сервер!";
				}
			} else {
				$this->data['status'] = "error";
				$this->data['error'] = $errorPOST;
			}
		}

		return json_encode($this->data);
	}
	
	private function validate($serverid) {
		$this->load->checkLicense();
		$result = null;
		
		if(!$this->serversModel->getTotalServers(array('server_id' => (int)$serverid))) {
			$result = "Запрашиваемый сервер не существует!";
		}
		return $result;
	}
	
	private function validatePOST() {
		$this->load->checkLicense();
		$this->load->library('validate');
		
		$validateLib = new validateLibrary();
		
		$result = null;
		
		$editpassword = @$this->request->post['editpassword'];
		$password = @$this->request->post['password'];
		$password2 = @$this->request->post['password2'];
		$monitoring = @$this->request->post['monitoring'];
		$autoup = @$this->request->post['autoup'];
		
		if($editpassword) {
			if(!$validateLib->password($password)) {
				$result = "Пароль должен содержать от 6 до 32 латинских букв, цифр и знаков <i>,.!?_-</i>!";
			}
			elseif($password != $password2) {
				$result = "Введенные вами пароли не совпадают!";
			}
		}
		elseif($monitoring < 0 || $monitoring > 1) {
			$result = "Укажите допустимый статус мониторинга!";
		}
		elseif($autoup < 0 || $autoup > 1) {
			$result = "Укажите допустимый статус автоподнятия!";
		}
		return $result;
	}
}
?>
