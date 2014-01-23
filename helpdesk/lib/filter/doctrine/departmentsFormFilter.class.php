<?php

/**
 * departments filter form.
 *
 * @package    helpdesk
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class departmentsFormFilter extends BasedepartmentsFormFilter
{
  public function configure()
  {
    $this->embedForm('region_id', new AdvancedCityFormFilter());
    //$this->embedForm('organization_list', new AdvancedContractFormFilter());
    
    sfContext::getInstance()->getConfiguration()->loadHelpers('Url');
    
    $this->setWidget('organization_id', new sfWidgetFormDoctrineJQueryAutocompleter(array(
      'model'=>'organization',
      'url'=>url_for('ajaxdata/auto_organization'),
    )));
    
    $this->setValidator('organization_id', new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Organization'), 'required' => false))); 
  }
  
  public function addRegionIdColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!$values['region_id']) return;              
     $query->leftJoin($query->getRootAlias().'.City cit')
     ->leftJoin('cit.Region reg')
     ->andWhere('reg.id = '.$values['region_id']);
     
  }
  
/*  public function addOrganizationListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!$values['organization_list']) return;
     $query->leftJoin($query->getRootAlias().'.contract cit')
     ->leftJoin('cit.organization org')
     ->andWhere('org.id = ?', $values)
     ->orWhere($query->getRootAlias().'.organization_id = ?',$values);
     
  }*/
  
}

class AdvancedCityFormFilter extends BasecityFormFilter
{
  public function configure()
  {
     $this->useFields(
       array(
         'region_id'
       )
     );
  }
}

class AdvancedContractFormFilter extends BasecityFormFilter
{
  public function configure()
  {
     $this->useFields(
       array(
         'organization_id'
       )
     );
  }
}