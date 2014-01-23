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
      $this->importances = Doctrine_Core::getTable('contract_importance')->getImportanceByOrganization($org_id);
      if ($request->isXmlHttpRequest())
      {  
          return $this->renderPartial('ajaxdata/importance');
      } 
      return $this->renderPartial('errors/daccess');
  }
  
  
  public function executeDepartments(sfWebRequest $request)
  {
      $cityid = $request->getParameter('cityid');
      if (!$cityid) return $this->renderText('No records');
      //if ($request->isXmlHttpRequest())
      //{  
          $this->departmentss = Doctrine_Core::getTable('departments')->getAllDepartmentsClient($cityid);
          return $this->renderPartial('ajaxdata/dep_list');
      //} 
      return $this->renderPartial('errors/daccess');
  }
  
  public function executeDepartmentslist(sfWebRequest $request)
  {
      $org_id = $request->getParameter('orgid');
      if (!$org_id) return $this->renderText('No records');
      $this->departmentss = Doctrine_Core::getTable('departments')->getDepartmentsByOrganization($org_id);
      if ($request->isXmlHttpRequest())
      {  
          //$this->getUser()->setAttribute('organization_id', $org_id);
          return $this->renderPartial('claimopened/dep_list');
      } 
      return $this->renderPartial('errors/daccess');
  }
  
  public function executeCity(sfWebRequest $request)
  {
      $orgid = $request->getParameter('orgid');
      if (!$orgid) return $this->renderText('No records');
      $this->citys = Doctrine_Core::getTable('city')->getCityByOrganizationOrderName($cityid);
      if ($request->isXmlHttpRequest())
      {  
          //$this->getUser()->setAttribute('organization_id', $org_id);
          return $this->renderPartial('ajaxdata/city_list');
      } 
      return $this->renderPartial('errors/daccess');
  }
  
  
}
