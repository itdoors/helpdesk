<?php
  
class EntityFormFilter extends BasedepartmentsFormFilter
{
  public function configure()
  {
    sfContext::getInstance()->getConfiguration()->loadHelpers('Url');
    
    $this->setWidget('mpk', new sfWidgetFormInputText());
    
    $this->setWidget('organization_id', new sfWidgetFormDoctrineJQueryAutocompleter(array(
      'model'=>'organization',
      'url'=>url_for('ajaxdata/auto_organization'),
    )));
    
    $this->setWidget('region_id', new sfWidgetFormDoctrineChoice(
      array(
        'add_empty' => true,
        'model' => 'region',
        'order_by' => array('name', 'ASC')
      )
    ));
    
    $this->setWidget('city_id', new sfWidgetFormDoctrineChoice(
      array(
        'add_empty' => true,
        'model' => 'city',
        'order_by' => array('name', 'ASC')
      )
    ));
    
    $this->setWidget('companystructure_id', new sfWidgetFormDoctrineChoice(
      array(
        'add_empty' => true,
        'model' => 'companystructure',
        'order_by' => array('name', 'ASC')
      )
    ));
    
    $this->setWidget('status_id', new sfWidgetFormDoctrineChoice(
      array(
        'add_empty' => true,
        'model' => 'DepartmentsStatus',
        'order_by' => array('name', 'ASC')
      )
    ));
    
    $this->setWidget('departments_type_id', new sfWidgetFormDoctrineChoice(
      array(
        'add_empty' => true,
        'model' => 'DepartmentsType',
        'order_by' => array('name', 'ASC')
      )
    ));
    
    $this->setWidget('address', new sfWidgetFormInputText()); 
    
    $this->setValidator('mpk', new sfValidatorString()); 
    $this->setValidator('organization_id', new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Organization'), 'required' => false))); 
    $this->setValidator('region_id', new sfValidatorInteger()); 
    $this->setValidator('city_id', new sfValidatorInteger()); 
    $this->setValidator('companystructure_id', new sfValidatorInteger()); 
    $this->setValidator('status_id', new sfValidatorInteger()); 
    $this->setValidator('departments_type_id', new sfValidatorInteger()); 
    $this->setValidator('address', new sfValidatorString()); 
    
    $this->useFields(array(
      'mpk',
      'organization_id',
      'companystructure_id',
      'region_id',
      'city_id',
      'status_id',
      'departments_type_id',
      'address',
    ));
  }
}
