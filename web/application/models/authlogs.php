<?php
/*
* @LitePanel
* @Version: 1.0.1
* @Date: 29.12.2012
* @Developed by QuickDevel
*/
class authlogsModel extends Model {
	public function createAuthLog($data) {
	  $ipDetail=array();
		$f = file_get_contents("http://api.geoiplookup.net/?query=".$data['authlog_ip']); 
		 
		// Получаем название страны
		preg_match("@<countryname>(.*?)</countryname>@si", $f, $country);
		$ipDetail['country'] = $country[1];
		
		// Получаем название города
		preg_match("@<city>(.*?)</city>@si", $f, $city);
		$ipDetail['city'] = $city[1];
		
		// Получаем название провайдера
		preg_match("@<isp>(.*?)</isp>@si", $f, $isp);
		$ipDetail['isp'] = $isp[1];
		
		$sql = "INSERT INTO `authlogs` SET ";
		$sql .= "user_id = '" . (int)$data['user_id'] . "', ";
		$sql .= "authlog_ip = '" . $this->db->escape($data['authlog_ip']) . "', ";
		$sql .= "authlog_country = '" . $this->db->escape($ipDetail['country']) . "', ";
		$sql .= "authlog_city = '" . $this->db->escape($ipDetail['city']) . "', ";
		$sql .= "authlog_isp = '" . $this->db->escape($ipDetail['isp']) . "', ";
		$sql .= "authlog_status = '" . (int)$data['authlog_status'] . "', ";
		$sql .= "authlog_date_add = NOW()";
		$this->db->query($sql);
		return $this->db->getLastId();
	}
	
	public function deleteAuthLog($authlogid) {
		$sql = "DELETE FROM `authlogs` WHERE authlog_id = '" . (int)$authlogid . "'";
		$this->db->query($sql);
	}
	
	public function getAuthLogs($data = array(), $joins = array(), $sort = array(), $options = array()) {
		$sql = "SELECT * FROM `authlogs`";
		foreach($joins as $join) {
			$sql .= " LEFT JOIN $join";
			switch($join) {
				case "users":
					$sql .= " ON authlogs.user_id=users.user_id";
					break;
			}
		}
		
		if(!empty($data)) {
			$count = count($data);
			$sql .= " WHERE";
			foreach($data as $key => $value) {
				$sql .= " $key = '" . $this->db->escape($value) . "'";
				
				$count--;
				if($count > 0) $sql .= " AND";
			}
		}
		
		if(!empty($sort)) {
			$count = count($sort);
			$sql .= " ORDER BY";
			foreach($sort as $key => $value) {
				$sql .= " $key " . $value;
				
				$count--;
				if($count > 0) $sql .= ",";
			}
		}
		
		if(!empty($options)) {
			if ($options['start'] < 0) {
				$options['start'] = 0;
			}
			if ($options['limit'] < 1) {
				$options['limit'] = 20;
			}
			$sql .= " LIMIT " . (int)$options['start'] . "," . (int)$options['limit'];
		}
		$query = $this->db->query($sql);
		return $query->rows;
	}
	
	public function getTotalAuthLogs($data = array()) {
		$sql = "SELECT COUNT(*) AS count FROM `authlogs`";
		if(!empty($data)) {
			$count = count($data);
			$sql .= " WHERE";
			foreach($data as $key => $value) {
				$sql .= " $key = '" . $this->db->escape($value) . "'";
				
				$count--;
				if($count > 0) $sql .= " AND";
			}
		}
		$query = $this->db->query($sql);
		return $query->row['count'];
	}
	
	public function clearAuthLogs() {
		$sql = "DELETE FROM `authlogs` WHERE authlog_date_add < NOW() - INTERVAL 1 MONTH";
		$this->db->query($sql);
	}
}
?>
