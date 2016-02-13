<?php

class Transactions extends CI_Model {
	
	// Constructor
	function __construct()
	{
		parent::__construct();
	}
	
	function all() {
		$this->db->order_by("DateTime");
		$query = $this->db->get('transactions');
		return $query->result_array();
	}
        
        function byPlayer($pname){
                $this->db->order_by("DateTime");
                $checkName = "Player = '{$pname}'";
                $this->db->where($checkName);
		$query = $this->db->get('transactions');
		return $query->result_array();            
        }
        
        function amountByPlayer($pname){
                $this->db->order_by("Stock");
                $this->db->select("Stock, SUM(CASE
               WHEN Trans = 'buy' THEN Quantity
               ELSE Quantity * -1
            END) AS total", FALSE);
                $checkName = "Player = '{$pname}'";
                $this->db->where($checkName);
                $this->db->group_by('Stock');
		$query = $this->db->get('transactions');
                
                return $query->result_array();
        }
	
}