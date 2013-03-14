<?php
require_once('Object.class.php');

class YellowCabMedallionLicenseType extends Object
{
  var $ID;
		var $LicenseNumber;
		var $MedallionAgentNumber;
		var $NameOfLicensee;
		var $StreetAddress;
		var $City;
		var $State;
		var $ZipCode;
		var $Telephone;
		var $LicenseType;
		
  function YellowCabMedallionLicenseType()
  {
				$this->ID = 0;
				$this->LicenseNumber = '';
				$this->MedallionAgentNumber = 0;
				$this->NameOfLicensee = '';
				$this->StreetAddress = '';
				$this->City = '';
				$this->State = '';
				$this->ZipCode = '';
				$this->Telephone = '';
				$this->LicenseType = '';

				parent::Object();
  }
		
  function Init($rs = false)
  {
				parent::Init($rs);
  }
		
		function Save($vd)
		{
				$bNewLicenseType = false;
				
				if ($this->ID == 0)
						$bNewLicenseType = true;

				if ($this->Validate($vd))
				{
						$sql = new SqlQueryBuilder(($bNewLicenseType) ? 'insert' : 'update');
						$sql->SetTable("YellowCabMedallionLicenseType");
						
						$sql->addColumn('LicenseNumber');
						$sql->addColumn('MedallionAgentNumber');
						$sql->addColumn('NameOfLicensee');
						$sql->addColumn('StreetAddress');
						$sql->addColumn('City');
						$sql->addColumn('State');
						$sql->addColumn('ZipCode');
						$sql->addColumn('Telephone');
						$sql->addColumn('LicenseType');

						$sql->setValue($this->LicenseNumber);
						$sql->setValue($this->MedallionAgentNumber);
						$sql->setValue($this->NameOfLicensee);
						$sql->setValue($this->StreetAddress);
						$sql->setValue($this->City);
						$sql->setValue($this->State);
						$sql->setValue($this->ZipCode);
						$sql->setValue($this->Telephone);
						$sql->setValue($this->LicenseType);
						
						if ($bNewLicenseType)
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

		function ConvertLicenseNumberToMedallionAgentNumber()
		{
				if (!strlen($this->LicenseNumber))
						return 0;
				
				$medallionAgentNumber = '';
				foreach (preg_split('//', $this->LicenseNumber, -1, PREG_SPLIT_NO_EMPTY) as $ch)
				{
						if (is_numeric($ch))
								$medallionAgentNumber .= $ch;
				}
				
				$this->MedallionAgentNumber = intval($medallionAgentNumber);
		}
}
?>