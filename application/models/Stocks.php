<?php

class Stocks extends CI_Model {
	
	// Constructor
	function __construct()
	{
		parent::__construct();
	}
	
        //Gets stocks by value
	function all() {
		$this->db->order_by("Value");
		$query = $this->db->get('stocks');
		return $query->result_array();
	}
        
        //Gets recent stock 
        function recent() { 
            $this->db->order_by('Datetime', 'desc');
            $query = $this->db->get('transactions')->row();
            return $query->result();
        }
	
}