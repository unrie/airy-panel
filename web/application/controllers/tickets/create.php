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
class createController extends Controller {
	public function index($ticketid = null) {
		$this->load->checkLicense();
		$this->document->setActiveSection('tickets');
		$this->document->setActiveItem('create');
		
		if(!$this->user->isLogged()) {
			$this->session->data['error'] = "Вы не авторизированы!";
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 0) {
			$this->session->data['error'] = "У вас нет доступа к данному разделу!";
			$this->response->redirect($this->config->url);
		}
		
		$this->load->model('ticketsCategorys');
		$this->load->model('servers');
		
		$categorys = $this->ticketsCategorysModel->getTicketsCategorys(array('ticket_category_status' => 1));
		
		$userid = $this->user->getId();
		$servers = $this->serversModel->getServers(array('user_id' => (int)$userid));
		
		$this->data['categorys'] = $categorys;
		$this->data['servers'] = $servers;
		$this->data['recaptcha_client'] = $this->config->recaptcha_client;
		
		$this->getChild(array('common/header', 'common/footer'));
		return $this->load->view('tickets/create', $this->data);
	}
	
	public function ajax($ticketid = null) {
		$this->load->checkLicense();
		if(!$this->user->isLogged()) {  
	  		$this->data['status'] = "error";
			$this->data['error'] = "Вы не авторизированы!";
			return json_encode($this->data);
		}
		if($this->user->getAccessLevel() < 1) {
	  		$this->data['status'] = "error";
			$this->data['error'] = "У вас нет доступа к данному разделу!";
			return json_encode($this->data);
		}
		
		$this->load->model('tickets');
		$this->load->model('ticketsCategorys');
		$this->load->model('ticketsMessages');
		$this->load->model('servers');
		
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
			$errorPOST = $this->validatePOST();
			if(!$errorPOST) {
				$name = @$this->request->post['name'];
				$categoryid = @$this->request->post['categoryid'];
				$serverid = @$this->request->post['serverid'];
				$text = @$this->request->post['text'];
				
				$userid = $this->user->getId();
				
				$ticketData = array(
				  'ticket_category_id'		=> $categoryid,
					'user_id'			=> $userid,
					'server_id'			=> $serverid,
					'ticket_name'		=> $name,
					'ticket_status'		=> 1
				);
				$ticketid = $this->ticketsModel->createTicket($ticketData);
				
				$messageData = array(
					'ticket_id'			=> $ticketid,
					'user_id'			=> $userid,
					'ticket_message'	=> $text
				);
				$this->ticketsMessagesModel->createTicketMessage($messageData);
				
				$this->data['status'] = "success";
				$this->data['success'] = "Вы успешно создали запрос!";
				$this->data['id'] = $ticketid;
			} else {
				$this->data['status'] = "error";
				$this->data['error'] = $errorPOST;
			}
		}

		return json_encode($this->data);
	}
	
	private function validatePOST() {
		$this->load->checkLicense();
		$this->load->library('recaptcha');
		
		$secret = $this->config->recaptcha_server;
    $reCaptcha = new ReCaptcha($secret);
		
		$response = null;
		$result = null;
		
		$userid = $this->user->getId();
		
		$name = @$this->request->post['name'];
		$categoryid = @$this->request->post['categoryid'];
		$serverid = @$this->request->post['serverid'];
		$text = @$this->request->post['text'];
		
		$remote_addr = $this->request->server['REMOTE_ADDR'];
		$g_recaptcha_response = @$this->request->post['g-recaptcha-response'];
		$response = $reCaptcha->verifyResponse($remote_addr, $g_recaptcha_response);
		
		if(mb_strlen(trim($name)) < 6 || mb_strlen(trim($name)) > 32) {
			$result = "Название запроса должно содержать от 6 до 32 символов!";
		}
		elseif(!$this->ticketsCategorysModel->getTotalTicketsCategorys(array('ticket_category_id' => (int)$categoryid, 'ticket_category_status' => 1))) {
			$result = "Вы указали несуществующую категорию!";
		}
		elseif($serverid != 0) {
		  if(!$this->serversModel->getTotalServers(array('server_id' => (int)$serverid, 'user_id' => (int)$userid))) {
			  $result = "Выбранный сервер не существует!";
		  }
		}
		elseif(mb_strlen(trim($text)) < 10 || mb_strlen(trim($text)) > 350) {
			$result = "Текст запроса должен содержать от 10 до 350 символов!";
		}
		elseif(!($response != null && $response->success)) {
			$result = "Подтвердите, что Вы не робот!";
		}
		return $result;
	}
}
