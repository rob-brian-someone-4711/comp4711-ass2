<?php

/**
 * core/MY_Controller.php
 *
 * Default application controller
 *
 * @author		JLP
 * @copyright           2010-2013, James L. Parry
 * ------------------------------------------------------------------------
 */
class Application extends CI_Controller {

	protected $data = array();	  // parameters for view components
	protected $id;				  // identifier for our content

	/**
	 * Constructor.
	 * Establish view parameters & load common helpers
	 */

	function __construct()
	{
		parent::__construct();
		$this->data = array();
		$this->data['title'] = 'Stock Ticker';	// our default title
		$this->errors = array();
		$this->data['pageTitle'] = 'welcome';   // our default page
	}

	/**
	 * Render this page
	 */
	function render()
	{
		$this->data['menubar'] = $this->parser->parse('_menubar', $this->config->item('menu_choices'), true);
		$this->data['content'] = $this->parser->parse($this->data['pagebody'], $this->data, true);

                
                
                
                
                
                
                
                $this->data['header']  = $this->parser->parse('_header', $this->data, true);

                $this->data['left-panel']  = $this->parser->parse($this->data['_left-panel'], $this->data, true);
                $this->data['right-panel'] = $this->parser->parse($this->data['_right-panel'], $this->data, true);

                $this->data['content'] = $this->parser->parse('_content', $this->data, true);
                $this->data['footer']  = $this->parser->parse('_footer', $this->data, true);

                
                
                
                
                
                
                // finally, build the browser page!
                $this->data['data'] = &$this->data;
                $this->parser->parse('_template', $this->data);
	}

}

/* End of file MY_Controller.php */
/* Location: application/core/MY_Controller.php */