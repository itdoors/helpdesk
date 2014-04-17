<?php

/**
 * ajaxdata actions.
 *
 * @package    helpdesk
 * @subpackage ajaxdata
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ajaxdataActions extends sfActions
{
  public function executeAuto_stuff(sfWebRequest $request)
  {
    if (!$request->isXmlHttpRequest())
    {
      return sfView::NONE;
    }

    $search_field_value = $request->getParameter('q');
    $results = stuffTable::getSearchResultsAutocomplite($search_field_value);
    if ($request->isXmlHttpRequest())
    {
      return $this->renderText(json_encode($results));
    }
  }

  public function executeAuto_organization(sfWebRequest $request)
  {
    if (!$request->isXmlHttpRequest())
    {  
      return sfView::NONE;
    } 
    
    $search_field_value = $request->getParameter('q');
    $results = organizationTable::getSearchResultsAutocomplite($search_field_value); 
    if ($request->isXmlHttpRequest()) 
    {
      return $this->renderText(json_encode($results));
    }
  }
  
  public function executeAuto_city(sfWebRequest $request)
  {
    if (!$request->isXmlHttpRequest())
    {  
      return sfView::NONE;
    } 
    
    $search_field_value = $request->getParameter('q');
    $results = GlobalFunctions::getSearchResultsAutocomplite($search_field_value, 'city'); 
    if ($request->isXmlHttpRequest()) 
    {
      return $this->renderText(json_encode($results));
    }
  }
  
  public function executeAuto_organization_once(sfWebRequest $request)
  {
    if (!$request->isXmlHttpRequest())
    {  
      return sfView::NONE;
    } 
    
    $search_field_value = $request->getParameter('q');
    $results = organizationTable::getSearchResultsAutocomplite($search_field_value, OrganizationType::TYPE__ONCE); 
    if ($request->isXmlHttpRequest()) 
    {
      return $this->renderText(json_encode($results));
    }
  }
  
  public function executeAuto_departments_once(sfWebRequest $request)
  {
    if (!$request->isXmlHttpRequest())
    {  
      return sfView::NONE;
    } 
    
    $extra = $request->getParameter('extra');
    
    if (!$extra)
    {
      return sfView::NONE;
    }
    $extra = json_decode($extra);
    $org_id = intval($extra->org_id);
    $city_id = intval($extra->city_id);
    
    $search_field_value = $request->getParameter('q');

    $results = departmentsTable::getDepartmentsByOrganizationArray($org_id, $city_id, $search_field_value);
    
    if ($request->isXmlHttpRequest()) 
    {
      return $this->renderText(json_encode($results));
    }
  }
  
  public function executeDepartment_form(sfWebRequest $request)
  {
    $result = array(
      'error' => 1,
      'departments_id' => null
    );
    
    
    if ($params = $request->getParameter('departments'))
    {
      $form = new departmentsShortForm(array(), array('action' => 'save'));
      $form->bind($params);
      if ($form->isValid())
      {
        $result['error'] = 0;
        $object = $form->save();
        $result['departments_id'] = $object->getId();
        $result['departments_address'] = $object->getAddress();
      }
      else
      {
        $result['error'] = 1;
      }
      
    }
    else
    {
      $org_id = $request->getParameter('org_id');
      $city_id = $request->getParameter('city_id');
      $q = $request->getParameter('q');
      
      $department = new departments();
      $department->setOrganizationId($org_id);
      $department->setCityId($city_id);
      $department->setAddress($q);
      $form = new departmentsShortForm($department, array('action' => 'show'));
    }
    
    sfContext::getInstance()->getConfiguration()->loadHelpers('Partial');
    if ($result['error'])
    {
      $result['form'] = get_partial('ajaxdata/department_form', array('form' => $form));
    }
    
    return $this->renderText(json_encode($result));
  }
  
  
  /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    //$this->forward('default', 'module');
  }
  
  public function executeClients(sfWebRequest $request)
  {
      $org_id = $request->getParameter('orgid');
      if (!$org_id) return $this->renderText('No records');
      $this->clients = Doctrine_Core::getTable('client')->getClientByOrganization($org_id);
      if ($request->isXmlHttpRequest())
      {  
          return $this->renderPartial('ajaxdata/clients');
      } 
      return $this->renderPartial('errors/daccess');
  }
  
  public function executeImportance(sfWebRequest $request)
  {
      $org_id = $request->getParameter('orgid');
      if (!$org_id) return $this->renderText('No records');
      //$this->importances = Doctrine_Core::getTable('contract_importance')->getImportanceByOrganization($org_id);
      $this->importances = Doctrine_Core::getTable('organization_importance')->getImportanceByOrganization($org_id);
      if ($request->isXmlHttpRequest())
      {  
          return $this->renderPartial('ajaxdata/importance', array('importances' => $this->importances));
      } 
      return $this->renderPartial('errors/daccess');
  }
  
  
  public function executeDepartments(sfWebRequest $request)
  {
      $cityid = $request->getParameter('cityid');
      if (!$cityid) return $this->renderText('No records');
      $this->departmentss = Doctrine_Core::getTable('departments')->getAllDepartmentsClient($cityid);
      if ($request->isXmlHttpRequest())
      {  
          //$this->getUser()->setAttribute('organization_id', $org_id);
          return $this->renderPartial('ajaxdata/dep_list');
      } 
      return $this->renderPartial('errors/daccess');
  }
  
  public function executeDepartments_by_org(sfWebRequest $request)
  {
      $cityid = $request->getParameter('cityid');
      $orgid = $request->getParameter('orgid');
      if (!$orgid) return $this->renderText('No records');
      if ($request->isXmlHttpRequest())
      {  
          $this->departmentss = Doctrine_Core::getTable('departments')->getDepartmentsByOrganization($orgid, $cityid);
          return $this->renderPartial('ajaxdata/dep_list');
      } 
      return $this->renderPartial('errors/daccess');
     //$this->setTemplate('index');
  }
  
   public function executeCity(sfWebRequest $request)
  {
      if (!$request->isXmlHttpRequest()) return $this->renderPartial('errors/daccess'); 
      $org_id = $request->getParameter('orgid');
      if (!$org_id) return $this->renderText('No records');
      $this->citys = Doctrine_Core::getTable('city')->getCityByOrganizationOrderName($org_id);
      return $this->renderPartial('ajaxdata/city_list');

   }
  
  public function executeSave_coordinates(sfWebRequest $request)
  {
    $id = $request->getParameter('id');
    $coordinates = $request->getParameter('coordinates');
    
    $department = departmentsTable::getInstance()->find($id);
    $department->setCoordinates($coordinates);
    $department->save();
    
    return sfView::NONE;
  }
  
  public function executeAuto_position(sfWebRequest $request)
  {
    if (!$request->isXmlHttpRequest())
    {  
      return sfView::NONE;
    } 
    
    $search_field_value = $request->getParameter('q');
    $results = GlobalFunctions::getSearchResultsAutocomplite($search_field_value, 'sfGuardUser', 'position'); 
    if ($request->isXmlHttpRequest()) 
    {
      return $this->renderText(json_encode($results));
    }
  }

  public function executeDepartmentsByOrganization(sfWebRequest $request)
  {
    if (!$request->isXmlHttpRequest())
    {
      return sfView::NONE;
    }

    $organizationIds = $request->getParameter('organizationIds');

    $clientId = $request->getParameter('clientId');

    $client = Doctrine::getTable('client')->find($clientId);

    $form = new clientInfoForm($client, array('organizationIds' => $organizationIds));

    return $this->renderPartial('ajaxdata/departmentsByOrganization', array('form' => $form));
  }

  public function executeLoadClientDepartments(sfWebRequest $request)
  {
    if (!$request->isXmlHttpRequest())
    {
      return sfView::NONE;
    }

    $organizationIds = $request->getParameter('organizationIds');

    $cityId = $request->getParameter('cityId');

    /*$client = Doctrine::getTable('client')->find($clientId);*/

    $query = Doctrine::getTable('departments')
      ->createQuery('d')
      ->leftJoin('d.City as city')
      ->leftJoin('d.Organization as organization')
      ->whereIn('d.organization_id', $organizationIds)
      ->orderBy('organization.name ASC, city.name ASC');

    if ($cityId)
    {
      $query->addWhere('city.id = ? ', $cityId);
    }

    $options = array(
      'query' => $query,
      'method' => 'getWithOrganization',
      'nameFormat' => 'client_claim_form'
    );

    $form = new cleanForm(array(), $options);

    return $this->renderPartial('ajaxdata/clean', array(
      'form' => $form,
    ));
  }

  public function executeLoadClientImportance(sfWebRequest $request)
  {
    if (!$request->isXmlHttpRequest())
    {
      return sfView::NONE;
    }

    $departmentId = $request->getParameter('departmentId');

    $department = Doctrine::getTable('departments')->find($departmentId);

    $organizationId = $department->getOrganizationId();

    $query = Doctrine::getTable('organization_importance')
      ->createQuery('oi')
      ->leftJoin('oi.Importance as importance')
      ->where('oi.organization_id = ?',$organizationId);

    $widgetName = 'organization_importance_id';

    $options = array(
      'widgetName' => $widgetName,
      'model' => 'organization_importance',
      'query' => $query,
      'nameFormat' => 'client_claim_form'
    );

    $form = new cleanForm(array(), $options);

    return $this->renderPartial('ajaxdata/clean', array(
      'form' => $form,
      'widgetName' => $widgetName,
    ));
  }
}

