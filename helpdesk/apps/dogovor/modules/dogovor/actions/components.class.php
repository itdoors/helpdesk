<?php
class dogovorComponents extends sfComponents 
{
  static protected $addedDogovorIds = array();

  public function executeDopdogovors()
  {
    if (!$this->dogovor_id) return sfView::NONE;
    $this->dopdogovors = Doctrine::getTable('DopDogovor')->getDopDogovorsByDogovorId($this->dogovor_id);
  }
  
  public function executeDepartments_list()
  {
    if (!$this->dogovor_id) return sfView::NONE;
    $this->departments_list = DogovorDepartmentTable::getAllDepartments($this->dogovor_id);
  }

  public function executeHandlings()
  {
    $this->handlings = array();
  }

  public function executeHandling_added_list()
  {
    $this->handlings = Doctrine::getTable('Handling')
      ->createQuery('h')
      ->leftJoin('h.DogovorHandling dh')
      ->where('dh.dogovor_id = ?', $this->dogovorId)
      ->leftJoin('h.HandlingUser hu')
      ->leftJoin('h.Result hr')
      ->leftJoin('hu.User manager')
      ->leftJoin('h.Status status')
      ->execute();

    if (sizeof($this->handlings))
    {
      self::$addedDogovorIds = $this->handlings->getPrimaryKeys();
    }
  }

  public function executeHandling_for_add_list()
  {
    $query = Doctrine::getTable('Handling')
      ->createQuery('h')
      ->leftJoin('h.DogovorHandling dh')
      ->addWhere('h.organization_id = ?', $this->organizationId)
      ->leftJoin('h.HandlingUser hu')
      ->leftJoin('h.Result hr')
      ->leftJoin('hu.User manager')
      ->leftJoin('h.Status status');

    $soledId = HandlingResult::getIdBySlug('soled');

    if (!$soledId)
    {
      return sfView::NONE;
    }

    $query
      ->addWhere('h.result_id = ?', $soledId);

    //$notIn = Doctrine::getTable()

    if (sizeof(self::$addedDogovorIds))
    {
      $query
        ->whereNotIn('h.id', self::$addedDogovorIds);
    }

    $this->handlings = $query->execute();
  }
} 

