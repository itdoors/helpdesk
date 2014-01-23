<?php

/**
 * maruk_to_klen actions.
 *
 * @package    helpdesk
 * @subpackage maruk_to_klen
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class departmentsActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    /*$departments = Doctrine::getTable('departments')
      ->createQuery()
      ->where('contract_id = ?', 34)
      ->execute();
      
    $departments_copy = array();
    foreach($departments as $department)
    {
      $department_copy = $department->copy();
      $department_copy->setName($department_copy->getName().' (Ева)');
      $department_copy->setAddress($department_copy->getAddress().' (Ева)');
      $department_copy->setContractId(36);
      $department_copy->setMpk('');
      $department_copy->save();
      
      $stuff_departments = $department->getStuffDepartments();
      
      foreach ($stuff_departments as $stuff)
      {
        $stuff_copy  = $stuff->copy();
        $stuff_copy->setDepartmentsId($department_copy->getId());
        $stuff_copy->save();
      }
      
      $departments_copy[] = $department_copy;
    }
    
    $this->departments = $departments_copy;*/
    return sfView::NONE;
  }
  
  public function executeCoordinates(sfWebRequest $request)
  {
    /*$departments = Doctrine::getTable('departments')
      ->createQuery('d')
      ->where('d.coordinates is not null')
      ->execute();
      
    foreach ($departments as $department)
    {
      $coor = $department->getCoordinates();
      if ($coor) 
      {
        $coor = str_replace('(','',$coor);
        $coor = str_replace(')','',$coor);
        $department->setCoordinates($coor);
        $department->save();
      }
    }
      
    var_export(count($departments)); */
    
    
    return sfView::NONE;
  }
}
