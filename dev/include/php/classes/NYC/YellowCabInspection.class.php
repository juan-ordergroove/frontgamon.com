<?php
require_once('Object.class.php');

class YellowCabInspection extends Object
{
  var $ID;
  var $MedNumber;
  var $ScheduleDate;
  var $ScheduleTime;
  var $FleetAgentCode;

  function YellowCabInspection()
  {
    $this->ID = 0;
    $this->MedNumber = '';
    $this->ScheduleDate = '';
    $this->ScheduleTime = '';
    $this->FleetAgentCode = 0;

    parent::Object();
  }

  function Init($rs = false)
  {
    parent::Init($rs);
  }

  function Save($vd)
  {
    $bNewYellowCabInspection = false;

    if ($this->ID == 0)
      $bNewYellowCabInspection = true;

    if ($this->Validate($vd))
    {
      $sql = new SQLQueryBuilder(($bNewYellowCabInspection) ? 'insert' : 'update');
      $sql->SetTable("YellowCabInspection");
      
      $sql->addColumn('MedNumber');
      $sql->addColumn('ScheduleDate');
      $sql->addColumn('ScheduleTime');
      $sql->addColumn('FleetAgentCode');

      $sql->setValue($this->MedNumber);
      $sql->setValue($this->ScheduleDate);
      $sql->setValue($this->ScheduleTime);
      $sql->setValue($this->FleetAgentCode);

      if ($bNewYellowCabInspection)
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
    // TODO: Need to properly validate for future UI

    return !$vd->HasErrors();
  }
}
?>
