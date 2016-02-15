<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//include MY_Controller

class Portfolio extends CI_Controller {

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
            if (isset($this->session->userdata["logged_on"])) {
                    $pname = $this->session->userdata["username"];
                } else {
                    $pname = 'Donald';
                }
            $this->data['playername'] = $pname;
            $this->data['playerSelection'] = $this->generateDropdownMenu();
            $this->data['cash'] = $this->getPlayerCash($pname);
            $holdings = $this->getStockAmount($pname);
            $this->data['holdings'] = $holdings;
            $this->data['transactions'] = $this->getTransactions($pname);         
            
            $this->parser->parse('portfolio', $this->data); 
	}     
        
        //Generate page based on player name passed in url
        public function user($pname){
            $this->data['playername'] = $pname;
            $this->data['playerSelection'] = $this->generateDropdownMenu();
            $this->data['cash'] = $this->getPlayerCash($pname);
            $holdings = $this->getStockAmount($pname);
            $this->data['holdings'] = $holdings;
            $transactions = $this->getTransactions($pname);
            $this->data['transactions'] = $transactions;
            
            $this->parser->parse('portfolio', $this->data);
        }
        
        //Generates drop down menu of players
        public function generateDropdownMenu(){   
            $playerNames = $this->players->getnames();
            $this->load->helper('form');
            
            $options = array('pick' => '--Select-a-Player--');
            foreach($playerNames as $curname){
            $options[$curname['Player']] = $curname['Player'];                
            }
            
            $js = 'onchange="location = this.options[this.selectedIndex].value;"';
            
            return form_dropdown('players', $options, 'pick', $js);
        }
        
        //Get amount of each stock
        public function getStockAmount($pname) {
                //get transactions
		$result = $this->transactions->amountByPlayer($pname);
                
                if ($result == NULL){
                    return 'none';
                }
                
		
		// Build array of formatted cells
		foreach ($result as $myrow)
			$cells[] = $this->parser->parse('_playerStockAmountCell', (array) $myrow, true);
			
                
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

        //Get list of player's transactions by date
        public function getTransactions($pname){
                //get transactions
		$result = $this->transactions->byPlayer($pname);
                
                if ($result == NULL){
                    return 'none';
                }
		
		// Build array of formatted cells
		foreach ($result as $myrow)
			$cells[] = $this->parser->parse('_transactionsCell', (array) $myrow, true);
			
                
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
        
        //Get player's current cash
        public function getPlayerCash($pname){
		$players = $this->players->get($pname);		
                return $players;
        }

}
