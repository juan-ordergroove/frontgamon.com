<?php
class ValidateData
{
	var $errors;
	var $hasErrors;
	
	function ValidateData()
	{
		$this->errors = array();
	}

	function HasErrors()
	{
		return (count($this->errors) > 0);
	}
}
?>