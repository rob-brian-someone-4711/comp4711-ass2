<?php
// My_Model - Brian Livesey A00896837

class MY_Model extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	
		function ImportCSV2Array($filename)
	{
		$row = 0;
		$col = 0;
	 
		$handle = @fopen($filename, "r");
		if ($handle) 
		{
			while (($row = fgetcsv($handle, 4096)) !== false) 
			{
				if (empty($fields)) 
				{
					$fields = $row;
					continue;
				}
	 
				foreach ($row as $k=>$value) 
				{
					$results[$col][$fields[$k]] = $value;
				}
				$col++;
				unset($row);
			}
			if (!feof($handle)) 
			{
				echo "Error: unexpected fgets() failn";
			}
			fclose($handle);
		}
	 
		if (isset($results)) {
			return $results;
		}
		else {
			return null;
		}
	}
}