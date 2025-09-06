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
		$this->document->setActiveSection('faq');
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
		$this->load->model('faq');
		
		$options = array(
			'start' => ($page - 1) * $this->limit,
			'limit' => $this->limit
		);
		
		$total = $this->faqModel->getTotalFaq(array('faq_status' => 1));
		$faq = $this->faqModel->getFaq(array('faq_status' => 1), array(), array(), $options);
		
		$paginationLib = new paginationLibrary();
		
		$paginationLib->total = $total;
		$paginationLib->page = $page;
		$paginationLib->limit = $this->limit;
		$paginationLib->url = $this->config->url . 'faq/index/index/{page}';
		
		$pagination = $paginationLib->render();
		
		$this->data['faq'] = $faq;
		$this->data['pagination'] = $pagination;
		
		$this->getChild(array('common/header', 'common/footer'));
		return $this->load->view('faq/index', $this->data);
	}
}
?>
