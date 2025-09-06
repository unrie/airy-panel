<?php
/*
* @LitePanel
* @Version: 1.0.1
* @Date: 12.02.2014
* @Developed by RossyBAN
*/
class newsModel extends Model {
	public function createNews($data) {
		$sql = "INSERT INTO `news` SET ";
		$sql .= "user_id = '" . (int)$data['user_id'] . "', ";
		$sql .= "news_title = '" . $this->db->escape($data['news_title']) . "', ";
		$sql .= "news_text = '" . $this->db->escape($data['news_text']) . "', ";
		$sql .= "news_comments = '" . (int)$data['news_comments'] . "', ";
		$sql .= "news_type = '" . $this->db->escape($data['news_type']) . "', ";
		$sql .= "news_date_add = NOW()";
		$this->db->query($sql);
		return $this->db->getLastId();
	}

	public function deleteNews($newsid) {
		$sql = "DELETE FROM `news` WHERE news_id = '" . (int)$newsid . "'";
		$this->db->query($sql);
	}
	
	public function updateNews($newsid, $data = array()) {
		$sql = "UPDATE `news`";
		if(!empty($data)) {
			$count = count($data);
			$sql .= " SET";
			foreach($data as $key => $value) {
				$sql .= " $key = '" . $this->db->escape($value) . "'";
				
				$count--;
				if($count > 0) $sql .= ",";
			}
		}
		$sql .= " WHERE `news_id` = '" . (int)$newsid . "'";
		$query = $this->db->query($sql);
		return true;
	}
	
	public function getNews($data = array(), $joins = array(), $sort = array(), $options = array()) {
		$sql = "SELECT * FROM `news`";
		foreach($joins as $join) {
			$sql .= " LEFT JOIN $join";
			switch($join) {
				case "users":
					$sql .= " ON news.user_id=users.user_id";
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
	
	public function getNewsById($newsid, $joins = array()) {
		$sql = "SELECT * FROM `news`";
		foreach($joins as $join) {
			$sql .= " LEFT JOIN $join";
			switch($join) {
				case "users":
					$sql .= " ON news.user_id=users.user_id";
					break;
			}
		}
		$sql .=  " WHERE `news_id` = '" . (int)$newsid . "' LIMIT 1";
		$query = $this->db->query($sql);
		return $query->row;
	}
	
	public function getTotalNews($data = array()) {
		$sql = "SELECT COUNT(*) AS count FROM `news`";
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
}
?>
