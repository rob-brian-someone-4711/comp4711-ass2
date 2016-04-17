<?php

class Stocks extends MY_Model {
	
	// Constructor
	function __construct()
	{
		parent::__construct();
	}
	
        //Gets stocks by value
	function local() {
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
	
	function all() {
		// $stocks = $this->ImportCSV2Array('http://www.comp4711bsx.local/data/stocks');
		$stocks = $this->ImportCSV2Array(BSX . 'data/stocks');
		return $stocks;
	}
	
	// Return stock names in redundant array for use in drop-downs
	function dropdown($formname) {
		// $stocks = $this->ImportCSV2Array('http://www.comp4711bsx.local/data/stocks');
		$stocks = $this->ImportCSV2Array(BSX . 'data/stocks');
		foreach ($stocks as $temp) {
			$description = $temp["code"] . " - " . $temp["name"] . " - $" . $temp["value"];
			$result[(string)$temp["code"]] = $description;
		}
		return form_dropdown($formname, $result);
	}
	
	function moves() {
		$movements = $this->ImportCSV2Array(BSX . 'data/movement');
		return $movements;
	}
	
	function transactions() {
		$tx = $this->ImportCSV2Array(BSX . 'data/transactions');
		return $tx;
	}
	
	// Register with bsx server and return token if successful (or null)
	function register() {

		// $this->rest->initialize(array('server' => 'http://www.comp4711bsx.local/'));
		$this->rest->initialize(array('server' => 'http://bsx.jlparry.com/'));

		
		// Playing a little joke on George..
		$params = array("team" => "G07", "name" => "George's_Mom", "password" => "tuesday");
		$this->rest->post('register', $params);
		
		// My real registration:
		$params = array("team" => "B07", "name" => "Digibroz", "password" => "tuesday");	
		$response = $this->rest->post('register', $params);
		
		if (isset($response["token"])) {
			return $response["token"];
		} else {
			return null;
		}
	}
	
	function buy($stockname, $quantity) {
		$token = $this->register();
		
		$this->load->model("Stocks");
		$stocks = $this->Stocks->all();
		
		// $this->rest->initialize(array('server' => 'http://www.comp4711bsx.local/'));
		$this->rest->initialize(array('server' => 'http://bsx.jlparry.com/'));
		
		// Buy parameters
		$params = array(
			"team" => "B07",
			"token" => $token, 			 
			"player" => "Digibroz", 
			"stock" => $stockname,
			"quantity" => $quantity
			);	
		$response = $this->rest->post('buy', $params);
		// var_dump($response);
		return $response;
	}
}