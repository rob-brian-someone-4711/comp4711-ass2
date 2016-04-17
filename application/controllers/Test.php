<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//include MY_Controller

class Test extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{		
		echo "<h2>Test controller!</h2>";
	} 
	
	public function getStatus()
	{
		$this->load->model("Status");
		// Pull status XML off bsx.jlparry.com/status
		$statusItems = $this->Status->all();
		foreach($statusItems as $key => $val) {
			echo $key . " : " . $val . "<br>";
		}
		
		$this->load->model("Stocks");
		$stocks = $this->Stocks->all();
		echo var_dump($stocks);
		echo "\n<p>";
		$moves = $this->Stocks->moves();
		echo var_dump($moves);
		echo "\n<p>";
		$tx = $this->Stocks->transactions();
		echo var_dump($tx);
	}
	
	public function register() {

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
	
	public function info() {
		phpinfo();
	}
	
	public function buy($stockname, $quantity) {
		// $token = $this->register();
		// echo $token . "<br>";
		
		$this->load->model("Stocks");
		$response = $this->Stocks->buy($stockname, $quantity);
		
		/*
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
		*/
		var_dump($response);
	}
	
	public function sell($stockname, $cert) {
		$token = $this->register();
		echo $token . "<br>";
		
		$this->load->model("Stocks");
		$stocks = $this->Stocks->all();
		
		// $stock = (string)$stocks[1]["code"];
		echo $stockname . "<br>";
		$quantity = 1;
		
		// $this->rest->initialize(array('server' => 'http://www.comp4711bsx.local/'));
		$this->rest->initialize(array('server' => 'http://bsx.jlparry.com/'));
		
		// Buy parameters
		$params = array(
			"team" => "B07",
			"token" => $token, 			 
			"player" => "Digibroz", 
			"stock" => $stockname,
			"quantity" => $quantity,
			"certificate" => $cert
			);	
		$response = $this->rest->post('sell', $params);
		var_dump($response);
	}
	
	public function form() {
		$this->load->model("Stocks");
		echo $this->Stocks->dropdown("Stocks");
	}
}
