<?php
require_once('ObjectMapper.class.php');

require_once(PHP_LIVE . 'lib/ValidateData.class.php');

require_once(PHP_LIVE . 'lib/SqlQueryBuilder.class.php');

class Object extends ObjectMapper
{
		function Object($nameSpace, $dbName = '')
		{
				parent::ObjectMapper($nameSpace, $dbName);
		}

	function Init($rs = false)
	{
			parent::MapToObject($rs);
	}
}
?>