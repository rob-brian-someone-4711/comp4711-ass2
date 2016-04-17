<?php

class Status extends CI_Model {
    protected $xml;
    
    public function __construct() {
        $this->xml = simplexml_load_file(BSX . 'status');
		//  $this->xml = simplexml_load_file('http://bsx.jlparry.com/status');
	}
		
	public function all() {
		$result = array();
		foreach($this->xml as $key => $val) {
			$result[$key] = $val;
		}
		return $result;
	}
}