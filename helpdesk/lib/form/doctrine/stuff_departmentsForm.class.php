<?php

/**
 * stuff_departments form.
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class stuff_departmentsFormNew extends Basestuff_departmentsForm
{
  public function configure()
  {
      //parent::setup();
      unset(
       $this['claimtype_id'],
       $this['stuff_id'],
       $this['departments_id'],
       $this['userkey']
       ); 
       $choices = array(
        sfConfig::get('claimuserkey_kurator') => sfConfig::get('claimuserkey_kurator'),
        sfConfig::get('claimuserkey_stuff') => sfConfig::get('claimuserkey_stuff'),
        );
      $this->setWidget('id',  new sfWidgetFormInputHidden());
      $this->setWidget('stuff_id', new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Stuff'), 'add_empty' => false)));
      $this->setWidget('userkey', new sfWidgetFormChoice(array('choices' => $choices)));
      $this->setWidget('claimtype_id', new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Claimtype'), 'add_empty' => false,'multiple' => true)));
      //$this->setWidget('claimtype_id', new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Claimtype'), 'add_empty' => false)));
      $this->setWidget('departments_id', new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Departments'), 'add_empty' => false, 'table_method'=>'getAllSortDepartments','method'=>'getFullDepartment','multiple' => true)));
      
      
      
      $this->setValidator('id', new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)));
      $this->setValidator('claimtype_id', new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Claimtype'), 'multiple' => true)));
      //$this->setValidator('claimtype_id', new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Claimtype'))));
      $this->setValidator('departments_id', new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Departments'),'multiple' => true)));
      $this->setValidator('stuff_id', new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Stuff'))));
      $this->setValidator('userkey', new sfValidatorString(array('max_length' => 255, 'required' => false)));
      
      $this->widgetSchema->setNameFormat('stuff_departments[%s]');

 
    
      
  }
}

class stuff_departmentsForm extends Basestuff_departmentsForm
{
  public function configure()
  {
      //parent::setup();
      unset(
       $this['claimtype_id'],
       $this['stuff_id'],
       $this['departments_id'],
       $this['userkey']
       ); 
       $choices = array(
        sfConfig::get('claimuserkey_kurator') => sfConfig::get('claimuserkey_kurator'),
        sfConfig::get('claimuserkey_stuff') => sfConfig::get('claimuserkey_stuff'),
        );
      $this->setWidget('id',  new sfWidgetFormInputHidden());
      $this->setWidget('stuff_id', new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Stuff'), 'add_empty' => false)));
      $this->setWidget('userkey', new sfWidgetFormChoice(array('choices' => $choices)));
      //$this->setWidget('claimtype_id', new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Claimtype'), 'add_empty' => false,'multiple' => true)));
      $this->setWidget('claimtype_id', new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Claimtype'), 'add_empty' => false)));
      $this->setWidget('departments_id', new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Departments'), 'add_empty' => false)));
      
      
      
      $this->setValidator('id', new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)));
      //$this->setValidator('claimtype_id', new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Claimtype'), 'multiple' => true)));
      $this->setValidator('claimtype_id', new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Claimtype'))));
      $this->setValidator('departments_id', new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Departments'))));
      $this->setValidator('stuff_id', new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Stuff'))));
      $this->setValidator('userkey', new sfValidatorString(array('max_length' => 255, 'required' => false)));
      
      $this->widgetSchema->setNameFormat('stuff_departments[%s]');

 
    
      
  }
}

class stuff_departments_personForm extends Basestuff_departmentsForm
{
  public function configure()
  {
      //parent::setup();
      unset(
       $this['claimtype_id'],
       $this['stuff_id'],
       $this['departments_id'],
       $this['userkey']
       ); 
       $choices = array(
        sfConfig::get('claimuserkey_kurator') => sfConfig::get('claimuserkey_kurator'),
        sfConfig::get('claimuserkey_stuff') => sfConfig::get('claimuserkey_stuff'),
        );
      $this->setWidget('id',  new sfWidgetFormInputHidden());
      $this->setWidget('stuff_id', new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Stuff'), 'add_empty' => false, 'table_method'=>'getAllPersons')));
      $this->setWidget('userkey', new sfWidgetFormChoice(array('choices' => $choices)));
      $this->setWidget('claimtype_id', new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Claimtype'), 'add_empty' => false,'multiple' => true)));
      //$this->setWidget('claimtype_id', new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Claimtype'), 'add_empty' => false)));
    //  $this->setWidget('departments_id', new sfWidgetFormInputHidden());
      
      
      
      $this->setValidator('id', new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)));
      //$this->setValidator('claimtype_id', new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Claimtype'), 'multiple' => true)));
      $this->setValidator('claimtype_id', new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Claimtype'))));
      $this->setValidator('departments_id', new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Departments'))));
      $this->setValidator('stuff_id', new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Stuff'))));
      $this->setValidator('userkey', new sfValidatorString(array('max_length' => 255, 'required' => false)));
      
      $this->widgetSchema->setNameFormat('stuff_departments[%s]');

 
    
      
  }
}