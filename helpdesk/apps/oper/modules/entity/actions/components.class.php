<?php

class entityComponents extends sfComponents
{
  public function executeTechnical_params()
  {
    $this->types = TechnicalParamTypeTable::getInstance()
      ->createQuery()
      ->orderBy('sort ASC')
      ->execute();
    
    $params = TechnicalParamTable::getInstance()
      ->createQuery()
      ->orderBy('sort ASC')
      ->execute();
      
    $this->params_array = $this->getFormattedParams($params);
    
    $request = sfContext::getInstance()->getRequest();
    $department_id = $request->getParameter('department_id');
    
    $departments_params =  TechnicalParamDepartmentsTable::getInstance()
      ->createQuery('tpd')
      ->where('tpd.department_id = ?', $department_id)
      ->execute();
      
    $this->departments_params = $this->getFormattedDepartmentParams($departments_params);
  }
  
  public function executeDepartment_contact_list()
  {
    $department_id = $this->department_id;
    
    $this->contacts = ModelContactTable::getInstance()
      ->createQuery('mc')
      ->where('mc.model_name = ?', ModelContact::MODEL_DEPARTMENTS)
      ->addWhere('mc.model_id = ?', $department_id)
      ->execute();
  }
  
  public function getFormattedParams($params)
  {
    $return = array();
    
    foreach($params as $param)
    {
      if (!isset($return[$param->getTypeId()]))
      {
        $return[$param->getTypeId()] = array();
      }
      
      $return[$param->getTypeId()][] = $param;
    }
    
    return $return;
  }
  
  public function getFormattedDepartmentParams($lists)
  {
    $return = array();
    
    foreach ($lists as $list)
    {
      $return[$list->getParamId()] = $list;
    }
    
    return $return;
  }
  
  public function executeDocuments()
  {
    $department = $this->department; 
    $department_id = $department->getId(); 
    
    $dogovor_departments = DogovorDepartmentTable::getInstance()
      ->createQuery()
      ->where('department_id = ?', $department_id)
      ->execute();
      
    $dogovorIds = GlobalFunctions::getFormattedArrayDistinct($dogovor_departments, 'dogovor_id');
    $dop_dogovorIds = GlobalFunctions::getFormattedArrayDistinct($dogovor_departments, 'dop_dogovor_id');
    
    $this->dogovors = Doctrine_Core::getTable('Dogovor')->getDogovorsByIds($dogovorIds);     
    
    $dop_dogovors = Doctrine::getTable('DopDogovor')->getDopDogovorsByIds($dop_dogovorIds);
    
    $this->dop_dogovors = GlobalFunctions::getFormattedArrayObject($dop_dogovors, 'dogovor_id');
  }
  
  public function executePeople()
  {
    $department = $this->department; 
    $department_id = $department->getId(); 
    
    $stuff_departments = stuff_departmentsTable::getInstance()
      ->createQuery('sd')
      ->where('sd.departments_id =?',$department_id)
      ->leftJoin('sd.Stuff st')
      ->leftJoin('sd.Claimtype ct')
      ->execute();
      
    $return = array();
      
    foreach ($stuff_departments as $sd)
    {
      if (!isset($return[$sd->getStuffId()]))
      {
        $return[$sd->getStuffId()] = array(
          'fullname' => $sd->getStuff(),
          //'kurator' => array(),
          //'stuff' => array()
        );
      }
      
      $return[$sd->getStuffId()][$sd->getUserkey()][] = $sd->getClaimtype();
    }
    
    $this->result = $return;
  }
  
  public function executeGrafik()
  {
    $this->month = isset($this->month) ? $this->month : date('n');
    $this->year = isset($this->year) ? $this->year : date('Y');

    $this->last_day_of_the_month = Grafik::getDaysInMonth($this->year, $this->month);

    $this->canCopyToNetxtMonth = Grafik::canCopyToNextMonth($this->year, $this->month);
  }
  
  /*public function executePeople_list()
  {
    if (!$this->department_id)
    {
      return sfView::NONE;
    }

    $this->offset = 0;
    $this->limit = 5;

    $this->isRowRefresh = $this->department_people_id && !is_null($this->department_people_replacement_id);
    
    $app = sfContext::getInstance()->getConfiguration()->getApplication();
    
    $this->canEdit = $this->getUser()->hasCredential($app);

    $this->year = isset($this->year) ? $this->year : date('Y');
    $this->month = isset($this->month) ? $this->month : date('n');

    $yearSession = GlobalFunctions::getSessionVariable('year', GlobalFunctions::SESSION_NAMESACE__GRAFIK_ENTITY . $this->department_id);
    $monthSession = GlobalFunctions::getSessionVariable('month', GlobalFunctions::SESSION_NAMESACE__GRAFIK_ENTITY . $this->department_id);

    $this->year = $yearSession ? $yearSession : $this->year;
    $this->month = $monthSession ? $monthSession : $this->month;
    
    $this->days_count = date('t', mktime(0, 0, 0, $this->month, 1, $this->year));
    
    $this->peoples = Grafik::getPeople(
      $this->department_id,
      $this->year,
      $this->month,
      $this->department_people_id,
      $this->department_people_replacement_id
    );
    
    $this->canCopyToNetxtMonth = sizeof($this->peoples) && Grafik::canCopyToNextMonth($this->year, $this->month);

    // check if queue exist
    $objectModel = Queue::MODEL__GRAFIK;
    $params = array(
      'departmentId' => $this->department_id,
      'year' => $this->year,
      'month' => $this->month
    );

    $this->queue = Queue::getByModelAndId($objectModel, $params);
    // eof check if queue exist

    $this->grafik = Grafik::getFormattedData(
      $this->year,
      $this->month,
      $this->department_id,
      $this->department_people_id,
      $this->department_people_replacement_id
    );

    //add salary

    $this->salaryInfo = Salary::getMonthInfo($this->year, $this->month);
  }*/

