<?php
require_once ('SHT_Object.class.php');

class SHT_News extends SHT_Object
{
	var $NewsID;
	var $NewsHeader;
	var $NewsContent;
	var $CreatorID;
	var $CreateDate;
	var $LastModified;
	var $DisplayDate;
	
	function SHT_News()
	{
		$this->NewsID = 0;
		$this->NewsHeader = '';
		$this->NewsContent = '';
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

	function Delete()
	{
			if ($this->NewsID == 0)
					return false;
			

			if (parent::IsConnected())
			{
					$query = new SqlQueryBuilder('delete');
					$query->setTable('News');
					$query->setWhere("NewsID = $this->NewsID");
					
					return $this->Execute($query->buildQuery());
			}
	}

	function Fetch($newsId)
	{
			if ($newsId == 0)
					return false;
			
			if (parent::IsConnected())
		 {
					$query = new SqlQueryBuilder('select');
					$query->setTable('News');
					$query->addColumn('*');
					$query->setWhere("NewsID = $newsId");

					return $this->Execute($query->buildQuery());
			}
	}

	function FetchAllNews($userId = 0)
	{
			if (parent::IsConnected())
			{
					if ($userId == 0)
							$query = "select * from News order by CreateDate desc;";
					else
							$query = "select * from News where CreatorID = $userId order by CreateDate desc;";
					
					return $this->Execute($query);
			}
	}

	function Validate($vd)
	{
		if (!strlen($this->NewsHeader))
			$vd->errors['NewsHeader'] = "You must include a news header.";
		
		if (!strlen($this->NewsContent))
			$vd->errors['NewsContent'] = "You must include news content.";
		
		if (!$this->CreatorID)
			$vd->errors['CreatorID'] = "A user must have created this item.";
		
		if (!strlen($this->DisplayDate))
			$vd->errors['DisplayDate'] = "There must be a date of creation attached to a news item.";
		
		return !$vd->HasErrors();
	}

	function Save($vd)
	{
		$bNewNews = false;
		
		if ($this->NewsID == 0)
			$bNewNews = true;

		if ($this->Validate($vd))
		{
			$sql = new SqlQueryBuilder(($bNewNews) ? 'insert' : 'update');
			$sql->SetTable("News");
			
			$sql->addColumn("NewsHeader");
			$sql->setValue($this->NewsHeader);
			
			$sql->addColumn("NewsContent");
			$sql->setValue($this->NewsContent);
			
			$sql->addColumn("LastModified");
			$sql->setValue("NOW()");

			if ($bNewNews)
			{
				$sql->addColumn("CreatorID");
				$sql->SetValue($this->CreatorID);
				
				$sql->addColumn("CreateDate");
				$sql->setValue("NOW()");

				$sql->addColumn("DisplayDate");
				$sql->setValue($this->DisplayDate);
			}
			else
				$sql->setWhere("NewsID=" . $this->NewsID);
			
			$query = $sql->buildQuery();
			
			if (!$this->Execute($query))
			{
				new Dump($this->ErrorMsg());
				return false;
			}
			else
				return true;
		}
		
		return !$vd->HasErrors();
	}
}
?>