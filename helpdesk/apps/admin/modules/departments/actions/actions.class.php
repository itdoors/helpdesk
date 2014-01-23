<?php

/**
 * departments actions.
 *
 * @package    helpdesk
 * @subpackage departments
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class departmentsActions extends sfActions
{
  public function executeList(sfWebRequest $request)
  {
      $org_id = $request->getParameter('orgid');
      $this->departmentss = Doctrine_Core::getTable('departments')->getDepartmentsByOrganization($org_id);
      if ($request->isXmlHttpRequest())
      {  
          return $this->renderPartial('departments/dep_list');
      } 
      return $this->renderPartial('errors/daccess');
  }
  
  public function executeDeluser(sfWebRequest $request)
  {
      $departmentsstuff_id = $request->getParameter('departmentsstuff_id');
      
      if ($request->isXmlHttpRequest()||!$departmentsstuff_id)
      {  
          Doctrine::getTable('stuff_departments')->Delete($departmentsstuff_id);
          return true;
      } 
      return $this->renderPartial('errors/daccess');
  }
 
  public function executeAddpersonform(sfWebRequest $request)
  {
      $departments_id = $request->getParameter('departments_id');
       
      if ($request->isXmlHttpRequest()&&$departments_id)
      {  
          
          $form = new stuff_departments_personForm();
          
          return $this->renderPartial('departments/addperson_form', array('form'=>$form,'departments_id'=>$departments_id));
      } 
      return $this->renderPartial('errors/daccess');
  }
  
  public function executeAddperson(sfWebRequest $request)
  {
      if ($request->isXmlHttpRequest())
      {  
          $stuff_departments_request = $request->getParameter('stuff_departments');
          if ($this->saveDepartments($stuff_departments_request)) return true;
      } 
      return $this->renderPartial('errors/daccess');
  }
  
  public function executeDeppersonlist(sfWebRequest $request)
  {
      $departments_id = $request->getParameter('departments_id');
      if ($request->isXmlHttpRequest()&&$departments_id)
      {  
          $departments = Doctrine::getTable('departments')->find($departments_id);
          return $this->renderPartial('departments/depperson_list', array('departments'=>$departments));
      } 
      return $this->renderPartial('errors/daccess');
  }
  
  
  
  
  public function saveDepartments($form_feilds)
  {
      foreach ($form_feilds['claimtype_id'] as $claim_key => $claim_value)
      {
                 $stuff_departments = new stuff_departments();
                 $stuff_departments->setStuffId($form_feilds['stuff_id']); 
                 $stuff_departments->setDepartmentsId($form_feilds['departments_id']); 
                 $stuff_departments->setClaimtypeId($claim_value); 
                 $stuff_departments->setUserkey($form_feilds['userkey']); 
                 $stuff_departments->trySave(); 
      }    
      return $stuff_departments;
      
  }
  
  
}
