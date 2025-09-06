<?php
/*
* @LitePanel
* @Version: 1.0.1
* @Date: 12.02.2014
* @Developed by RossyBAN
*/
class faqModel extends Model {
	public function createFaq($data) {
		$sql = "INSERT INTO `faq` SET ";
		$sql .= "faq_name = '" . $this->db->escape($data['faq_name']) . "', ";
		$sql .= "faq_text = '" . $this->db->escape($data['faq_text']) . "', ";
		$sql .= "faq_status = '" . (int)$data['faq_status'] . "'";
		$this->db->query($sql);
		return $this->db->getLastId();
	}

	public function deleteFaq($faqid) {
		$sql = "DELETE FROM `faq` WHERE faq_id = '" . (int)$faqid . "'";
		$this->db->query($sql);
	}
	
	public function updateFaq($faqid, $data = array()) {
		$sql = "UPDATE `faq`";
		if(!empty($data)) {
			$count = count($data);
			$sql .= " SET";
			foreach($data as $key => $value) {
				$sql .= " $key = '" . $this->db->escape($value) . "'";
				
				$count--;
				if($count > 0) $sql .= ",";
			}
		}
		$sql .= " WHERE `faq_id` = '" . (int)$faqid . "'";
		$query = $this->db->query($sql);
		return true;
	}
	
	public function getFaq($data = array(), $sort = array(), $options = array()) {
		$sql = "SELECT * FROM `faq`";
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
	
	public function getFaqById($faqid) {
		$sql = "SELECT * FROM `faq` WHERE `faq_id` = '" . (int)$faqid . "' LIMIT 1";
		$query = $this->db->query($sql);
		return $query->row;
	}
	
	public function getTotalFaq($data = array()) {
		$sql = "SELECT COUNT(*) AS count FROM `faq`";
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