  public function executePeople_list()
  {
    if (!$this->department_id)
    {
      return sfView::NONE;
    }

    $departmentIds = array($this->department_id);

    $this->offset = $this->offset ? $this->offset : 0;

    $this->limit = sfConfig::get('app_grafik_people_limit');

    $this->isRowRefresh = ($this->department_people_id && !is_null($this->department_people_replacement_id)) || $this->offset;
    $this->isOneRowRefresh = $this->department_people_id && !is_null($this->department_people_replacement_id);

    $app = sfContext::getInstance()->getConfiguration()->getApplication();
    $this->canEdit = $this->getUser()->hasCredential($app);
    $this->year = isset($this->year) ? $this->year : date('Y');
    $this->month = isset($this->month) ? $this->month : date('n');
    $yearSession = GlobalFunctions::getSessionVariable('year', GlobalFunctions::SESSION_NAMESACE__GRAFIK_ENTITY . $this->department_id);
    $monthSession = GlobalFunctions::getSessionVariable('month', GlobalFunctions::SESSION_NAMESACE__GRAFIK_ENTITY . $this->department_id);
    $this->year = $yearSession ? $yearSession : $this->year;
    $this->month = $monthSession ? $monthSession : $this->month;
    $this->days_count = date('t', mktime(0, 0, 0, $this->month, 1, $this->year));

    $peopleIds = GrafikTable::getPeopleIds(
      $departmentIds,
      $this->year,
      $this->month,
      $this->department_people_id,
      $this->department_people_replacement_id,
      $this->replacement_type,
      $this->offset,
      $this->limit
    );

    $this->peoples = Grafik::getPeopleByIds(
      $peopleIds,
      $this->year,
      $this->month,
      $this->department_people_id,
      $this->department_people_replacement_id,
      $this->replacement_type
    );

    $this->canCopyToNetxtMonth = sizeof($this->peoples) && Grafik::canCopyToNextMonth($this->year, $this->month);

    // eof check if queue exist

    $this->grafik = Grafik::getFormattedData(
      $this->year,
      $this->month,
      $this->department_id,
      $this->department_people_id,
      $this->department_people_replacement_id,
      $peopleIds
    );

    //add salary

    $this->salaryInfo = Salary::getMonthInfo($this->year, $this->month);
    $this->queue = null;
  }
  
  public function executeMonth_holder()
  {
    $options = array('department_id' => $this->department_id);
    
    $this->form = new MonthHolderForm(array(), $options);
  }
  
  public function executeGrafik_form()
  {
    $params = $this->params;

    $query = Doctrine::getTable('Grafik')
      ->createQuery('g')
      ->addWhere('year = ?', $params['year'])
      ->addWhere('month = ?', $params['month'])
      ->addWhere('day = ?', $params['day'])
      ->addWhere('department_id = ?', $params['department_id'])
      ->addWhere('department_people_id = ?', $params['department_people_id']);


    if (isset($params['department_people_replacement_id']))
    {
      $query
        ->addWhere('department_people_replacement_id = ?', $params['department_people_replacement_id']);
    }

    $this->grafik = $query->fetchOne();

    $grafik_form = new GrafikForm($this->grafik, array(
      'month_ui' => $params['month'],
      'year_ui' => $params['year']
    ));

    if (!$this->grafik)
    {
      //$grafik_form->bind($params);
      $grafik_form->setDefaults($params);
    }

    $this->grafik_form = $grafik_form;
  }
  
  public function executeFilters()
  {
    $i18n = sfContext::getInstance()->getI18N();

  }

  public function executeGrafik_day_list()
  {
    $params = $this->params;

    $this->grafiks = Doctrine::getTable('GrafikTime')
      ->createQuery('g')
      ->addWhere('year = ?', $params['year'])
      ->addWhere('month = ?', $params['month'])
      ->addWhere('day = ?', $params['day'])
      ->addWhere('department_id = ?', $params['department_id'])
      ->addWhere('department_people_id = ?', $params['department_people_id'])
      ->addWhere('department_people_replacement_id = ?', $params['department_people_replacement_id'])
      ->orderBy('from_time ASC')
      ->execute();
  }

  public function executeDepartment_people_holder()
  {

  }

  public function executeDepartment_people_list()
  {
    $query = Doctrine::getTable('DepartmentPeople')
      ->createQuery('dp')
      ->leftJoin('dp.Individual i')
      ->where('dp.parent_id is null')
      ->andWhere('dp.department_id = ?', $this->department->getId())
      ->offset($this->offset)
      ->limit($this->limit);

    switch ($this->lastRecord)
    {
      case 1:
        $query
          ->orderBy('dp.id DESC')
          ->limit(1);
        break;
      case 0:
        $query
          ->orderBy('i.last_name ASC');
        break;
    }

    $this->departmentPeople = $query->execute();

    if (!$this->isShowMore)
    {
      $this->offset += $this->limit;
    }

    $this->departmentId = $this->department->getId();
  }
}

