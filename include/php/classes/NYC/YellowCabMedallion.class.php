<?php
require_once('Object.class.php');

class YellowCabMedallion extends Object
{
  var $ID;
		var $LicenseNumber;
		var $NameOfLicensee;
		var $LicenseType;
		var $DriverRecordStatus;
		var $DMVLicensePlate;
		var $VIN;
		var $VehicleType;
		var $ModelYear;
		var $TypeOfMedallion;
		var $MedallionAgentNumber;
		
  function YellowCabMedallion()
  {
				$this->ID = 0;
				$this->LicenseNumber = '';
				$this->NameOfLicensee = '';
				$this->LicenseType = '';
				$this->DriverRecordStatus = '';
				$this->DMVLicensePlate = '';
				$this->VIN = '';
				$this->VehicleType = '';
				$this->ModelYear = 0;
				$this->TypeOfMedallion = '';
				$this->MedallionAgentNumber = '';

				parent::Object();
  }
		
  function Init($rs = false)
  {
				parent::Init($rs);
  }
		
		function Save($vd)
		{
				$bNewAgent = false;
				
				if ($this->ID == 0)
						$bNewAgent = true;

				if ($this->Validate($vd))
				{
						$sql = new SqlQueryBuilder(($bNewAgent) ? 'insert' : 'update');
						$sql->SetTable("YellowCabMedallion");
						
						$sql->addColumn('LicenseNumber');
						$sql->addColumn('NameOfLicensee');
						$sql->addColumn('LicenseType');
						$sql->addColumn('DriverRecordStatus');
						$sql->addColumn('DMVLicensePlate');
						$sql->addColumn('VIN');
						$sql->addColumn('VehicleType');
						$sql->addColumn('ModelYear');
						$sql->addColumn('TypeOfMedallion');
						$sql->addColumn('MedallionAgentNumber');

						$sql->setValue($this->LicenseNumber);
						$sql->setValue($this->NameOfLicensee);
						$sql->setValue($this->LicenseType);
						$sql->setValue($this->DriverRecordStatus);
						$sql->setValue($this->DMVLicensePlate);
						$sql->setValue($this->VIN);
						$sql->setValue($this->VehicleType);
						$sql->setValue($this->ModelYear);
						$sql->setValue($this->TypeOfMedallion);
						$sql->setValue($this->MedallionAgentNumber);
						
						if ($bNewAgent)
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