<?php
/*
Copyright (c) 2014 LiteDevel

������ �������� ��������� �����, ���������� ����� ������� ������������ �����������
� ������������� ������������ (� ���������� ���������� ������������ �����������),
������������ ������������ ����������� ����������� �  ������ �����, ������� ��������������
����� �� �������������, �����������, ���������, ����������, ����������, ���������������,
����� ��� � �����, ������� ���������� ������������ ���������� ����������� � ������������ �����,
��������������� ������ ����������� �����������,��� ���������� ��������� �������:

Developed by LiteDevel
*/
class indexController extends Controller {
	private $limit = 20;
	public function index($page = 1) {
		$this->load->checkLicense();
		$this->document->setActiveSection('monitoring');
		$this->document->setActiveItem('index');
		
		if(!$this->user->isLogged()) {
			$this->session->data['error'] = "�� �� ��������������!";
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 0) {
			$this->session->data['error'] = "� ��� ��� ������� � ������� �������!";
			$this->response->redirect($this->config->url);
		}
		
		$this->load->library('pagination');
		$this->load->library('query');
		$this->load->model('servers');
		
		$sort = array(
			'server_date_reg'	=> 'DESC'
		);
		
		$options = array(
			'start' => ($page - 1) * $this->limit,
			'limit' => $this->limit
		);
		
		$total = $this->serversModel->getTotalServers(array('server_monitoring' => 1, 'server_status' => 2));
		$servers = $this->serversModel->getServers(array('server_monitoring' => 1, 'server_status' => 2), array('games', 'locations'), $sort, $options);
		
		$paginationLib = new paginationLibrary();
		
		$paginationLib->total = $total;
		$paginationLib->page = $page;
		$paginationLib->limit = $this->limit;
		$paginationLib->url = $this->config->url . 'monitoring/index/index/{page}';
		
		$pagination = $paginationLib->render();
		
		$this->data['servers'] = $servers;
		$this->data['pagination'] = $pagination;
		
		$this->getChild(array('common/header', 'common/footer'));
		return $this->load->view('monitoring/index', $this->data);
	}
}
?>
