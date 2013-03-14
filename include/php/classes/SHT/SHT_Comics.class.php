<?php
require_once('SHT_Object.class.php');

class SHT_Comics extends SHT_Object
{
	var $ComicID;
	var $ComicTitle; // Might be in the comic image.
	var $ComicPath;
	var $CreatorID;
	var $CreateDate;
	var $LastModified;
	var $DisplayDate;
	
	function SHT_Comics()
	{
			$this->ComicID = 0;
			$this->ComicTitle = '';
			$this->ComicPath = '';
			$this->CreatorID = 0;
			$this->CreateDate = '';
			$this->LastModified = '';
			$this->DisplayDate = '';
			
			parent::SHT_Object();
	}

	function Init($rs = false)
	{
			parent::Init($rs);
	}

	function Fetch()
	{
	}

 function FetchAllComics($userId = 0)
 {
   if (parent::IsConnected())
			{
							if ($userId == 0)
									$query = "select * from Comics order by CreateDate desc;";
     else
       $query = "select * from Comics where CreatorID = $userId order by CreateDate desc;";

							return $this->Execute($query);
			}
 }

	function Save($vd)
	{
	}

	function Validate($vd)
	{
	}
}
?>