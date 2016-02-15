<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//include MY_Controller

class History extends CI_CONTROLLER {
    
    //Index page for this controller
    public function index() 
    {   
        if (isset($this->data['stockselection'])) {
            $stockname = $this->data['stockselection'];
        } else {
            //$stockname = $this->stocks->recent();
            $stockname = 'IND';
            }
        $this->data['stockname'] = $stockname;
        
        $this->data['stockselection'] = $this->buildDropdown();
        $this->data['transactions'] = $this->getTransactions($stockname);
        $this->data['movements'] = $this->getMovements($stockname);
        $this->parser->parse('history', $this->data);
    }
    
    //Generate page based on stock code/name passed in url
    public function stock($stockname){
        $this->data['stockname'] = $stockname;
        $this->data['stockselection'] = $this->buildDropdown();
        $this->data['transactions'] = $this->getTransactions($stockname);
        $this->data['movements'] = $this->getMovements($stockname);
        $this->parser->parse('history', $this->data);
    }
    
    //Generates drop down menu of stocks
    public function buildDropdown() {
        
        $this->load->helper('form');
        
        $stocks = $this->stocks->all();
        $options = array('pick' => '--Select-a-Stock--');
        foreach($stocks as $s) {
            $options[$s['Code']] = $s['Name'];
        }
        
        $choice = 'onchange="location = this.options[this.selectedIndex].value;"';
        
        return form_dropdown('stocks', $options, 'pick', $choice);
        
    }
    
    //Retreives transactions by stock from the db
    public function getTransactions($stockname) {
        //get transactions
        $result = $this->transactions->byStock($stockname);
        
        if($result == null) {
            $cells[0] = 'No Data';
        }

        // Build array of formatted cells
        foreach ($result as $myrow) {
            $cells[] = $this->parser->parse('_transactionsCell', (array) $myrow, true);
        }
        if($cells == null) {
                $cells[0] = 'No Data';
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
    
    //Retrieves the movements of a stock from the db
    public function getMovements($stockname) {
        //get movements
        $result = $this->movements->byStock($stockname);

        // Build array of formatted cells
        foreach ($result as $myrow)
            $cells[] = $this->parser->parse('_movementsCell', (array) $myrow, true);

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