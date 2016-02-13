<?php

class Stocks extends CI_Model {
	
	// Constructor
	function __construct()
	{
		parent::__construct();
	}
	
	function all() {
		$this->db->order_by("Value");
		$query = $this->db->get('stocks');
		return $query->result_array();
	}
	
}