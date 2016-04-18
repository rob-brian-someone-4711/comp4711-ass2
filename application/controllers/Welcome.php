<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//include MY_Controller

class Welcome extends CI_Controller {

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
            
            $this->form_validation->set_rules('username', 'Username', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required|callback_verify_password');

            if ($this->form_validation->run() == FALSE && !isset($this->session->userdata['logged_on']))
            {
                    echo form_open('welcome');
                    $this->data['validation'] = validation_errors();
                    $this->parser->parse('_logonform', $this->data);
                    
            }
            else
                {
                if (isset($this->session->userdata["logged_on"])) {
                    $this->data['username'] = $this->session->userdata["username"];
                } else {
                $this->session->set_userdata("logged_on", true);
                $this->data['username'] = $this->input->post('username');
                }

                $this->session->set_userdata("username", $this->data['username']);
                $this->data['stocksList'] = $this->getStocks();
                $this->data['playersList'] = $this->getPlayers();

                $session_info = $this->session->userdata('login_info');
                
                if($session_info['role']=='admin'){
//-----------------TODO: different homepage for admin-----------------------------------
                    $this->parser->parse('homepage', $this->data);
                }else{
                    $this->parser->parse('homepage', $this->data);
                }
                }
	}
        
        public function verify_password($password){
            
            $username = $this->input->post('username');
            
            $result = $this->players->login($username, $password);
            if($result){
                $sess_array = array();
                foreach($result as $row){
                    $sess_array = array(
                    'id'    => 1,
                    'name' => $username,
                    'isloggedin'=> 1,
                    'role'=>$row->role
                    );
                    $this->session->set_userdata('login_info', $sess_array);
                }
                return TRUE;
            }
            else{
                return false;
            }            
        }
        
        public function logout() {
            $this->session->unset_userdata('logged_on');
            $this->session->sess_destroy();
            $this->index();
        }
        
        public function getStocks() {
                //// Do it all over again for stocks
		// Get all stocks from model
		$result = $this->stocks->all();
		
		// Build array of formatted cells
		foreach ($result as $myrow){
			$cells[] = $this->parser->parse('_stocksCell', (array) $myrow, true);
                }
			
		// prime the table class
		$this->load->library('table');
		$parms = array(
			'table_open' => '<table class="gallery">',
			'cell_start' => '<td class="homepageCell">',
			'cell_alt_start' => '<td class="homepageCell">'
		);
		$this->table->set_template($parms);
		
		// Generate table (finally)
		$rows = $this->table->make_columns($cells, 1);
		return $this->table->generate($rows);
			
        }
        
        public function getPlayers() {
            		// Get all players from model
		$players = $this->players->all();
		
		// Build array of formatted cells
		foreach ($players as $playa)
			$cells[] = $this->parser->parse('_playerCell', (array) $playa, true);
			
		// prime the table class
		$this->load->library('table');
		$parms = array(
			'table_open' => '<table class="gallery">',
			'cell_start' => '<td class="homepageCell">',
			'cell_alt_start' => '<td class="homepageCell">'
		);
		$this->table->set_template($parms);
		
		// Generate table (finally)
		$rows = $this->table->make_columns($cells, 1);
		return $this->table->generate($rows);
        }

}
