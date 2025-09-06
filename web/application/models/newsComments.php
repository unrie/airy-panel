<?php
/*
* @LitePanel
* @Version: 1.0.1
* @Date: 29.12.2012
* @Developed by QuickDevel
*/
class newsCommentsModel extends Model {
	public function createNewsComment($data) {
		$sql = "INSERT INTO `news_comments` SET ";
		$sql .= "news_id = '" . (int)$data['news_id'] . "', ";
		$sql .= "user_id = '" . (int)$data['user_id'] . "', ";
		$sql .= "news_comment_text = '" . $this->db->escape($data['news_comment_text']) . "', ";
		$sql .= "news_comment_date_add = NOW()";
		$this->db->query($sql);
		return $this->db->getLastId();
	}
	
	public function deleteNewsComment($commentid) {
		$sql = "DELETE FROM `news_comments` WHERE news_comment_id = '" . (int)$commentid . "'";
		$this->db->query($sql);
	}
	
	public function updateNewsComment($commentid, $data = array()) {
		$sql = "UPDATE `news_comments`";
		if(!empty($data)) {
			$count = count($data);
			$sql .= " SET";
			foreach($data as $key => $value) {
				$sql .= " $key = '" . $this->db->escape($value) . "'";
				
				$count--;
				if($count > 0) $sql .= ",";
			}
		}
		$sql .= " WHERE `news_comment_id` = '" . (int)$commentid . "'";
		$query = $this->db->query($sql);
		return true;
	}
	
	public function getNewsComments($data = array(), $joins = array(), $sort = array(), $options = array()) {
		$sql = "SELECT * FROM `news_comments`";
		foreach($joins as $join) {
			$sql .= " LEFT JOIN $join";
			switch($join) {
				case "users":
					$sql .= " ON news_comments.user_id=users.user_id";
					break;
				case "news":
					$sql .= " ON news_comments.news_id=news.news_id";
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
			if($options['start'] < 0) {
				$options['start'] = 0;
			}
			if($options['limit'] < 1) {
				$options['limit'] = 20;
			}
			$sql .= " LIMIT " . (int)$options['start'] . "," . (int)$options['limit'];
		}
		$query = $this->db->query($sql);
		return $query->rows;
	}
	
	public function getNewsCommentById($commentid, $joins = array()) {
		$sql = "SELECT * FROM `news_comments`";
		foreach($joins as $join) {
			$sql .= " LEFT JOIN $join";
			switch($join) {
				case "users":
					$sql .= " ON news_comments.user_id=users.user_id";
					break;
			}
		}
		$sql .=  " WHERE `news_comment_id` = '" . (int)$commentid . "' LIMIT 1";
		$query = $this->db->query($sql);
		return $query->row;
	}
	
	public function getTotalNewsComments($data = array()) {
		$sql = "SELECT COUNT(*) AS count FROM `news_comments`";
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
