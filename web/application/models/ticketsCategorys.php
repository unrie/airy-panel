<?php
/*
* @LitePanel
* @Version: 1.0.1
* @Date: 29.12.2012
* @Developed by QuickDevel
*/
class ticketsCategorysModel extends Model {

	public function createTicketCategory($data) {
		$sql = "INSERT INTO `tickets_categorys` SET ";
		$sql .= "ticket_category_name = '" . $this->db->escape($data['ticket_category_name']) . "', ";
		$sql .= "ticket_category_status = '" . (int)$data['ticket_category_status'] . "' ";
		$this->db->query($sql);
		return $this->db->getLastId();
	}
	
	public function deleteTicketCategory($categoryid) {
		$sql = "DELETE FROM `tickets_categorys` WHERE ticket_category_id = '" . (int)$categoryid . "'";
		$this->db->query($sql);
	}
	
	public function updateTicketCategory($categoryid, $data = array()) {
		$sql = "UPDATE `tickets_categorys`";
		if(!empty($data)) {
			$count = count($data);
			$sql .= " SET";
			foreach($data as $key => $value) {
				$sql .= " $key = '" . $this->db->escape($value) . "'";
				
				$count--;
				if($count > 0) $sql .= ",";
			}
		}
		$sql .= " WHERE `ticket_category_id` = '" . (int)$categoryid . "'";
		$query = $this->db->query($sql);
		return true;
	}
	
	public function getTicketsCategorys($data = array(), $sort = array(), $options = array()) {
		$sql = "SELECT * FROM `tickets_categorys`";
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
	
	public function getTicketCategoryById($categoryid, $joins = array()) {
		$sql = "SELECT * FROM `tickets_categorys`";
		$sql .=  " WHERE `ticket_category_id` = '" . (int)$categoryid . "' LIMIT 1";
		$query = $this->db->query($sql);
		return $query->row;
	}
	
	public function getTotalTicketsCategorys($data = array()) {
		$sql = "SELECT COUNT(*) AS count FROM `tickets_categorys`";
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
