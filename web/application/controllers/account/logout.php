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
class logoutController extends Controller {
	public function index() {
		$this->load->checkLicense();
		$this->document->setActiveSection('account');
		$this->document->setActiveItem('logout');
		
		if(!$this->user->isLogged()) {
			$this->session->data['error'] = 'Вы не авторизированы!';
			$this->response->redirect($this->config->url . 'account/login');
		}
		
		$this->load->model('authlogs');
		
		$userid = $this->user->getId();
		$ip = $this->request->server['REMOTE_ADDR'];
		
		$authlogData = array(
			'user_id'			=> $userid,
			'authlog_ip'	=> $ip,
			'authlog_status'	=> 2
		);
					
		$this->authlogsModel->createAuthLog($authlogData);
		
		$this->user->logout();
				
		$this->session->data['success'] = 'Вы успешно вышли из своего аккаунта!';
		$this->response->redirect($this->config->url);
		
		return null;
	}
}
?>
