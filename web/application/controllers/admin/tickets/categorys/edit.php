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
class editController extends Controller {
	public function index($categoryid = null) {
		$this->load->checkLicense();
		$this->document->setActiveSection('admin');
		$this->document->setActiveItem('ticketscategorys');
 
		if(!$this->user->isLogged()) {
			$this->session->data['error'] = "Вы не авторизированы!";
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 3) {
			$this->session->data['error'] = "У вас нет доступа к данному разделу!";
			$this->response->redirect($this->config->url);
		}
		
		$this->load->model('ticketsCategorys');
		
		$error = $this->validate($categoryid);
		if($error) {
			$this->session->data['error'] = $error;
			$this->response->redirect($this->config->url . 'admin/tickets/categorys/index');
		}
		
		$category = $this->ticketsCategorysModel->getTicketCategoryById($categoryid);
		
		$this->data['category'] = $category;
		
		$this->getChild(array('common/header', 'common/footer'));
		return $this->load->view('admin/tickets/categorys/edit', $this->data);
	}
	
	public function ajax($categoryid = null) {
		$this->load->checkLicense();
		if(!$this->user->isLogged()) {  
	  		$this->data['status'] = "error";
			$this->data['error'] = "Вы не авторизированы!";
			return json_encode($this->data);
		}
		if($this->user->getAccessLevel() < 3) {
			$this->data['status'] = "error";
			$this->data['error'] = "У вас нет доступа к данному разделу!";
			return json_encode($this->data);
		}
		
		$this->load->model('ticketsCategorys');
		
		$error = $this->validate($categoryid);
		if($error) {
			$this->data['status'] = "error";
			$this->data['error'] = $error;
			return json_encode($this->data);
		}
		
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
			$errorPOST = $this->validatePOST();
			if(!$errorPOST) {
				$name = @$this->request->post['name'];
				$status = @$this->request->post['status'];
				
				$categoryData = array(
					'ticket_category_name'			=> $name,
					'ticket_category_status'		=> (int)$status
				);
				
				$this->ticketsCategorysModel->updateTicketCategory($categoryid, $categoryData);
				
				$this->data['status'] = "success";
				$this->data['success'] = "Вы успешно отредактировали категорию запросов!";
			} else {
				$this->data['status'] = "error";
				$this->data['error'] = $errorPOST;
			}
		}

		return json_encode($this->data);
	}
	
	public function delete($categoryid = null) {
		$this->load->checkLicense();
		$this->document->setActiveSection('admin');
		$this->document->setActiveItem('tickets');
		
		if(!$this->user->isLogged()) {
			$this->session->data['error'] = "Вы не авторизированы!";
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 3) {
			$this->session->data['error'] = "У вас нет доступа к данному разделу!";
			$this->response->redirect($this->config->url);
		}
		
		$this->load->model('ticketsCategorys');
		
		$error = $this->validate($categoryid);
		if($error) {
			$this->session->data['error'] = $error;
			$this->response->redirect($this->config->url . 'admin/tickets/categorys/index');
		}
		
		$this->ticketsCategorysModel->deleteTicketCategory($categoryid);
		
		$this->session->data['success'] = "Вы успешно удалили категорию запросов!";
		$this->response->redirect($this->config->url . 'admin/tickets/categorys/index');
		return null;
	}
	
	private function validate($categoryid) {
		$result = null;
		
		if(!$this->ticketsCategorysModel->getTotalTicketsCategorys(array('ticket_category_id' => (int)$categoryid))) {
			$result = "Запрашиваемая категория запросов не существует!";
		}
		return $result;
	}
	
	private function validatePOST() {
		$this->load->library('validate');
		
		$validateLib = new validateLibrary();
		
		$result = null;
		
		$name = @$this->request->post['name'];
		$status = @$this->request->post['status'];
		
		if(mb_strlen(trim($name)) < 2 || mb_strlen(trim($name)) > 32) {
			$result = "Название категории запросов должно содержать от 2 до 32 символов!";
		}
		elseif($status < 0 || $status > 1) {
			$result = "Укажите допустимый статус!";
		}
		return $result;
	}
}
?>
