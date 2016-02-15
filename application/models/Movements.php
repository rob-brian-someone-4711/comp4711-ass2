<?php

class Movements extends CI_Model {
	
	// Constructor
	function __construct()
	{
		parent::__construct();
	}
	
	function all() {
		$this->db->order_by("Datetime");
		$query = $this->db->get('movements');
		return $query->result_array();
	}
        
        function byStock($stockname) {
        $this->db->order_by("DateTime");
        $checkName = "Code = '{$stockname}'";
        $this->db->where($checkName);
        $query = $this->db->get('movements');
        return $query->result_array();  
        }
	
}