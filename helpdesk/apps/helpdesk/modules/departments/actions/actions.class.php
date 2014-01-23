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
  
}
