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
class indexController extends Controller {
	public function index() {
		$this->load->checkLicense();
		$this->document->setActiveSection('main');
		$this->document->setActiveItem('index');
		
		if(!$this->user->isLogged()) {
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 0) {
			$this->session->data['error'] = "У вас нет доступа к данному разделу!";
			$this->response->redirect($this->config->url);
		}
		
		$this->load->model('servers');
		$this->load->model('tickets');
		$this->load->model('authlogs');
		$this->load->model('users');
		
		$userid = $this->user->getId();
		
		$this->data['logged'] = true;
		$this->data['user_id'] = $this->user->getId();
		$this->data['user_email'] = $this->user->getEmail();
		$this->data['user_firstname'] = $this->user->getFirstname();
		$this->data['user_lastname'] = $this->user->getLastname();
		$this->data['user_balance'] = $this->user->getBalance();
		$this->data['user_date_reg'] = $this->user->getDateReg();
		
		$serversSort = array(
			'server_date_reg'	=> 'DESC'
		);
		
		$ticketsSort = array(
			'ticket_status'		=> 'DESC',
			'ticket_date_add'	=> 'DESC'
		);
		
		$authlogsSort = array(
			'authlog_date_add'	=> 'DESC'
		);
		
		$options = array(
			'start' => 0,
			'limit' => 5
		);
		
		$servers = $this->serversModel->getServers(array('user_id' => (int)$userid), array('games', 'locations'), $serversSort, $options);
		$tickets = $this->ticketsModel->getTickets(array('user_id' => (int)$userid), array('tickets_categorys'), $ticketsSort, $options);
		$authlogs = $this->authlogsModel->getAuthLogs(array('user_id' => (int)$userid), array(), $authlogsSort, $options);
		$this->data['servers'] = $servers;
		$this->data['tickets'] = $tickets;
		$this->data['authlogs'] = $authlogs;
		
		$this->getChild(array('common/header', 'common/footer'));
		return $this->load->view('main/index', $this->data);
	}
}
?>