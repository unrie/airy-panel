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
		$this->document->setActiveSection('admin');
		$this->document->setActiveItem('ticketscategorys');
		
		if(!$this->user->isLogged()) {
			$this->session->data['error'] = "�� �� ��������������!";
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 3) {
			$this->session->data['error'] = "� ��� ��� ������� � ������� �������!";
			$this->response->redirect($this->config->url);
		}
		
		$this->load->library('pagination');
		$this->load->model('ticketsCategorys');
		
		$options = array(
			'start' => ($page - 1) * $this->limit,
			'limit' => $this->limit
		);
		
		$total = $this->ticketsCategorysModel->getTotalTicketsCategorys();
		$categorys = $this->ticketsCategorysModel->getTicketsCategorys(array(), array(), $options);
		
		$paginationLib = new paginationLibrary();
		
		$paginationLib->total = $total;
		$paginationLib->page = $page;
		$paginationLib->limit = $this->limit;
		$paginationLib->url = $this->config->url . 'admin/tickets/categorys/index/index/{page}';
		
		$pagination = $paginationLib->render();
		
		$this->data['categorys'] = $categorys;
		$this->data['pagination'] = $pagination;
		
		$this->getChild(array('common/header', 'common/footer'));
		return $this->load->view('admin/tickets/categorys/index', $this->data);
	}
}
?>
