<?php
require_once('Object.class.php');

class YellowCabDriversMedallion extends Object
{
  var $ID;
		var $MedNumber;
		var $MedOwnerName;
		var $TLCDriverLicenseNumber;
		var $DriverName;
		var $LeaseStartDate;
		var $LeaseEndDate;
		var $TLCDriverLicenseExpirationDate;

  function YellowCabDriversMedallion()
  {
				$this->ID = 0;
				$this->MedNumber = '';
				$this->MedOwnerName = '';
				$this->TLCDriverLicenseNumber = '';
				$this->DriverName = '';
				$this->LeaseStartDate = '';
				$this->LeaseEndDate = '';
				$this->TLCDriverLicenseExpirationDate = '';

				parent::Object();
  }
		
  function Init($rs = false)
  {
				parent::Init($rs);
  }

		function Save($vd)
		{
				$bNewMedallion = false;

				if ($this->ID == 0)
						$bNewMedallion = true;

				if ($this->Validate($vd))
				{
						$sql = new SqlQueryBuilder(($bNewMedallion) ? 'insert' : 'update');
						$sql->SetTable("YellowCabDriversMedallion");
						
						$sql->addColumn('MedNumber');
						$sql->addColumn('MedOwnerName');
						$sql->addColumn('TLCDriverLicenseNumber');
						$sql->addColumn('DriverName');
						$sql->addColumn('LeaseStartDate');
						$sql->addColumn('LeaseEndDate');
						$sql->addColumn('TLCDriverLicenseExpirationDate');

						$sql->setValue($this->MedNumber);
						$sql->setValue($this->MedOwnerName);
						$sql->setValue($this->TLCDriverLicenseNumber);
						$sql->setValue($this->DriverName);
						$sql->setValue($this->LeaseStartDate);
						$sql->setValue($this->LeasEndDate);
						$sql->setValue($this->TLCDriverLicenseExpirationDate);
						
						if ($bNewMedallion)
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
		
		function InfoByMedallionWithoutAgentNumber($medNumber)
		{
				$tablesToJoin = array(
				  'YellowCabMedallion',
						'YellowCabDriversMedallion',
						'YellowCabMedallionDriver',
				);

				$columns = array(
				  'YellowCabDriversMedallion.TLCDriverLicenseNumber AS DriverLicenseNumber',
						'YellowCabDriversMedallion.DriverName AS DriverName',
						'YellowCabDriversMedallion.TLCDriverLicenseExpirationDate as DriverLicenseExpirationDate',
						'YellowCabMedallion.NameOfLicensee AS NameOfLicensee',
						'YellowCabMedallion.VIN AS VIN',
				);
				
				$whereClause = sprintf('YellowCabMedallion.LicenseNumber LIKE "%s"', $medNumber);
				$whereClause = sprintf('%s AND YellowCabDriversMedallion.MedNumber = YellowCabMedallion.LicenseNumber', $whereClause);
				$whereClause = sprintf('%s AND YellowCabDriversMedallion.TLCDriverLicenseNumber = YellowCabMedallionDriver.LicenseNumber', $whereClause);

				$sql = new SqlQueryBuilder('select');
				$sql->SetTable(implode(' INNER JOIN ', $tablesToJoin));
				foreach ($columns as $column)
						$sql->addColumn($column);
				$sql->setWhere($whereClause);

				$query = $sql->buildQuery();
				$rs = $this->Execute($query);

				return $rs;
		}
		
		function LimitedInfoByMedallionWithAgentNumber($medNumber)
		{
				$tablesToJoin = array(
						'YellowCabMedallion',
						'YellowCabMedallionLicenseType',
				);

				$columns = array(
					 'YellowCabMedallion.NameOfLicensee AS NameOfLicensee',
						'YellowCabMedallion.VIN AS VIN',
						'YellowCabMedallionLicenseType.NameOfLicensee AS AgentLicensee',
						'YellowCabMedallionLicenseType.StreetAddress AS AgentStreetAddress',
						'YellowCabMedallionLicenseType.City AS AgentCity',
						'YellowCabMedallionLicenseType.State AS AgentState',
						'YellowCabMedallionLicenseType.ZipCode AS AgentZipCode',
						'YellowCabMedallionLicenseType.Telephone AS AgentTelephone',
						'YellowCabMedallionLicenseType.LicenseType AS AgentType',
				);

				$whereClause = sprintf('YellowCabMedallion.LicenseNumber LIKE "%s"', $medNumber);
				$whereClause = sprintf('%s AND YellowCabMedallionLicenseType.MedallionAgentNumber = YellowCabMedallion.MedallionAgentNumber', $whereClause);

				$sql = new SqlQueryBuilder('select');
				$sql->SetTable(implode(' INNER JOIN ', $tablesToJoin));
				foreach ($columns as $column)
						$sql->addColumn($column);
				$sql->setWhere($whereClause);

				$query = $sql->buildQuery();
				$rs = $this->Execute($query);

				return $rs;
		}

		/*
			SELECT 
			YellowCabDriversMedallion.MedOwnerName AS MedallionOwnerName,
			YellowCabDriversMedallion.TLCDriverLicenseNumber AS DriverLicenseNumber,
			YellowCabDriversMedallion.DriverName AS DriverName,
			YellowCabDriversMedallion.TLCDriverLicenseExpirationDate as DriverLicenseExpirationDate,
			YellowCabMedallion.NameOfLicensee AS NameOfLicensee,
			YellowCabMedallion.VIN AS VIN,
			YellowCabMedallionLicenseType.NameOfLicensee AS AgentLicensee,
			YellowCabMedallionLicenseType.StreetAddress AS AgentStreetAddress,
			YellowCabMedallionLicenseType.City AS AgentCity,
			YellowCabMedallionLicenseType.State AS AgentState,
			YellowCabMedallionLicenseType.ZipCode AS AgentZipCode,
			YellowCabMedallionLicenseType.Telephone AS AgentTelephone,
			YellowCabMedallionLicenseType.LicenseType AS AgentType
			FROM YellowCabDriversMedallion
			INNER JOIN YellowCabMedallion
			INNER JOIN YellowCabMedallionDriver
			INNER JOIN YellowCabMedallionLicenseType
			WHERE YellowCabDriversMedallion.MedNumber =  "1A14"
			AND YellowCabDriversMedallion.MedNumber = YellowCabMedallion.LicenseNumber
			AND YellowCabDriversMedallion.TLCDriverLicenseNumber = YellowCabMedallionDriver.LicenseNumber
			AND YellowCabMedallion.MedallionAgentNumber = YellowCabMedallionLicenseType.MedallionAgentNumber
		*/
		function InfoByMedallionWithAgentNumber($medNumber)
		{
				if (!strlen($medNumber))
						return false;

				$tablesToJoin = array(
								'YellowCabMedallion', 
								'YellowCabDriversMedallion', 
								'YellowCabMedallionDriver', 
								'YellowCabMedallionLicenseType',
		  );
				
				$columns = array(
				  'YellowCabDriversMedallion.TLCDriverLicenseNumber AS DriverLicenseNumber',
						'YellowCabDriversMedallion.DriverName AS DriverName',
						'YellowCabDriversMedallion.TLCDriverLicenseExpirationDate as DriverLicenseExpirationDate',
						'YellowCabMedallion.NameOfLicensee AS NameOfLicensee',
						'YellowCabMedallion.VIN AS VIN',
						'YellowCabMedallionLicenseType.NameOfLicensee AS AgentLicensee',
						'YellowCabMedallionLicenseType.StreetAddress AS AgentStreetAddress',
						'YellowCabMedallionLicenseType.City AS AgentCity',
						'YellowCabMedallionLicenseType.State AS AgentState',
						'YellowCabMedallionLicenseType.ZipCode AS AgentZipCode',
						'YellowCabMedallionLicenseType.Telephone AS AgentTelephone',
						'YellowCabMedallionLicenseType.LicenseType AS AgentType',
				);
				
				$whereClause = sprintf('YellowCabMedallion.LicenseNumber LIKE "%s"', $medNumber);
				$whereClause = sprintf('%s AND YellowCabDriversMedallion.MedNumber = YellowCabMedallion.LicenseNumber', $whereClause);
				$whereClause = sprintf('%s AND YellowCabDriversMedallion.TLCDriverLicenseNumber = YellowCabMedallionDriver.LicenseNumber', $whereClause);
				$whereClause = sprintf('%s AND YellowCabMedallion.MedallionAgentNumber = YellowCabMedallionLicenseType.MedallionAgentNumber', $whereClause);
				
				$sql = new SqlQueryBuilder('select');
				$sql->SetTable(implode(' INNER JOIN ', $tablesToJoin));
				foreach ($columns as $column)
						$sql->addColumn($column);
				$sql->setWhere($whereClause);
				
				$query = $sql->buildQuery();				
				$rs = $this->Execute($query);
				
				return $rs;
		}
}
?>