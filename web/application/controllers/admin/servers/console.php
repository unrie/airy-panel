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
class consoleController extends Controller {
	public function index($serverid = null) {
		$this->load->checkLicense();
		$this->document->setActiveSection('admin');
		$this->document->setActiveItem('console');
		
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
		
		$server = $this->serversModel->getServerById($serverid, array('games', 'locations'));
		$screenlog = file('ftp://gs'.$server['server_id'].':'.$server['server_password'].'@'.$server['location_ip'].':21/screenlog.0');
		
		$this->data['server'] = $server;
		$this->data['screenlog'] = $screenlog;
		
		$this->getChild(array('common/header', 'common/footer'));
		return $this->load->view('admin/servers/console', $this->data);
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
		$this->load->library('SampRconAPI');
		$this->load->library('Rcon');
		
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
		  $errorPOST = $this->validatePOST();
		  if(!$errorPOST) {
			  $command = $this->request->post['command'];
			
			  $server = $this->serversModel->getServerById($serverid, array('games', 'locations'));
			  
			  if ($server['game_query'] == 'samp') {
			    if($server['server_status'] == 2) {
			      $servercfg = file_get_contents('ftp://gs'.$server['server_id'].':'.$server['server_password'].'@'.$server['location_ip'].':21/server.cfg');
			      $cfglines = explode("\n", $servercfg);
            $cfgline = explode("rcon_password", $servercfg);
            $count = substr_count($cfgline[0], "\n");
            $rconpassword = substr($cfglines[$count], 14);
			
			      $SampRconAPI = new SampRconAPI($server['location_ip'], $server['server_port'], $rconpassword);
			      
			      if($SampRconAPI->isOnline()) {
			        $SampRconAPI->call($command);
			        $this->data['status'] = "success";
				      $this->data['success'] = "Вы успешно отправили команду на сервер!";
			      } else {
			        $this->data['status'] = "error";
				      $this->data['error'] = "Сервер офлайн!";
			      }
			    } else {
			      $this->data['status'] = "error";
				    $this->data['error'] = "Сервер должен быть включен!";
		      }
		    }
		    elseif ($server['game_query'] == 'mine') {
		      if($server['server_status'] == 2) {
		        $servercfg = file_get_contents('ftp://gs'.$server['server_id'].':'.$server['server_password'].'@'.$server['location_ip'].':21/server.properties');
			      $cfglines = explode("\n", $servercfg);
            $cfgline = explode("rcon.password", $servercfg);
            $count = substr_count($cfgline[0], "\n");
            $rconpassword = substr($cfglines[$count], 14);
			    
		        $rcon = new Rcon($server['location_ip'], $server['server_port']+1, $rconpassword, 3);
		        
		        if ($rcon->connect()) {
              $rcon->sendCommand($command);
              $this->data['status'] = "success";
				      $this->data['success'] = "Вы успешно отправили команду на сервер!";
            } else {
              $this->data['status'] = "error";
				      $this->data['error'] = "Не удалось подключиться к серверу!";
            }
          } else {
			      $this->data['status'] = "error";
				    $this->data['error'] = "Сервер должен быть включен!";
		      }
		    }
		    else {
		      $this->data['status'] = "error";
				  $this->data['error'] = "Для данной игры консоль не поддерживается!";
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
		
		$userid = $this->user->getId();
		
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
		
		$command = @$this->request->post['command'];
		
		if(mb_strlen(trim($command)) < 2 || mb_strlen(trim($command)) > 64) {
			$result = "Команда сервера должна содержать от 2 до 64 символов!";
		}
		return $result;
	}
}
?>
