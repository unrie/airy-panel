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

class controlController extends Controller {
	public function index($serverid = null) {
		$this->load->checkLicense();
		
		$this->document->setActiveSection('admin');
		$this->document->setActiveItem('control');
		
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
		
		$this->load->library('query');
		$this->load->model('servers');
		
		$error = $this->validate($serverid);
		if($error) {
			$this->session->data['error'] = $error;
			$this->response->redirect($this->config->url . 'admin/servers/index');
		}
		
		$server = $this->serversModel->getServerById($serverid, array('users', 'games', 'locations'));
		$this->data['server'] = $server;
		
		if($server['server_status'] == 2) {
			$queryLib = new queryLibrary($server['game_query']);
			$queryLib->connect($server['location_ip'], $server['server_port']);
			$query = $queryLib->getInfo();
			$queryLib->disconnect();
			
			$this->data['query'] = $query;
		}
		
		$this->getChild(array('common/header', 'common/footer'));
		return $this->load->view('admin/servers/control', $this->data);
	}
	
	public function action($serverid = null, $action = null) {
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
		$this->load->model('serversStats');
		
		$error = $this->validate($serverid);
		if($error) {
			$this->data['status'] = "error";
			$this->data['error'] = $error;
			return json_encode($this->data);
		}
		
		$server = $this->serversModel->getServerById($serverid);
		
		switch($action) {
			case 'start': {
				if($server['server_status'] == 1) {
					$result = $this->serversModel->execServerAction($serverid, 'start');
					if($result['status'] == "OK") {
						$this->serversModel->updateServer($serverid, array('server_status' => 2));
						$this->data['status'] = "success";
						$this->data['success'] = "Вы успешно включили сервер!";
					} else {
						$this->data['status'] = "error";
						$this->data['error'] = $result['description'];
					}
				} else {
					$this->data['status'] = "error";
					$this->data['error'] = "Сервер должен быть выключен!";
				}
				break;
			}
			case 'reinstall': {
				if($server['server_status'] == 1) {
					$result = $this->serversModel->execServerAction($serverid, 'reinstall');
					if($result['status'] == "OK") {
						$this->serversModel->updateServer($serverid, array('server_status' => 1));
						$this->data['status'] = "success";
						$this->data['success'] = "Вы успешно переустановили сервер!";
					} else {
						$this->data['status'] = "error";
						$this->data['error'] = $result['description'];
					}
				} else {
					$this->data['status'] = "error";
					$this->data['error'] = "Сервер должен быть выключен!";
				}
				break;
			}
			case 'restart': {
				if($server['server_status'] == 2) {
					$result = $this->serversModel->execServerAction($serverid, 'restart');
					if($result['status'] == "OK") {
						$this->serversModel->updateServer($serverid, array('server_status' => 2));
						$this->data['status'] = "success";
						$this->data['success'] = "Вы успешно перезапустили сервер!";
					} else {
						$this->data['status'] = "error";
						$this->data['error'] = $result['description'];
					}
				} else {
					$this->data['status'] = "error";
					$this->data['error'] = "Сервер должен быть включен!";
				}
				break;
			}
			case 'stop': {
				if($server['server_status'] == 2) {
					$result = $this->serversModel->execServerAction($serverid, 'stop');
					if($result['status'] == "OK") {
						$this->serversModel->updateServer($serverid, array('server_status' => 1));
						$this->data['status'] = "success";
						$this->data['success'] = "Вы успешно выключили сервер!";
					} else {
						$this->data['status'] = "error";
						$this->data['error'] = $result['description'];
					}
				} else {
					$this->data['status'] = "error";
					$this->data['error'] = "Сервер должен быть включен!";
				}
				break;
			}
			case 'backup': {
				if($server['server_status'] == 1) {
					$result = $this->serversModel->execServerAction($serverid, 'backup');
					if($result['status'] == "OK") {
						$this->data['status'] = "success";
						$this->data['success'] = "Вы успешно сделали backup сервера!";
					} else {
						$this->data['status'] = "error";
						$this->data['error'] = $result['description'];
					}
				} else {
					$this->data['status'] = "error";
					$this->data['error'] = "Сервер должен быть выключен!";
				}
				break;
			}
			case 'block': {
				if($server['server_status'] == 1) {
					$this->serversModel->updateServer($serverid, array('server_status' => 0));
					$this->data['status'] = "success";
					$this->data['success'] = "Вы успешно заблокировали сервер!";
				} else {
					$this->data['status'] = "error";
					$this->data['error'] = "Сервер должен быть выключен!";
				}
				break;
			}
			case 'unblock': {
				if($server['server_status'] == 0) {
					$this->serversModel->updateServer($serverid, array('server_status' => 1));
					$this->data['status'] = "success";
					$this->data['success'] = "Вы успешно разблокировали сервер!";
				} else {
					$this->data['status'] = "error";
					$this->data['error'] = "Сервер должен быть заблокирован!";
				}
				break;
			}
			case 'delete': {
				if($server['server_status'] == 1) {
					if($this->user->getAccessLevel() >= 3){
						$result = $this->serversModel->execServerAction($serverid, 'delete');
						if($result['status'] == "OK") {
						  $this->serversStatsModel->deleteServerStats($serverid);
							$this->serversModel->deleteServer($serverid);
							$this->data['status'] = "success";
							$this->data['success'] = "Вы успешно удалили сервер!";
						} else {
							$this->data['status'] = "error";
							$this->data['error'] = $result['description'];
						}
					} else {
						$this->data['status'] = "error";
					  $this->data['error'] = "У вас нет доступа к данному разделу!";
					}
				} else {
					$this->data['status'] = "error";
					$this->data['error'] = "Сервер должен быть выключен!";
				}
				break;
			}
			default: {
				$this->data['status'] = "error";
				$this->data['error'] = "Вы выбрали несуществующее действие!";
				break;
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
