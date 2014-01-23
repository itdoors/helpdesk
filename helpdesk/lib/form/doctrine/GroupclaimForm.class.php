<?php

/**
 * Groupclaim form.
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class GroupclaimForm extends BaseGroupclaimForm
{
  public function configure()
  {
       $this->widgetSchema['organization_id'] = new sfWidgetFormDoctrineDependentSelect(array(
            'model'     => 'organization',
            'order_by'      => array('name', 'asc')
        ));
        $this->validatorSchema['organization_id'] = new sfValidatorDoctrineChoice(array(
            'model' => 'organization',
            'required' => true,
            
      ));
/*        $this->widgetSchema['city_id'] = new sfWidgetFormDoctrineDependentSelect(array(
            'model'     => 'city',
            'depends'   => 'organization_id',
            'add_empty' => 'Select city',
            'table_method' => 'getCityQuery',
            'ajax'      => true,
            'order_by'      => array('name', 'asc')
        ));*/
      
      $this->widgetSchema['contract_importance_id'] = new sfWidgetFormDoctrineDependentSelect(array(
            'model'     => 'contract_importance',
            'table_method' => 'getContractImportanceQuery', 
            'depends'   => 'organization_id',
            'ref_method' => 'getOrganizationId',
            'add_empty' => false,
            'ajax'      => true,
           ));
//      $this->widgetSchema['departments_ids']->setNameFormat('groupclaim[%s][]');
      $this->validatorSchema['contract_importance_id'] = new sfValidatorDoctrineChoice(array(
            'model' => 'contract_importance',
           //multiple'  => true,
            'required' => true,   
      ));  
      sfContext::getInstance()->getConfiguration()->loadHelpers(array('Url'));  
      $this->widgetSchema['departments_ids'] = new sfWidgetFormDoctrineDependentSelect(array(
            'model'     => 'departments', 
            'depends'   => 'organization_id',
            'table_method' => 'getDepartmentsQuery',
            'ref_method' => 'getOrganizationId',   
            'add_empty' => false,
            'ajax'      => true,
            'multiple'  => 'multiple',
            'cache' => false
            //'url'       => url_for('groupclaim/getdepartments')
           ));
//      $this->widgetSchema['departments_ids']->setNameFormat('groupclaim[%s][]');
      $this->validatorSchema['departments_ids'] = new sfValidatorDoctrineChoice(array(
            'model' => 'departments',
            'multiple'  => true,
            'required' => true,   
      )); 
      
      $this->widgetSchema['client_id'] = new sfWidgetFormDoctrineDependentSelect(array(
            'model'     => 'client', 
            'depends'   => 'organization_id',
            'table_method' => 'getClientQuery',
            'add_empty' => false,
            'ajax'      => true,
            
           ));
      $this->validatorSchema['client_id'] = new sfValidatorDoctrineChoice(array(
            'model' => 'client',
            'required' => true,   
      ));
      $this->setWidget('message' , 
          new isicsWidgetFormTinyMCE(
             array(
                'tiny_options' => sfConfig::get('app_tiny_mce_my_settings', array()),
                
                 )
          ,
          array('class'=>'claim_message')
      )); 
      
      $this->useFields(
          array(
            'name',
            'claimtype_id',
            'groupclaimwork_id',
            'organization_id',
            'contract_importance_id',
            'client_id' ,
            //'formula',
            'departments_ids',
            'message',
            
      ));
      $exist_periods = $this->getObject()->getGroupclaimperiod();
      if (count($exist_periods))
      {
         foreach ($exist_periods as $key => $period)
           {
               $GroupclaimperiodForm = new GroupclaimperiodForm($period);
               unset($GroupclaimperiodForm['groupclaim_id']);
               $this->embedForm('Groupclaim'.$key, $GroupclaimperiodForm);
           } 
      } else
      {
          $Groupclaimperiod = new Groupclaimperiod();
          $Groupclaimperiod->setGroupclaim($this->getObject());
          $GroupclaimperiodForm = new GroupclaimperiodForm($Groupclaimperiod);
          unset($GroupclaimperiodForm['groupclaim_id']);
          $this->embedForm('groupclaimperiod', $GroupclaimperiodForm);  
      }

     

      
  }
  
  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();
    $this->setDefault('departments_ids', $this->object->Departments->getPrimaryKeys());
/*    if (isset($this->widgetSchema['departments_ids']))
    {
      $this->setDefault('departments_ids', $this->object->Departments->getPrimaryKeys());
    }  */

  }

  protected function doSave($con = null)
  {
    $this->saveDepartmentsList($con);

    parent::doSave($con);
  }

  public function saveDepartmentsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['departments_ids']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Departments->getPrimaryKeys();
    $values = $this->getValue('departments_ids');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Departments', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Departments', array_values($link));
    }
  }
  
}
