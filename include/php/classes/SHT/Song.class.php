<?php
require_once('Object.class.php');

class Song extends Object
{
		var $SongID;
		var $Revision;
		var $Title;
		var $Description;
		var $Genre;
		var $Bitrate;
		var $Filepath;
		var $CreatorID;
		var $ModifierID;
		var $CreateDate;
		var $ModifyDate;
		var $_User;
		
  function Song($user = false)
  {
				$this->SongID = 0;
				$this->Revision = 0;
				$this->Title = '';
				$this->Description = '';
				$this->Genre = '';
				$this->Bitrate = '';
				$this->Filepath = '';
				$this->CreatorID = 0;
				$this->Modifier = 0;
				$this->CreateDate = '';
				$this->ModifyDate = '';
				
				if ($user)
						$this->_User = $user;
    
    parent::Object();
  }
  
  function Init($rs = false)
  {
				parent::Init($rs);
  }
  
  function Fetch($songId, $revision = false)
  {
				if ($songId == 0)
						return false;
				
				if (parent::IsConnected())
				{
						$whereClause = "SongID = $songId" . ($revision ? ",Revision = $revision" : '');
						
						$query = new SqlQueryBuilder('select');
						$query->setTable('Song');
						$query->addColumn('*');
						$query->setWhere($whereClause);

						$this->Init($this->Execute($query->buildQuery()));

						return ($this->SongID > 0) ? true : false;
				}
  }
		
  function Save($vd)
  {
  }
		
  function Validate($vd)
  {
		}

		// Retrieve all of the users songs (by CreatorID)
		function FetchUniqueSongsByUser()
		{
				if (!$this->_User)
				{
						echo "Fetch songs by user requires user object";
						return false;
				}
				
				if (parent::IsConnected())
				{
						$query = new SqlQueryBuilder('select');
						$query->setTable('Song');
						$query->addColumn('*');
						$query->setWhere(sprintf("CreatorID = %d AND Revision = 1", $this->_User->UserID));
						
						return $this->Execute($query->buildQuery());
				}
		}
}
?>