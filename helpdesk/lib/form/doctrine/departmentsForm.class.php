<?php

/**
 * departments form.
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class departmentsForm extends BasedepartmentsForm
{
  public function configure()
  {
    parent::configure();
    
    unset($this['stuff_list'], $this['client_list'], $this['groupclaim_list']);
    
    sfContext::getInstance()->getConfiguration()->loadHelpers('Url');
    
    $this->setWidget('organization_id', new sfWidgetFormDoctrineJQueryAutocompleter(array(
      'model'=>'organization',
      'url'=>url_for('ajaxdata/auto_organization'),
      //'js_callback' => 'auto_organization'
      //'config' => '{ width: 350,max: 100,highlight:false ,multiple: false,multipleSeparator: ",",scroll: true,scrollHeight: 250}'
    )));
    
    $this->setValidator('organization_id', new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Organization'), 'required' => false))); 
    
    $this->setDefault('organization_id', 12);
    
    $this->setWidget('status_date', new sfWidgetFormJQueryDate(array(
          'config' => '{}',
          'culture' => 'ru',
          'date_widget' => new sfWidgetFormDate(array('format' => '%year%%month%%day%',), array('style'=>'min-width:70px;'))
      )));
    
  }
}

class departmentsShortForm extends BasedepartmentsForm
{
  public function configure()
  {
    parent::configure();
    
    unset($this['stuff_list'], $this['client_list'], $this['groupclaim_list']);
    
    sfContext::getInstance()->getConfiguration()->loadHelpers('Url');
    
    $this->setWidget('organization_name', new sfWidgetFormInputText(array(), array('disabled' => 'disabled')));
    $this->setWidget('city_name', new sfWidgetFormInputText(array(), array('disabled' => 'disabled')));
    $this->setWidget('organization_id', new sfWidgetFormInputHidden());
    $this->setWidget('city_id', new sfWidgetFormInputHidden());
    $this->setWidget('contract_id', new sfWidgetFormInputHidden());
    
    
    
    if ($this->getOption('action') == 'show')
    {
      $org_id = $this->getObject()->_data['organization_id'];
      $city_id = $this->getObject()->_data['city_id'];
      
      $contract_id = contractTable::getContractIdByOrganizationId($org_id);
    
      $this->setDefault('organization_id', $org_id);
      $this->setDefault('city_id', $city_id);
      $this->setDefault('contract_id', $contract_id);
      
      $org_name = organizationTable::getInstance()->find($org_id);
      $city_name = cityTable::getInstance()->find($city_id);
      
      $this->setDefault('organization_name', $org_name);
      $this->setDefault('city_name', $city_name);
    }
    
    
    $this->setValidator('organization_id', new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Organization'), 'required' => false))); 
    $this->setValidator('city_id', new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('City'), 'required' => false))); 
    
    $this->useFields(array(
      'mpk',
      'address',
      'organization_name',
      'city_name',
      'organization_id',
      'contract_id',
      'city_id',
    ));
  }
  
  public function updateObject($values = null)
  {
    if (null === $values)
    {
      $values = $this->values;
    }
    
    $values['name'] = $values['address'];
    
    return parent::updateObject($values);
  }

  public function save($con = null)
  {
    $isNew = $this->isNew();

    $object = parent::save();

    if (GlobalFunctions::isSuperKurator() && $isNew)
    {
      $stuffId = GlobalFunctions::getStuffId();
      $stuffDepartments = Doctrine::getTable('stuff_departments')
        ->createQuery('sd')
        ->where('stuff_id = ?' , $stuffId)
        ->addWhere('departments_id = ? ' , $object->getId())
        ->addWhere('userkey = ?', stuff_departments::KURATOR)
        ->execute();

      if (!sizeof($stuffDepartments))
      {
        stuff_departments::setStuffOnAllClaimtype(
          $object->getId($object->getId()),
          $stuffId,
          stuff_departments::KURATOR
        );
      }

    };

    return $object;
  }
}
