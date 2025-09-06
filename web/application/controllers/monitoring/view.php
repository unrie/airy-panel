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
class viewController extends Controller {
	public function index($serverid = null) {
		$this->load->checkLicense();
		$this->document->setActiveSection('monitoring');
		$this->document->setActiveItem('view');
		
		if(!$this->user->isLogged()) {
			$this->session->data['error'] = "Вы не авторизированы!";
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 0) {
			$this->session->data['error'] = "У вас нет доступа к данному разделу!";
			$this->response->redirect($this->config->url);
		}
		
		$this->load->library('query');
		$this->load->model('servers');
		$this->load->model('serversStats');
		
		$error = $this->validate($serverid);
		if($error) {
			$this->session->data['error'] = $error;
			$this->response->redirect($this->config->url . 'monitoring/index');
		}
		
		$server = $this->serversModel->getServerById($serverid, array('games', 'locations'));
		$this->data['server'] = $server;
		
		$queryLib = new queryLibrary($server['game_query']);
		$queryLib->connect($server['location_ip'], $server['server_port']);
		$query = $queryLib->getInfo();
		$queryLib->disconnect();
		
		$this->data['query'] = $query;
			
		$serverload = round($query['players'] * 100 / $query['maxplayers'], 1);
		$this->data['serverload'] = $serverload;
		
		$stats = $this->serversStatsModel->getServerStats($serverid, "NOW() - INTERVAL 1 DAY", "NOW()");
		$this->data['stats'] = $stats;

		$this->getChild(array('common/header', 'common/footer'));
		return $this->load->view('monitoring/view', $this->data);
	}
	
	private function validate($serverid) {
		$this->load->checkLicense();
		$result = null;
		
		if(!$this->serversModel->getTotalServers(array('server_id' => (int)$serverid, 'server_monitoring' => 1, 'server_status' => 2))) {
			$result = "Запрашиваемый сервер не существует!";
		}
		return $result;
	}
}
?>
