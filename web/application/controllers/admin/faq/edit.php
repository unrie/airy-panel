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
	public function index($faqid = null) {
		$this->load->checkLicense();
		$this->document->setActiveSection('admin');
		$this->document->setActiveItem('faq');
		
		if(!$this->user->isLogged()) {
			$this->session->data['error'] = "Вы не авторизированы!";
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 3) {
			$this->session->data['error'] = "У вас нет доступа к данному разделу!";
			$this->response->redirect($this->config->url);
		}
		
		$this->load->model('faq');
		
		$error = $this->validate($faqid);
		if($error) {
			$this->session->data['error'] = $error;
			$this->response->redirect($this->config->url . 'admin/faq/index');
		}
		
		$faq = $this->faqModel->getFaqById($faqid);
		
		$this->data['faq'] = $faq;
		
		$this->getChild(array('common/header', 'common/footer'));
		return $this->load->view('admin/faq/edit', $this->data);
	}
	
	public function ajax($faqid = null) {
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
		
		$this->load->model('faq');
		
		$error = $this->validate($faqid);
		if($error) {
			$this->data['status'] = "error";
			$this->data['error'] = $error;
			return json_encode($this->data);
		}
		
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
			$errorPOST = $this->validatePOST();
			if(!$errorPOST) {
				$name = @$this->request->post['name'];
				$text = @$this->request->post['text'];
				$status = @$this->request->post['status'];
				
				$faqData = array(
					'faq_name'		=> $name,
					'faq_text'			=> $text,
					'faq_status'			=> (int)$status
				);
				
				$this->faqModel->updateFaq($faqid, $faqData);
				
				$this->data['status'] = "success";
				$this->data['success'] = "Вы успешно отредактировали FAQ!";
			} else {
				$this->data['status'] = "error";
				$this->data['error'] = $errorPOST;
			}
		}

		return json_encode($this->data);
	}
	
	public function delete($faqid = null) {
		$this->load->checkLicense();
		$this->document->setActiveSection('admin');
		$this->document->setActiveItem('faq');
		
		if(!$this->user->isLogged()) {
			$this->session->data['error'] = "Вы не авторизированы!";
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 3) {
			$this->session->data['error'] = "У вас нет доступа к данному разделу!";
			$this->response->redirect($this->config->url);
		}
		
		$this->load->model('faq');
		
		$error = $this->validate($faqid);
		if($error) {
			$this->session->data['error'] = $error;
			$this->response->redirect($this->config->url . 'admin/faq/index');
		}
		
		$this->faqModel->deleteFaq($faqid);
		
		$this->session->data['success'] = "Вы успешно удалили FAQ!";
		$this->response->redirect($this->config->url . 'admin/faq/index');
		return null;
	}
	
	private function validate($faqid) {
		$this->load->checkLicense();
		$result = null;
		
		if(!$this->faqModel->getTotalFaq(array('faq_id' => (int)$faqid))) {
			$result = "Запрашиваемый FAQ не существует!";
		}
		return $result;
	}
	
	private function validatePOST() {
		$this->load->checkLicense();
		$this->load->library('validate');
		
		$validateLib = new validateLibrary();
		
		$result = null;
		
		$name = @$this->request->post['name'];
		$text = @$this->request->post['text'];
		$status = @$this->request->post['status'];
		
		if(mb_strlen(trim($name)) < 6 || mb_strlen(trim($name)) > 32) {
			$result = "Название FAQ должно содержать от 6 до 32 символов!";
		}
		elseif(mb_strlen(trim($text)) < 10 || mb_strlen(trim($text)) > 350) {
			$result = "Текст FAQ должен содержать от 10 до 350 символов!";
		}
		elseif($status < 0 || $status > 1) {
			$result = "Укажите допустимый статус FAQ!";
		}
		return $result;
	}
}
?>
