<?php

/**
 * entity actions.
 *
 * @package    helpdesk
 * @subpackage entity
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class entityActions extends sfActions
{
  public function preExecute()
  {
    sfContext::getInstance()->getConfiguration()->loadHelpers('Url');
  }
  
  /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $page = $request->getParameter('page', 1);
    
    $limit = 30;

    $departments_query = departmentsTable::getMyDepartmentsQuery();
    
    $this->processQuery($departments_query, $request);
    
    $pager = new Doctrine_Pager(
       $departments_query,
       $page, 
       $limit
     );
    
    $app = sfContext::getInstance()->getConfiguration()->getApplication();
    
    $this->canEdit = $this->getUser()->hasCredential($app);
    
    $this->departments = $pager->execute(); 
    
    $this->pager = $pager;
    
    $this->pager->links = $this->getLinks($page, $this->pager->getLastPage());
    
    //filters
    $this->processFilters($request);
    
    $this->filters = $this->getFilters();
    
    $this->sort = $this->getSort();
  }
  
  public function getSort()
  {
    return $this->getUser()->getAttribute('entity.sort', array());
  }
  
  public function processQuery($query, sfWebRequest $request)
  {
    $filters = $this->getFilters();

    if (sizeof($filters))
    {

      foreach($filters as $key => $value)
      {
        if (!$value)
        {
          continue;
        }
        switch($key)
        {
          case 'mpk':
            $query->addWhere($query->getRootAlias().'.mpk LIKE ?', $value.'%');
            break;
          case 'organization_id':
            $query->addWhere($query->getRootAlias().'.organization_id = ?', $value);
            break;
          case 'region_id':
            $query->addWhere('region.id = ?', $value);
            break;
          case 'city_id':
            $query->addWhere('city.id = ?', $value);
            break; 
          case 'address':
            $query->addWhere($query->getRootAlias().'.address LIKE ?', '%'.$value.'%');
            break;
          case 'companystructure_id':
            $query->leftJoin('region.companystructure_region as companystructure_region');
            $query->addWhere('companystructure_region.companystructure_id = ?', $value);
            break;
          case 'status_id':
            $query->addWhere($query->getRootAlias().'.status_id = ?', $value);
            break;
          case 'departments_type_id':
            $query->addWhere($query->getRootAlias().'.departments_type_id = ?', $value);
            break;
        }
      }
    }
    
    $sort = $this->getSort();

    foreach($sort as $key => $value)
    {
      if (!$value)
      {
        continue;
      }
      
      $sort_order = $value == 'DESC' ? 'DESC' : 'ASC';
                    
      switch($key) {
        case 'mpk':
          $query->orderBy($query->getRootAlias().'.mpk '. $sort_order);
          break;
        case 'city':
          $query->orderBy('city.name '. $sort_order);
          break;
        case 'organization':
          $query->orderBy('organization.name '. $sort_order);
          break;
        case 'region':
          $query->orderBy('region.name '. $sort_order);
          break;
        case 'status':
          $query->orderBy('Status.name '. $sort_order);
          break; 
        case 'type':
          $query->orderBy('DepartmentsType.name '. $sort_order);
          break;
      }

      $query->addOrderBy('d.id', 'ACS');
    }
  }
  
  public function executeFilter(sfWebRequest $request)
  {
    $this->filter_form = new EntityFormFilter();

    $params = $request->getParameter($this->filter_form->getName());

    $this->getUser()->setAttribute('entity.filters', $params);

    $this->redirect(url_for('entity/index'));
  }
  
  public function executeClear_filter(sfWebRequest $request)
  {
    $this->getUser()->getAttributeHolder()->remove('entity.filters');
    $this->getUser()->getAttributeHolder()->remove('entity.sort');

    $this->redirect(url_for('entity/index'));
  }
  
  public function processFilters(sfWebRequest $request)
  {
    $this->filter_form = new EntityFormFilter();

    $params = $this->getFilters();

    if (sizeof($params))
    {
      $this->filter_form->bind($params);
    }
  }
  
  public function getFilters()
  {
    return $this->getUser()->getAttribute('entity.filters');
  }
  
  public function executeSort(sfWebrequest $request)
  {
    $sort_field = $request->getParameter('sort_field');
    $sort_type = $request->getParameter('sort_type');

    $sort = array($sort_field => $sort_type);

    $this->getUser()->setAttribute('entity.sort', $sort);

    $this->redirect(url_for('entity/index'));
  }
  
  public function getLinks($page, $last_page, $nb_links = 25)
  {
    $links = array();
    $tmp   = $page - floor($nb_links / 2);
    $check = $last_page - $nb_links + 1;
    $limit = $check > 0 ? $check : 1;
    $begin = $tmp > 0 ? ($tmp > $limit ? $limit : $tmp) : 1;

    $i = (int) $begin;
    while ($i < $begin + $nb_links && $i <= $last_page)
    {
      $links[] = $i++;
    }

    //$this->currentMaxLink = count($links) ? $links[count($links) - 1] : 1;

    return $links;
  }
  
  public function executeShow(sfWebRequest $request)
  {
    $department_id = $request->getParameter('department_id');
    
    $department = departmentsTable::getInstance()
      ->createQuery('d')               
      ->leftJoin('d.contract as contract')
      ->leftJoin('contract.organization as organization')
      ->leftJoin('d.City as city')
      ->leftJoin('city.Region as region')
      ->where('d.id = ?', $department_id)
      ->fetchOne();
    
    $this->department = $department;
    
    $app = sfContext::getInstance()->getConfiguration()->getApplication();
    
    $this->can_edit = $this->getUser()->hasCredential($app);
  }

  public function executeExcel1c(sfWebRequest $request)
  {
    $departmentId = $request->getParameter('department_id');
    $year = $request->getParameter('year');
    $month = $request->getParameter('month');

    $filename = "{$year}-{$month}-" . time();

    $objPHPExcel = PHPExcelHelpdesk::getDepartmentExcelFor1c($departmentId, $year, $month);

    // Redirect output to a client’s web browser (Excel5)
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="grafik-report-' . $filename . '.xls"');
    header('Cache-Control: max-age=0');
    // If you're serving to IE 9, then the following may be needed
    header('Cache-Control: max-age=1');

    // If you're serving to IE over SSL, then the following may be needed
    header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
    header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header ('Pragma: public'); // HTTP/1.0

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
    exit;

    return sfView::NONE;
  }

  /**
   * Executes ExcelPrint action
   *
   * @param sfWebRequest $request
   * @return string
   */
  public function executeExcelPrint(sfWebRequest $request)
  {
    $departmentId = $request->getParameter('department_id');
    $year = $request->getParameter('year');
    $month = $request->getParameter('month');

    $id = "{$year}-{$month}-print-" . time();

    $objPHPExcel = PHPExcelHelpdesk::getDepartmentExcelForPrint($departmentId, $year, $month, $id);

    // Redirect output to a client’s web browser (Excel5)
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="grafik-report-' . $id . '.xls"');
    header('Cache-Control: max-age=0');
    // If you're serving to IE 9, then the following may be needed
    header('Cache-Control: max-age=1');

    // If you're serving to IE over SSL, then the following may be needed
    header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
    header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header ('Pragma: public'); // HTTP/1.0

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
    exit;

    return sfView::NONE;
  }
  
  public function executeRefresh_contacts(sfWebRequest $request)
  {
    $department_id = $request->getParameter('department_id');

    $app = sfContext::getInstance()->getConfiguration()->getApplication();

    $canEdit = $this->getUser()->hasCredential($app);
    
    return $this->renderComponent('entity', 'department_contact_list',
      array(
        'department_id' => $department_id,
        'can_edit' => $canEdit
      ));
  }

  public function executeRefresh_people_list(sfWebRequest $request)
  {
    $department_id = $request->getParameter('department_id');
    $year = $request->getParameter('year');
    $month = $request->getParameter('month');
    
    return $this->renderComponent('entity', 'people_list', 
      array(
        'department_id' => $department_id,
        'year' => $year,
        'month' => $month
      )
    );
  }
  
  public function executeChange_date(sfWebRequest $request)
  {
    $department_id = $request->getParameter('department_id');
    
    if (!$department_id)
    {
      return sfView::NONE;
    }
    
    $year = $request->getParameter('year') ? $request->getParameter('year') : date('Y');
    $month = $request->getParameter('month') ? $request->getParameter('month') : date('n');
    $day = $request->getParameter('day') ? $request->getParameter('day') : date('j');

    GlobalFunctions::setSessionVariable('year', $year, GlobalFunctions::SESSION_NAMESACE__GRAFIK_ENTITY . $department_id);
    GlobalFunctions::setSessionVariable('month', $month, GlobalFunctions::SESSION_NAMESACE__GRAFIK_ENTITY . $department_id);

    return $this->renderComponent('entity', 'people_list', 
      array(
        'year' => $year,
        'month' => $month,
        'day' => $day,
        'department_id' => $department_id
      )
    );
  }
  
  public function executeGrafik_time_form(sfWebRequest $request)
  {
    if (!$request->isXmlHttpRequest())
    {
      return sfView::NONE;
    }
    
    $params = $request->getParameter('grafik_time');
    
    $grafik = Doctrine::getTable('GrafikTime')
      ->createQuery('g')
      ->addWhere('id = ?', $params['id'])
      ->fetchOne();
    
    $grafik_time_form = new GrafikTimeForm($grafik);

    //set id
    //$grafik_time_form->setDefaults($params);

    //unset department_id etc...
    $grafik_time_form->unsetDefaults();
        
    return $this->renderPartial('entity/grafik_time_form', array('grafik_time_form' => $grafik_time_form));
  }
  
  public function executePeople_form(sfWebRequest $request)
  {
    if (!$request->isXmlHttpRequest())
    {
      return sfView::NONE;
    }
    
    $id = $request->getParameter('id');

    if ($id)
    {
      $people = Doctrine::getTable('DepartmentPeople')
        ->createQuery('g')
        ->addWhere('id = ?', $id)
        ->fetchOne();

      $people_form = new DepartmentPeopleForm($people);
    }
    else // new record
    {
      $people_form = new DepartmentPeopleForm();

      $departmentId = $request->getParameter('department_id');
      $year = $request->getParameter('year');
      $month = $request->getParameter('month');

      $defaults = $people_form->getDefaults();

      $defaults['department_id'] = $departmentId;
      $defaults['year'] = $year;
      $defaults['month'] = $month;

      $people_form->setDefaults($defaults);
    }

      
    return $this->renderPartial('entity/people_form', array('people_form' => $people_form));
  }

  public function executePeople_month_info_form(sfWebRequest $request)
  {
    if (!$request->isXmlHttpRequest())
    {
      return sfView::NONE;
    }

    $peopleId = $request->getParameter('id');
    $replacement_id = $request->getParameter('replacement_id');

    $departmentId = $request->getParameter('department_id');
    $year = $request->getParameter('year');
    $month = $request->getParameter('month');

    if ($peopleId)
    {
      $peopleMonthInfo = Doctrine::getTable('DepartmentPeopleMonthInfo')
        ->createQuery('dpmi')
        ->addWhere('dpmi.department_people_id = ?', $peopleId)
        ->addWhere('dpmi.year = ? ', $year)
        ->addWhere('dpmi.month = ? ', $month)
        ->addWhere('dpmi.department_people_replacement_id = ? ', $replacement_id)
        ->fetchOne();

      if (!$peopleMonthInfo)
      {
        $peopleMonthInfo = new DepartmentPeopleMonthInfo();
        $peopleMonthInfo->setDepartmentPeopleId($peopleId);
        $peopleMonthInfo->setYear($year);
        $peopleMonthInfo->setMonth($month);
        $peopleMonthInfo->setDepartmentPeopleReplacementId($replacement_id);
        $peopleMonthInfo->save();
      }

      $peopleMonthInfoForm = new DepartmentPeopleMonthInfoForm($peopleMonthInfo);
    }
    else // new record
    {
      $options = array(
        'departmentId' => $departmentId,
        'year' => $year,
        'month' => $month
      );

      $peopleMonthInfoForm = new DepartmentPeopleMonthInfoForm(array(), $options);

      $defaults = $peopleMonthInfoForm->getDefaults();

      $defaults['department_id'] = $departmentId;
      $defaults['year'] = $year;
      $defaults['month'] = $month;

      $peopleMonthInfoForm->setDefaults($defaults);
    }


    return $this->renderPartial('entity/peopleMonthInfoForm', array('peopleMonthInfoForm' => $peopleMonthInfoForm));
  }
  
  public function executeGrafik_form_submit(sfWebRequest $request)
  {
    if (!$request->isXmlHttpRequest())
    {
      return sfView::NONE;
    }
    
    $params = $request->getParameter('grafik');
    
    $return = array(
      'error' => 0,
      'content' => '',
    );
    
    $grafik = Doctrine::getTable('Grafik')
      ->createQuery('g')
      ->addWhere('year = ?', $params['year'])
      ->addWhere('month = ?', $params['month'])
      ->addWhere('day = ?', $params['day'])
      ->addWhere('department_id = ?', $params['department_id'])
      ->addWhere('department_people_id = ?', $params['department_people_id'])
      ->addWhere('department_people_replacement_id = ?', $params['department_people_replacement_id'])
      ->fetchOne();
    
    $grafik_form = new GrafikForm($grafik);

    //$grafik_form->unsetDefaults();
    
    //if (!$grafik)
    //{
      $grafik_form->bind($params);
    //}
    
    if ($grafik_form->isValid())
    {
      $grafik_form->save();
      //$return['error'] = 0;
      //$return['content'] = $this->getPartial('entity/grafik_form', array('grafik_form' => $grafik_form));
    }
    else
    {
      $return['error'] = 1;
      $return['content'] = $this->getPartial('entity/grafik_form', array('grafik_form' => $grafik_form));
    }
    
    return $this->renderText(json_encode($return));
  }

  public function executeGrafik_time_form_submit(sfWebRequest $request)
  {
    if (!$request->isXmlHttpRequest())
    {
      return sfView::NONE;
    }

    $params = $request->getParameter('grafik_time');

    $return = array(
      'error' => 0,
      'content' => '',
    );

    $grafik = Doctrine::getTable('GrafikTime')
      ->createQuery('g')
      ->addWhere('id = ?', $params['id'])
      ->fetchOne();

    $grafik_time_form = new GrafikTimeForm($grafik);

    $grafik_time_form->unsetDefaults();

    //if (!$grafik)
    //{
    $grafik_time_form->bind($params);
    //}

    if ($grafik_time_form->isValid())
    {
      $grafik_time_form->save();
      //$return['error'] = 0;
      //$return['content'] = $this->getPartial('entity/grafik_form', array('grafik_form' => $grafik_form));
    }
    else
    {
      $return['error'] = 1;
      $return['content'] = $this->getPartial('entity/grafik_time_form', array('grafik_time_form' => $grafik_time_form));
    }

    return $this->renderText(json_encode($return));
  }
  
  public function executePeople_form_submit(sfWebRequest $request)
  {
    if (!$request->isXmlHttpRequest())
    {
      return sfView::NONE;
    }
    
    $params = $request->getParameter('department_people');
    
    $return = array(
      'error' => 0,
      'content' => '',
    );

    $people = array();

    if ($params['id'])
    {
      $people = Doctrine::getTable('DepartmentPeople')
        ->createQuery('g')
        ->addWhere('id = ?', $params['id'])
        ->fetchOne();
    }

    $people_form = new DepartmentPeopleForm($people);
    
    //if (!$grafik)
    //{
      $people_form->bind($params);
    //}
    
    if ($people_form->isValid())
    {
      $people_form->save();
      //$return['error'] = 0;
      //$return['content'] = $this->getPartial('entity/grafik_form', array('grafik_form' => $grafik_form));
    }
    else
    {
      $return['error'] = 1;
      $return['content'] = $this->getPartial('entity/people_form', array('people_form' => $people_form));
    }
    
    return $this->renderText(json_encode($return));
  }

  public function executePeople_month_info_form_submit(sfWebRequest $request)
  {
    if (!$request->isXmlHttpRequest())
    {
      return sfView::NONE;
    }

    $params = $request->getParameter('department_people_month_info');

    $return = array(
      'error' => 0,
      'content' => '',
    );

    $peopleMonthInfo = array();
    $options = array();

    if ($params['department_people_id'] && $params['year'] && $params['month'])
    {
      $params['department_people_replacement_id'] = $params['department_people_replacement_id'] ? $params['department_people_replacement_id'] : 0;

      $peopleMonthInfo = Doctrine::getTable('DepartmentPeopleMonthInfo')
        ->createQuery('dpmi')
        ->addWhere('dpmi.department_people_id = ?', $params['department_people_id'])
        ->addWhere('dpmi.year = ?', $params['year'])
        ->addWhere('dpmi.month = ?', $params['month'])
        ->addWhere('dpmi.department_people_replacement_id = ?', $params['department_people_replacement_id'])
        ->fetchOne();

      /** @var DepartmentPeople $person */
      $person = Doctrine::getTable('DepartmentPeople')->find($params['department_people_id']);

      $departmentId = $person ? $person->getDepartmentId() : null;

      $options = array(
        'departmentId' => $departmentId,
        'year' => $params['year'],
        'month' => $params['month']
      );
    }

    $peopleMonthInfoForm = new DepartmentPeopleMonthInfoForm($peopleMonthInfo, $options);

    //if (!$grafik)
    //{
    $peopleMonthInfoForm->bind($params);
    //}

    if ($peopleMonthInfoForm->isValid())
    {
      $peopleMonthInfoForm->save();
      //$return['error'] = 0;
      //$return['content'] = $this->getPartial('entity/grafik_form', array('grafik_form' => $grafik_form));
    }
    else
    {
      $return['error'] = 1;
      $return['content'] = $this->getPartial('entity/peopleMonthInfoForm', array('peopleMonthInfoForm' => $peopleMonthInfoForm));
    }

    return $this->renderText(json_encode($return));
  }
  
  public function executeGet_months(sfWebRequest $request)
  {
    if (!$request->isXmlHttpRequest())
    {
      return sfView::NONE;
    }
    
    $department_id = $request->getParameter('department_id');
    $year = $request->getParameter('year');
    
    $monthIds = Grafik::getWorkedMonthsIndex($department_id, $year);
    
    $months = Grafik::getWorkedMonths($monthIds);
    
    return $this->renderPartial('entity/months', array('months' => $months));
  }
  
  public function executeCopy_permanent_staff(sfWebRequest $request)
  {
    if (!$request->isXmlHttpRequest())
    {
      return sfView::NONE;
    }

    $i18n = sfContext::getInstance()->getI18N();
    
    $department_id = $request->getParameter('department_id');
    $year = $request->getParameter('year');
    $month = $request->getParameter('month');

    // @todo remove before production
    Grafik::copyToNextMonth($department_id, $year, $month);

    return $this->renderText($i18n->__('This task added to queue. Soon it will be proceed'));
    // eof remove
    
    if (!Grafik::canCopyToNextMonth($year, $month))
    {
      return sfView::NONE;
    }

    // add to queue
    $params = array(
      'departmentId' => $department_id,
      'year' => $year,
      'month' => $month
    );
    $objectModel = Queue::MODEL__GRAFIK;

    $queue = Queue::getByModelAndId($objectModel, $params);

    // if already in queue
    if (!$queue)
    {
      Queue::addItem($objectModel, $params);
    }
    // eof add to queue
    
    //$status = Grafik::copyToNextMonth($department_id, $year, $month);
    
    return $this->renderText($i18n->__('This task added to queue. Soon it will be proceed'));
  }

  /**
   * Executes index action
   *
   * @param sfRequest $request A request object
   */
  public function executeIndexexcel(sfWebRequest $request)
  {
    set_time_limit(0);

    $page = $request->getParameter('page', 1);

    $departments_query = departmentsTable::getMyDepartmentsQuery();

    $this->processQuery($departments_query, $request);

    $pager = new Doctrine_Pager(
      $departments_query,
      $page,
      100000
    );

    $app = sfContext::getInstance()->getConfiguration()->getApplication();

    $this->canEdit = $this->getUser()->hasCredential($app);

    $this->departments = $pager->execute();

    $this->pager = $pager;

    $this->pager->links = $this->getLinks($page, $this->pager->getLastPage());

    //filters
    $this->processFilters($request);

    $this->filters = $this->getFilters();

    $this->sort = $this->getSort();

    $this->setLayout(false);
    sfConfig::set('sf_web_debug', false);

    $this->getResponse()->setContent('application/vnd.ms-excel; charset=windows-1251');
    $this->getResponse()->setHttpHeader('Content-Disposition','attachment; filename=departments-'.time().'.xls');
    $this->getResponse()->setHttpHeader('Pragma','no-cache');
    $this->getResponse()->setHttpHeader('Expires','0');
  }

  public function executeContacts_excel(sfWebRequest $request)
  {
    $this->redirectUnless($this->getUser()->hasCredential('supervisor'), 'entity');

    $q = "
      SELECT
        mc.*,
        d.address as department,
        ds.name as status,
        o.name as organization,
        cit.name as city,
        reg.name as region,
        (SELECT
          array_to_string(
            ARRAY (
              SELECT
                cs.name
              FROM
                companystructure cs
              LEFT JOIN companystructure_region csr on csr.companystructure_id = cs.id
              WHERE
                csr.region_id = reg.id
            ), ''
          )
        ) as companystructure
      FROM model_contact mc
      LEFT JOIN departments d on d.id = mc.model_id
      LEFT JOIN departments_status ds on d.status_id = ds.id
      LEFT JOIN organization o on o.id = d.organization_id
      LEFT JOIN city cit on cit.id = d.city_id
      LEFT JOIN region reg on reg.id = cit.region_id
    ";
    $doctrine = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();

    $result = $doctrine->query($q);

    $this->contacts = $result->fetchAll();

    $this->setLayout(false);
    sfConfig::set('sf_web_debug', false);

    $this->getResponse()->setContent('application/vnd.ms-excel; charset=windows-1251');
    $this->getResponse()->setHttpHeader('Content-Disposition','attachment; filename=department_contacts-'.time().'.xls');
    $this->getResponse()->setHttpHeader('Pragma','no-cache');
    $this->getResponse()->setHttpHeader('Expires','0');
  }

  public function executeDepartment_people_excel(sfWebRequest $request)
  {
    $q = "
      SELECT
        DISTINCT dp.id,
        dp.id as id,
        dp.name as name,
        (dp.last_name || ' ' || dp.first_name || ' ' || dp.middle_name) as full_name,
        dp.last_name as last_name,
        dp.first_name as first_name,
        dp.middle_name as middle_name,
        dp.admission_date as admission_date,
        dp.dismissal_date as dismissal_date,
        dp.passport as passport,
        cit1.name as city_name,
        reg1.name as region_name,
        (select
          dpmi2.position_id
        from
          department_people_month_info dpmi2
        where
          month = 1 AND
          year = 2014 AND
          department_people_id = dp.id AND
          type_id = 18
        limit 1
        ) as position_id,
        (select
          dpmi1.salary
        from
          department_people_month_info dpmi1
        where
          month = 1 AND
          year = 2014 AND
          department_people_id = dp.id AND
          type_id = 18
        limit 1
        ) as salary,
        dp.birthday as birthday,
        (select
          dpmi2.type_string
        from
          department_people_month_info dpmi2
        where
          month = 1 AND
          year = 2014 AND
          department_people_id = dp.id AND
          type_id = 18
        limit 1
        ) as type_string,
        (select
          dpmi.employment_type_id
        from
          department_people_month_info dpmi
        where
          month = 1 AND
          year = 2014 AND
          department_people_id = dp.id AND
          type_id = 18
        limit 1
        ) as employment_type_id,
        dp.drfo as drfo,
        dp.person_code as person_code,
        dp.number as number,
        d.mpk as mpk,
        d.status_id as status_id,
        array_to_string(
          ARRAY(
            SELECT
              cs.name
            FROM
              companystructure cs
            LEFT JOIN companystructure_region csr ON csr.companystructure_id = cs.id
            LEFT JOIN region reg ON reg.id = csr.region_id
            LEFT JOIN city cit ON cit.region_id = reg.id
            LEFT JOIN departments d ON d.city_id = cit.id
            WHERE
              d.id = dp.department_id
          ), ', '
        ) as companystructure_name,
        (select
          dpmi4.department_people_id
        from
          department_people_month_info dpmi4
        where
          month = 1 AND
          year = 2014 AND
          department_people_id = dp.id AND
          type_id = 18
        limit 1
        ) as exists_in_jan
      FROM
        department_people dp
        LEFT JOIN departments d on d.id = dp.department_id
        LEFT JOIN city cit1 ON cit1.id = d.city_id
        LEFT JOIN region reg1 ON reg1.id = cit1.region_id
      ";

    $user = $this->getUser();

    if ($user->hasCredential('oper') && !$user->hasCredential('supervisor'))
    {
      $q .= "
        INNER JOIN stuff_departments sd on sd.departments_id = d.id
      ";
    }

    $q .= "
      WHERE
      	dp.parent_id is null";

    if ($user->hasCredential('oper') && !$user->hasCredential('supervisor'))
    {
      $stuffId = GlobalFunctions::getStuffId();

      $q .= "
        AND sd.stuff_id = " .$stuffId . "
      ";
    }

    //$q .= ' AND dp.department_id = 60';
    //$q .= ' limit 100';

    $doctrine = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();

    $result = $doctrine->query($q);

    $this->peoples = $result->fetchAll();

    $lookup = Doctrine::getTable('lookup')
      ->createQuery('l')
      ->execute();

    $this->lookup = $lookup->toKeyValueArray('id', 'name');

    $this->setLayout(false);
    sfConfig::set('sf_web_debug', false);

    $this->getResponse()->setContent('application/vnd.ms-excel; charset=utf-8');
    $this->getResponse()->setHttpHeader('Content-Disposition','attachment; filename=department_people-'.time().'.xls');
    $this->getResponse()->setHttpHeader('Pragma','no-cache');
    $this->getResponse()->setHttpHeader('Expires','0');
  }

  public function executeGrafik_day(sfWebRequest $request)
  {
    if (!$request->isXmlHttpRequest())
    {
      return sfView::NONE;
    }

    $params = $request->getParameter('grafik');

    return $this->renderPartial('entity/grafik_day', array('params' => $params));
  }

  public function executeRefresh_grafik_day_list(sfWebRequest $request)
  {
    if (!$request->isXmlHttpRequest())
    {
      return sfView::NONE;
    }

    $params = $request->getParameter('grafik');

    return $this->renderComponent('entity','grafik_day_list', array('params' => $params));
  }

  public function executeOrganization_excel(sfWebRequest $request)
  {
    set_time_limit(0);
    ini_set('memory_limit', '2048M');

    //$organization_query = organizationTable::getMyOrganizationExcelQuery()->execute();

    $q = "
      SELECT
        o.id as id,
        o.address as address,
        o.name as name,
        cit.name as city,
        reg.name as region,
        dogovor.id as dogovor_id,
        dogovor.number as dogovor_number,
        dogovor.startdatetime as dogovor_startdatetime,
        dogovor.stopdatetime as dogovor_stopdatetime,
        dogovor.subject as dogovor_subject,
        mc.last_name || '-' || mc.first_name as contact_fio,
        mc.position as contact_position,
        mc.phone1 as contact_phone,
        mc.email as contact_email,
        mc.birthday as contact_birthday,
        u.last_name || '-' || u.first_name as manager_fio,
        (SELECT s.mobilephone FROM stuff s WHERE s.user_id = u.id LIMIT 1) as manager_phone,
        dp.name AS stuff_fio,
        dp.contacts AS stuff_phone,
        dp.position_id AS stuff_position,
        dp.birthday AS stuff_birthday
      FROM organization o
      LEFT JOIN city cit on cit.id = o.city_id
      LEFT JOIN region reg on reg.id = cit.region_id
      LEFT JOIN Dogovor dogovor on dogovor.organization_id = o.id
      LEFT JOIN (SELECT mc1.* from model_contact mc1 where mc1.model_name = 'organization') mc on mc.model_id = o.id
      LEFT JOIN organization_user ou on ou.organization_id = o.id
      LEFT JOIN sf_guard_user u on ou.user_id = u.id
      LEFT JOIN departments d on d.organization_id = o.id
      LEFT JOIN (SELECT
                       DISTINCT ON(dp1.name) dp1.name,
                       dp1.contacts,
                       dp1.position_id,
                       dp1.birthday,
                       dp1.department_id
                      FROM department_people dp1) dp ON dp.department_id = d.id

    ";
    $doctrine = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();

    $params = array(
      ':organizationId' => 855,
      ':organizationModel' => ModelContact::MODEL_ORGANIZATION
    );

    $q = str_replace(array_keys($params), array_values($params), $q);

    $result = $doctrine->query($q);

    $this->organizations = $result->fetchAll();

    $lookup = Doctrine::getTable('lookup')
      ->createQuery('l')
      ->execute();

    $this->lookup = $lookup->toKeyValueArray('id', 'name');

    $this->setLayout(false);
    sfConfig::set('sf_web_debug', false);

    $this->getResponse()->setContent('application/vnd.ms-excel; charset=windows-1251');
    $this->getResponse()->setHttpHeader('Content-Disposition','attachment; filename=organization-'.time().'.xls');
    $this->getResponse()->setHttpHeader('Pragma','no-cache');
    $this->getResponse()->setHttpHeader('Expires','0');
  }

  /**
   * Executes copyAll action
   *
   * @param sfWebRequest $request
   */
  public function executeCopyAll(sfWebRequest $request)
  {
    if (!GlobalFunctions::hasCredential('stuff', false))
    {
      return;
    }

    // check if queue exist
    $objectModel = Queue::MODEL__GRAFIK;
    $objectSubmodel = Queue::SUBMODEL__GRAFIK_COPY_ALL;
    $params = array(
      'userId' => GlobalFunctions::getUserId(),
      'year' => date('Y'),
      'month' => date('n')
    );
    $queue = Queue::getByModelAndId($objectModel, $params, $objectSubmodel);

    // if already in queue
    if (!$queue)
    {
      Queue::addItem($objectModel, $params, $objectSubmodel);
    }
  }

   /**
   * Executes exportExcel1cAll action
   *
   * @param sfWebRequest $request
   */
  public function executeExportExcel1cAll(sfWebRequest $request)
  {
    if (!GlobalFunctions::hasCredential('stuff', false))
    {
      return;
    }

    // check if queue exist
    $objectModel = Queue::MODEL__GRAFIK;
    $objectSubmodel = Queue::SUBMODEL__GRAFIK_EXPORT_EXCEL_ALL;
    $params = array(
      'userId' => GlobalFunctions::getUserId(),
      'year' => date('Y'),
      'month' => date('n')
    );
    $queue = Queue::getByModelAndId($objectModel, $params, $objectSubmodel);

    // if already in queue
    if (!$queue)
    {
      Queue::addItem($objectModel, $params, $objectSubmodel);
    }
  }

  /*public function executeUploadExcelTest(sfWebRequest $request)
  {
    $batchImportDir = PHPExcelHelpdesk::getBatchImportDir();
    $file = '2013-9-12-1378671743.xls';
    PHPExcelHelpdesk::uploadExcel($batchImportDir . '/' . $file);
  }*/

  /*public function executeUploadExcelTest(sfWebRequest $request)
  {
    $batchImportDir = PHPExcelHelpdesk::getBatchImportDir();
    $file = '2013-9-12-1378671743.xls';
    PHPExcelHelpdesk::uploadExcel($batchImportDir . '/' . $file);
  }*/

  public function executeRefresh_department_people_list(sfWebRequest $request)
  {
    $departmentId = $request->getParameter('department_id');

    $department = Doctrine::getTable('departments')->find($departmentId);

    return $this->renderComponent('entity', 'department_people_list', array('department' => $department));
  }

  /**
   * Execute ajax entity Grafik
   *
   * @param sfWebRequest $request
   * @return string
   */
  public function executeAjaxGrafik(sfWebRequest $request)
  {
    $departmentId = $request->getParameter('department_id');
    $canEdit =  $request->getParameter('can_edit');

    if (!$departmentId)
    {
      return sfView::NONE;
    }

    $department = Doctrine::getTable('departments')->find($departmentId);

    return $this->renderComponent('entity', 'grafik', array(
      'department' => $department,
      'can_edit' => $canEdit
    ));
  }

  /**
   * Execute ajax entity General
   *
   * @param sfWebRequest $request
   * @return string
   */
  public function executeAjaxGeneral(sfWebRequest $request)
  {
    $departmentId = $request->getParameter('department_id');
    $canEdit =  $request->getParameter('can_edit');

    if (!$departmentId)
    {
      return sfView::NONE;
    }

    $department = Doctrine::getTable('departments')->find($departmentId);

    return $this->renderPartial('entity/show_general', array(
      'department' => $department,
      'can_edit' => $canEdit
    ));
  }

  /**
   * Execute ajax entity ajaxTechnicalParams
   *
   * @param sfWebRequest $request
   * @return string
   */
  public function executeAjaxTechnicalParams(sfWebRequest $request)
  {
    $departmentId = $request->getParameter('department_id');
    $canEdit =  $request->getParameter('can_edit');

    if (!$departmentId)
    {
      return sfView::NONE;
    }

    $department = Doctrine::getTable('departments')->find($departmentId);

    return $this->renderComponent('entity', 'technical_params', array(
      'department' => $department,
      'can_edit' => $canEdit
    ));
  }

  /**
   * Execute ajax entity ajaxDocuments
   *
   * @param sfWebRequest $request
   * @return string
   */
  public function executeAjaxDocuments(sfWebRequest $request)
  {
    $departmentId = $request->getParameter('department_id');
    $canEdit =  $request->getParameter('can_edit');

    if (!$departmentId)
    {
      return sfView::NONE;
    }

    $department = Doctrine::getTable('departments')->find($departmentId);

    return $this->renderComponent('entity', 'documents', array(
      'department' => $department,
      'can_edit' => $canEdit
    ));
  }

  /**
   * Execute ajax entity ajaxPeople
   *
   * @param sfWebRequest $request
   * @return string
   */
  public function executeAjaxPeople(sfWebRequest $request)
  {
    $departmentId = $request->getParameter('department_id');
    $canEdit =  $request->getParameter('can_edit');

    if (!$departmentId)
    {
      return sfView::NONE;
    }

    $department = Doctrine::getTable('departments')->find($departmentId);

    return $this->renderComponent('entity', 'people', array(
      'department' => $department,
      'can_edit' => $canEdit
    ));
  }

  /**
   * Execute ajax entity ajaxDepartmentPeople
   *
   * @param sfWebRequest $request
   * @return string
   */
  public function executeAjaxDepartmentPeople(sfWebRequest $request)
  {
    $departmentId = $request->getParameter('department_id');
    $canEdit =  $request->getParameter('can_edit');
    $lastRecord =  $request->getParameter('lastRecord', 0);

    if (!$departmentId)
    {
      return sfView::NONE;
    }

    $limit = 5;
    $offset = 0;
    $isShowMore = false;

    if ($request->getParameter('offset'))
    {
      $offset = $request->getParameter('offset');
      $isShowMore = true;
    }

    $department = Doctrine::getTable('departments')->find($departmentId);

    return $this->renderComponent('entity', 'department_people_list', array(
      'department' => $department,
      'can_edit' => $canEdit,
      'limit' => $limit,
      'offset' => $offset,
      'isShowMore' => $isShowMore,
      'lastRecord' => $lastRecord
    ));
  }

  /**
   * Executes migration action step 1
   * Finds duplicates and fix them
   *
   * @param sfWebRequest $request
   * @return string
   */
  public function executeMigrationStep1(sfWebRequest $request)
  {
    set_time_limit(0);
    ini_set('memory_limit', '2048M');

    $this->limit = 5;
    $this->offset = 0;

    $this->isAjax = $request->isXmlHttpRequest();

    if ($this->isAjax)
    {
      $this->offset = $request->getParameter('offset');
    }

    $this->sort = $request->getParameter('sort');
    $this->departmentId = $request->getParameter('department_id');
    $this->lastDepartmentId = $request->getParameter('lastDepartmentId', -1);

    $query = Doctrine::getTable('DepartmentPeople')
      ->createQuery('dp')
      ->where('dp.parent_id is null')
      ->leftJoin('dp.Department d')
      ->leftJoin('d.Status s')
      ->leftJoin('d.Organization o')
      ->addWhere('d.status_id = 1');

    if ($this->departmentId)
    {
      $query
        ->andWhere('dp.department_id = ?', $this->departmentId);
    }

    $user = $this->getUser();

    if ($user->hasCredential('oper') && !$user->hasCredential('supervisor'))
    {
      $stuffId = GlobalFunctions::getStuffId();

      $query
        ->leftJoin('d.Stuff stuff')
        ->addWhere('stuff.id = ?', $stuffId);
    }

    switch ($this->sort)
    {
      case 'mpk':
        $query
          ->orderBy('dp.department_id ASC')
          ->addOrderBy('dp.last_name ASC');
        break;
      case 'name':
        $query
          ->orderBy('dp.last_name ASC');
        break;
    }

    $query
      ->offset($this->offset)
      ->limit($this->limit);

    $this->departmentPeople = $query->execute();;

    $this->setLayout('emptylayout');

    if ($this->isAjax)
    {
      $this->setLayout(false);
    }

    if (!$this->isAjax)
    {
      $this->offset = $this->limit;
    }
  }

  /**
   * Refresh grafik row
   *
   * @param sfWebRequest $request
   * @return string
   */
  public function executeAjaxGrafikRow(sfWebRequest $request)
  {
    $params = $request->getPostParameters();

    return $this->renderComponent('entity', 'people_list', $params);
  }

  /**
   * Exports departments with same mpk
   */
  public function executeSameMpkExcel(sfWebRequest $request)
  {
    $q = "
      SELECT
        d.id as id,
        d.mpk as mpk,
        o.name as organization_name,
        reg.name as region_name,
        cit.name as city_name,
        d.address as address,
        d.status_id as status_id,
        array_to_string(
          ARRAY(
            SELECT
              cs.name
            FROM
              companystructure cs
            LEFT JOIN companystructure_region csr ON csr.companystructure_id = cs.id
            WHERE csr.region_id = reg.id
          ), ', '
        ) as companystructure_name
      FROM
        departments d
      LEFT JOIN organization o on d.organization_id = o.id
      LEFT JOIN city cit on d.city_id = cit.id
      LEFT JOIN region reg on cit.region_id = reg.id
      ";

    $user = $this->getUser();

    if ($user->hasCredential('oper') && !$user->hasCredential('supervisor'))
    {
      $q .= "
        INNER JOIN stuff_departments sd on sd.departments_id = d.id
      ";
    }

    $q .= "
      WHERE d.mpk in (SELECT
          mpk
        FROM
          departments d
        GROUP BY
          mpk
        HAVING
          count(d.id) > 1)";

    if ($user->hasCredential('oper') && !$user->hasCredential('supervisor'))
    {
      $stuffId = GlobalFunctions::getStuffId();

      $q .= "
        AND sd.stuff_id = " .$stuffId . "
      ";
    }
    $q .= ' ORDER BY d.mpk ASC';
    //$q .= ' AND dp.department_id = 60';
    //$q .= ' limit 100';

    $doctrine = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();

    $result = $doctrine->query($q);

    $this->peoples = $result->fetchAll();

    $lookup = Doctrine::getTable('lookup')
      ->createQuery('l')
      ->execute();

    $this->lookup = $lookup->toKeyValueArray('id', 'name');

    $this->setLayout(false);
    sfConfig::set('sf_web_debug', false);

    $this->getResponse()->setContent('application/vnd.ms-excel; charset=utf-8');
    $this->getResponse()->setHttpHeader('Content-Disposition','attachment; filename=department_people-'.time().'.xls');
    $this->getResponse()->setHttpHeader('Pragma','no-cache');
    $this->getResponse()->setHttpHeader('Expires','0');
  }
}