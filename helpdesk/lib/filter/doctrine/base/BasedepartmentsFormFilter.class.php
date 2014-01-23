<?php

/**
 * departments filter form base class.
 *
 * @package    helpdesk
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasedepartmentsFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'mpk'                 => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'name'                => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'fullname'            => new sfWidgetFormFilterInput(),
      'city_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('City'), 'add_empty' => true)),
      'address'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'contract_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('contract'), 'add_empty' => true)),
      'organization_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Organization'), 'add_empty' => true)),
      'square'              => new sfWidgetFormFilterInput(),
      'isdeleted'           => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'added_field'         => new sfWidgetFormFilterInput(),
      'status_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Status'), 'add_empty' => true)),
      'status_date'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'departments_type_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DepartmentsType'), 'add_empty' => true)),
      'description'         => new sfWidgetFormFilterInput(),
      'coordinates'         => new sfWidgetFormFilterInput(),
      'client_list'         => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'client')),
      'stuff_list'          => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'stuff')),
      'groupclaim_list'     => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Groupclaim')),
    ));

    $this->setValidators(array(
      'mpk'                 => new sfValidatorPass(array('required' => false)),
      'name'                => new sfValidatorPass(array('required' => false)),
      'fullname'            => new sfValidatorPass(array('required' => false)),
      'city_id'             => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('City'), 'column' => 'id')),
      'address'             => new sfValidatorPass(array('required' => false)),
      'contract_id'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('contract'), 'column' => 'id')),
      'organization_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Organization'), 'column' => 'id')),
      'square'              => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'isdeleted'           => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'added_field'         => new sfValidatorPass(array('required' => false)),
      'status_id'           => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Status'), 'column' => 'id')),
      'status_date'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'departments_type_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('DepartmentsType'), 'column' => 'id')),
      'description'         => new sfValidatorPass(array('required' => false)),
      'coordinates'         => new sfValidatorPass(array('required' => false)),
      'client_list'         => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'client', 'required' => false)),
      'stuff_list'          => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'stuff', 'required' => false)),
      'groupclaim_list'     => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Groupclaim', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('departments_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addClientListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.client_departments client_departments')
      ->andWhereIn('client_departments.client_id', $values)
    ;
  }

  public function addStuffListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.stuff_departments stuff_departments')
      ->andWhereIn('stuff_departments.stuff_id', $values)
    ;
  }

  public function addGroupclaimListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.GroupclaimDepartments GroupclaimDepartments')
      ->andWhereIn('GroupclaimDepartments.groupclaim_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'departments';
  }

  public function getFields()
  {
    return array(
      'id'                  => 'Number',
      'mpk'                 => 'Text',
      'name'                => 'Text',
      'fullname'            => 'Text',
      'city_id'             => 'ForeignKey',
      'address'             => 'Text',
      'contract_id'         => 'ForeignKey',
      'organization_id'     => 'ForeignKey',
      'square'              => 'Number',
      'isdeleted'           => 'Boolean',
      'added_field'         => 'Text',
      'status_id'           => 'ForeignKey',
      'status_date'         => 'Date',
      'departments_type_id' => 'ForeignKey',
      'description'         => 'Text',
      'coordinates'         => 'Text',
      'client_list'         => 'ManyKey',
      'stuff_list'          => 'ManyKey',
      'groupclaim_list'     => 'ManyKey',
    );
  }
}
