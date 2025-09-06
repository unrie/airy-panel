<?php
class mineQuery extends QueryBase {
	public function connect($ip, $port) {
		$this->ip = $ip;
		$this->port = $port;
	}
	
	public function disconnect() {
	}
	
	private function sendPacket() {
	}
	
	public function getInfo() {
		require_once 'MinecraftQuery.php';
		require_once 'MinecraftQueryException.php';
		
		$Query = new MinecraftQuery();
	
	  try
	  {
		  $Query->Connect($this->ip, $this->port);
		
		  $info = $Query->GetInfo();
		  $Playersnick = $Query->GetPlayers();
		  
		  $data['players'] = (int)$info['Players'];
		  $data['maxplayers'] = (int)$info['MaxPlayers'];
		  $data['hostname'] = (string)$info['HostName'];
		  $data['gamemode'] = (string)$info['GameType'];
		  $data['mapname'] = (string)$info['Map'];
		  $data['Playersnick'] = $Playersnick;

		  return $data;
	  }
	  catch(MinecraftQueryException $e)
	  {
		  //echo $e->getMessage();
		  return false;
	  }
  }
}
?>