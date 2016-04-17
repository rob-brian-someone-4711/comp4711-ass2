<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//include MY_Controller

class Buy extends CI_Controller {

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
			// echo '<link rel="stylesheet" type="text/css" href="/application/views/main.css">';
            $this->load->helper(array('form', 'url'));

            $this->load->library('form_validation');    
			$this->load->model('stocks');
			$this->load->model("status");
			
			$this->data["result"] = "";
			if (isset($this->session->userdata["logged_on"])) {
				$this->data['username'] = $this->session->userdata["username"];
			} 
			
			// Get market status
			$status = $this->status->all();
			$this->data['marketStatus'] = $status["desc"];
			$this->data['countdown'] = $status["countdown"];
			
			// Parse input
			if ($this->input->post('buy') !== null) {				 
				{					
					$quant = $this->input->post('quantity');
					$buystock = $this->input->post('stocks');
					$buyResult = $this->stocks->buy($buystock, $quant);
					if (isset($buyResult['message'])) {
						$this->data["result"] = "The server says: " . $buyResult['message']. "<br>\n";
					}
					else {
						$this->data["result"] = "<h2>Success!</h2>";
						$this->data["result"] .= "Your certificate number is " . $buyResult["token"];
						$this->data["result"] .= "<br>\n";
					}

				}
			}
			
			$form = form_open();
			$form .= $this->stocks->dropdown("stocks");
			
			$inputparams = array(
				'name' => 'quantity',
				'size' => '5'
			);
			$form .= "<p>" . form_input($inputparams);
			
			$form .= form_submit("buy", "Buy!");
			
			$this->data['stocksForm'] = $form;
			$this->data['cash'] = 5000;
			

			$this->parser->parse('buy', $this->data);
                
	}
}
