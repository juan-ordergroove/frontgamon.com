<?php
require_once('Object.class.php');

class FHVDriver extends Object
{
  var $ID;
  var $LicenseNumber;
  var $LicenseeName;
  var $LicenseType;
  var $LicenseExpirationDate;

  function FHVDriver()
  {
   	$this->ID = 0;
				$this->LicenseNumber = '';
				$this->LicenseeName = '';
    $this->LicenseType = '';
    $this->LicenseExpirationDate = '';

		parent::Object();
  }
		
  function Init($rs = false)
  {
  	parent::Init($rs);
  }

  function Save($vd)
  {
    $bNewDriver = false;

    if ($this->ID == 0)
      $bNewDriver = true;

    if ($this->Validate($vd))
    {
      $sql = new SQLQueryBuilder(($bNewDriver) ? 'insert' : 'update');
      $sql->SetTable("FHVDriver");

      $sql->AddColumn('LicenseNumber');
      $sql->AddColumn('LicenseeName');
      $sql->AddColumn('LicenseType');
      $sql->AddColumn('LicenseExpirationDate');

      $sql->setValue($this->LicenseNumber);
      $sql->setValue($this->LicenseeName);
      $sql->setValue($this->LicenseType);
      $sql->setValue($this->LicenseExpirationDate);

      if ($bNewDriver)
      {
      }
      else
        $sql->setWhere(sprintf("ID=%d", $this->ID));

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

  function Validate($vd)
  {
    return !$vd->HasErrors();
  }
}
?>
