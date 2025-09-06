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
	public function index() {
		$this->load->checkLicense();
		$this->document->setActiveSection('admin');
		$this->document->setActiveItem('games');
		
		if(!$this->user->isLogged()) {
			$this->session->data['error'] = "Вы не авторизированы!";
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 3) {
			$this->session->data['error'] = "У вас нет доступа к данному разделу!";
			$this->response->redirect($this->config->url);
		}
		
		$this->data['queryDrivers'] = $this->getQueryDrivers();
		
		$this->getChild(array('common/header', 'common/footer'));
		return $this->load->view('admin/games/create', $this->data);
	}
	
	public function ajax() {
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
		
		$this->load->model('games');
		
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
			$errorPOST = $this->validatePOST();
			if(!$errorPOST) {
				$name = @$this->request->post['name'];
				$code = @$this->request->post['code'];
				$query = @$this->request->post['query'];
				$imageurl = @$this->request->post['imageurl'];
				$minslots = @$this->request->post['minslots'];
				$maxslots = @$this->request->post['maxslots'];
				$minport = @$this->request->post['minport'];
				$maxport = @$this->request->post['maxport'];
				$price = @$this->request->post['price'];
				$status = @$this->request->post['status'];
				
				$gameData = array(
					'game_name'			=> $name,
					'game_code'			=> $code,
					'game_query'		=> $query,
					'game_image_url'			=> $imageurl,
					'game_min_slots'	=> $minslots,
					'game_max_slots'	=> $maxslots,
					'game_min_port'		=> $minport,
					'game_max_port'		=> $maxport,
					'game_price'		=> $price,
					'game_status'		=> $status
				);
				
				$this->gamesModel->createGame($gameData);
				
				$this->data['status'] = "success";
				$this->data['success'] = "Вы успешно создали игру!";
			} else {
				$this->data['status'] = "error";
				$this->data['error'] = $errorPOST;
			}
		}

		return json_encode($this->data);
	}
	
	private function validatePOST() {
		$this->load->checkLicense();
		$this->load->library('validate');
		
		$validateLib = new validateLibrary();
		
		$result = null;
		
		$name = @$this->request->post['name'];
		$code = @$this->request->post['code'];
		$query = @$this->request->post['query'];
		$imageurl = @$this->request->post['imageurl'];
		$minslots = @$this->request->post['minslots'];
		$maxslots = @$this->request->post['maxslots'];
		$minport = @$this->request->post['minport'];
		$maxport = @$this->request->post['maxport'];
		$price = @$this->request->post['price'];
		$status = @$this->request->post['status'];
		
		if(mb_strlen(trim($name)) < 2 || mb_strlen(trim($name)) > 32) {
			$result = "Название игры должно содержать от 2 до 32 символов!";
		}
		elseif(mb_strlen(trim($code)) < 2 || mb_strlen(trim($code)) > 8) {
			$result = "Код игры должен содержать от 2 до 8 символов!";
		}
		elseif(!in_array($query, $this->getQueryDrivers())) {
			$result = "Укажите допустимый Query-драйвер!";
		}
		elseif($maxslots < $minslots) {
			$result = "Укажите допустимый интервал слотов!";
		}
		elseif($maxport < $minport) {
			$result = "Укажите допустимый интервал портов!";
		}
		elseif(!$validateLib->money($price)) {
			$result = "Укажите допустимую стоимость!";
		}
		elseif($status < 0 || $status > 1) {
			$result = "Укажите допустимый статус!";
		}
		return $result;
	}
	
	function getQueryDrivers() {
		$result = array();
		$drivers = glob(ENGINE_DIR . 'libs/query/*.driver.php');
		foreach ($drivers as $filename) {
			$result[] = basename($filename, ".driver.php");
		}
		return $result;
	}
}
?>
