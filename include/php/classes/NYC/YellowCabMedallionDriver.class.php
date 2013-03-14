<?php
require_once('Object.class.php');

class YellowCabMedallionDriver extends Object
{
  var $ID;
		var $LicenseNumber;
		var $NameOfLicensee;
		var $LicenseType;
		var $LicenseExpirationDate;
		var $CompletedTraining;
		
  function YellowCabMedallionDriver()
  {
				$this->ID = 0;
				$this->LicenseNumber = '';
				$this->NameOfLicensee = '';
				$this->LicenseType = '';
				$this->LicenseExpirationDate = '';
				$this->CompletedTraining = 'NO';
				
				parent::Object();
  }
		
  function Init($rs = false)
  {
				parent::Init($rs);
  }
		
		function Save($vd)
		{
				$bNewMedallionDriver = false;
				
				if ($this->ID == 0)
						$bNewMedallionDriver = true;

				if ($this->Validate($vd))
				{
						$sql = new SqlQueryBuilder(($bNewMedallionDriver) ? 'insert' : 'update');
						$sql->SetTable("YellowCabMedallionDriver");
						
						$sql->addColumn('LicenseNumber');
						$sql->addColumn('NameOfLicensee');
						$sql->addColumn('LicenseType');
						$sql->addColumn('LicenseExpirationDate');
						$sql->addColumn('CompletedTraining');

						$sql->setValue($this->LicenseNumber);
						$sql->setValue($this->NameOfLicensee);
						$sql->setValue($this->LicenseType);
						$sql->setValue($this->LicenseExpirationDate);
						$sql->setValue($this->CompletedTraining);
						
						if ($bNewMedallionDriver)
						{
						}
						else
								$sql->setWhere('ID=' . $this->ID);
						
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
				// TODO: Need to properly validate for future UI
				
				return !$vd->HasErrors();
		}
}
?>