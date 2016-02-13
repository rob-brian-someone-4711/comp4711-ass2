<?php

class Players extends CI_Model {
	
	// Constructor
	function __construct()
	{
		parent::__construct();
	}
	
	// Return all images in descending order of date
	function all() {
		$this->db->order_by("Cash");
		$query = $this->db->get('players');
		return $query->result_array();
	}
	
	//Get a specific player
	function get($pname) {
                $specificPlayer = "player = '{$pname}'";
                $this->db->where($specificPlayer);
		$query = $this->db->get('players')->row()->Cash;
		return $query;
                return $query->result_array();
	}
        
        //Get a list of all the player names
        function getnames(){
            $this->db->order_by("Player");
            //$this->db->select('Player');
            $query = $this->db->get('players');
            return $query->result_array();
        }
        
        
      	
	/*
	function newest() {
		$this->db->order_by("id", "desc");
		$this->db->limit(3);
		$query = $this->db->get('players');
		return $query->result_array();
	}
	*/
	
}