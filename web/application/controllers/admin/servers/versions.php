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
class versionsController extends Controller {
	public function index($serverid = null) {
		$this->load->checkLicense();
		$this->document->setActiveSection('admin');
		$this->document->setActiveItem('versions');
		
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
		$this->load->model('games');
		
		$error = $this->validate($serverid);
		if($error) {
			$this->session->data['error'] = $error;
			$this->response->redirect($this->config->url . 'admin/servers/index');
		}
		
		$server = $this->serversModel->getServerById($serverid, array('games'));
		$versions = $this->gamesModel->getGames(array('game_query' => $server['game_query'], 'game_status' => 1));
		
		$this->data['server'] = $server;
		$this->data['versions'] = $versions;
		
		$this->getChild(array('common/header', 'common/footer'));
		return $this->load->view('admin/servers/versions', $this->data);
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
		$this->load->model('games');
		
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
			$versionid = $this->request->post['versionid'];
			
			$server = $this->serversModel->getServerById($serverid, array('games'));
			
			if($server['server_status'] == 1) {
			  if($server['game_id'] != $versionid) {
			    if($this->gamesModel->getTotalGames(array('game_id' => (int)$versionid, 'game_query' => $server['game_query'], 'game_status' => 1))) {
				    $this->serversModel->updateServer($serverid, array('game_id' => (int)$versionid));
				    $result = $this->serversModel->execServerAction($serverid, 'reinstall');
				    if($result['status'] == "OK") {
				      $this->data['status'] = "success";
				      $this->data['success'] = "Вы успешно изменили версию сервера!";
			      } else {
						  $this->data['status'] = "error";
						  $this->data['error'] = $result['description'];
					  }
				    $this->data['status'] = "success";
				    $this->data['success'] = "Вы успешно изменили версию сервера!";
			    } else {
				    $this->data['status'] = "error";
				    $this->data['error'] = "Вы выбрали несуществующую версию!";
			    }
			  } else {
				  $this->data['status'] = "error";
				  $this->data['error'] = "Вы не изменили версию сервера!";
			  }
			} else {
			  $this->data['status'] = "error";
				$this->data['error'] = "Сервер должен быть выключен!";
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
}
?>
