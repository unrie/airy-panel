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
class slotsController extends Controller {
	public function index($serverid = null) {
		$this->load->checkLicense();
		$this->document->setActiveSection('servers');
		$this->document->setActiveItem('slots');
		
		if(!$this->user->isLogged()) {
			$this->session->data['error'] = "Вы не авторизированы!";
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 0) {
			$this->session->data['error'] = "У вас нет доступа к данному разделу!";
			$this->response->redirect($this->config->url);
		}
		
		$this->load->model('servers');
		
		$error = $this->validate($serverid);
		if($error) {
			$this->session->data['error'] = $error;
			$this->response->redirect($this->config->url . 'servers/index');
		}
		
		$server = $this->serversModel->getServerById($serverid, array('games'));
		
		$datenow = date_create('now');
    $dateend = date_create($server['server_date_end']);
		$diff = date_diff($datenow, $dateend);
		
		$this->data['server'] = $server;
		$this->data['diff'] = $diff;
		
		$this->getChild(array('common/header', 'common/footer'));
		return $this->load->view('servers/slots', $this->data);
	}
	
	public function ajax($serverid = null) {
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
		
		$this->load->model('users');
		$this->load->model('games');
		$this->load->model('servers');
		$this->load->model('invoices');
		
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
			$slots = $this->request->post['slots'];
			
			$userid = $this->user->getId();
			$balance = $this->user->getBalance();

			$server = $this->serversModel->getServerById($serverid, array('games'));
			
			$datenow = date_create('now');
      $dateend = date_create($server['server_date_end']);
		  $diff = date_diff($datenow, $dateend);
			
			$price = $server['game_price'] * ($slots-$server['server_slots']) / 30 * $diff->days;
			
			if($server['server_status'] == 1) {
			  if($this->gamesModel->validateSlots($server['game_id'], $slots)) {
			    if($slots <= $server['server_slots']) {
			      $this->serversModel->updateServer($serverid, array('server_slots' => (int)$slots));	
			      $this->data['status'] = "success";
			      $this->data['success'] = "Вы успешно изменили количество слотов сервера!";
			    }
			    elseif($balance >= $price) {
			      if((!$diff->invert) && $diff->days > 2){
			        $this->serversModel->updateServer($serverid, array('server_slots' => (int)$slots));
				      $this->usersModel->downUserBalance($userid, $price);
				      $invoiceData = array(
					      'user_id'			=> $userid,
					      'invoice_ammount'	=> $price,
					      'invoice_details'	=> "Слоты сервера gs".(int)$serverid,
					      'invoice_type'	=> 0,
					      'invoice_status'	=> 1
				       );
				      $this->invoicesModel->createInvoice($invoiceData);
				      $this->data['status'] = "success";
				      $this->data['success'] = "Вы успешно увеличили количество слотов сервера!";
				    } else {
				      $this->data['status'] = "error";
				      $this->data['error'] = "Для увеличения количества слотов оплатите сервер!";
			      }
				  } else {
				    $this->data['status'] = "error";
				    $this->data['error'] = "На Вашем счету недостаточно средств!";
			    }
			  } else {
				  $this->data['status'] = "error";
				  $this->data['error'] = "Вы указали недопустимое количество слотов!";
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
		
		$userid = $this->user->getId();
		
		if(!$this->serversModel->getTotalServers(array('server_id' => (int)$serverid, 'user_id' => (int)$userid))) {
			$result = "Запрашиваемый сервер не существует!";
		}
		return $result;
	}
}
?>
