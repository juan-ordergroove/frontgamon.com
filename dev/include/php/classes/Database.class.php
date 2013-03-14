<?php
require_once(ADODB_DEV . 'adodb.inc.php');

require_once(PHP_DEV . 'lib/StringToolbox.class.php');

class Database
{
	private $_db_host;
	private $_db_username;
	private $_db_password;
	private $_db_table;
	private $_DB;
	
	function Database($db_table = '', $db_host = '', $db_username = '', $db_password = '')
	{
		if (!strlen($db_host))
			$db_host = 'localhost';
		if (!strlen($db_username))
			$db_username = 'jgutierrez';
		if (!strlen($db_password))
			$db_password = 'fa11rain';
		if (!strlen($db_table))
			$db_table = 'StupidHumanTricks';
		
		$this->_db_host = $db_host;
		$this->_db_username = $db_username;
		$this->_db_password = $db_password;
		$this->_db_table = $db_table;

		return $this->Connect();
	}

	function Connect()
	{
		$this->_DB = ADONewConnection('mysqli');
		
		if (!$this->_DB)
		{
			sprintf('Could not connect: %s', mysql_error());
			return false;
		}

		// Uncomment to turn errors on.
		// $this->_DB->debug = true;
		return $this->_DB->Connect($this->_db_host, $this->_db_username, $this->_db_password, $this->_db_table);
	}

	function Close()
	{
		$this->_DB->Close();
	}

	function IsConnected()
	{
		if ($this->_DB)
			return $this->_DB->IsConnected();
	}

	function PrepareString($str)
	{
		return $this->_DB->QMagic($str);
	}

	function ErrorMsg()
	{
		return $this->_DB->ErrorMsg();
	}

	function &Execute($query)
	{
		if (!$this->_DB)
			$this->Connect();

		return $this->_DB->Execute($query);
	}
}
?>