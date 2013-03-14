<?php
require_once('ObjectMapper.class.php');

require_once(PHP_DEV . 'lib/ValidateData.class.php');

require_once(PHP_DEV . 'lib/SqlQueryBuilder.class.php');

class ParentObject extends ObjectMapper
{
		function ParentObject($nameSpace, $dbName = '')
		{
				parent::ObjectMapper($nameSpace, $dbName);
		}

		function Init($rs = false)
		{
				parent::MapToObject($rs);
		}
}
?>