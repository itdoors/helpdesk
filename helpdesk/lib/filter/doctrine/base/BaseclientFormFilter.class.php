<?php

/**
 * client filter form base class.
 *
 * @package    helpdesk
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseclientFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'phone'              => new sfWidgetFormFilterInput(),
      'mobilephone'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'user_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Users'), 'add_empty' => true)),
      'organization_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Organization'), 'add_empty' => true)),
      'show_added_field'   => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_mailed'          => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'organizations_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'organization')),
      'departments_list'   => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'departments')),
    ));

    $this->setValidators(array(
      'phone'              => new sfValidatorPass(array('required' => false)),
      'mobilephone'        => new sfValidatorPass(array('required' => false)),
      'user_id'            => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Users'), 'column' => 'id')),
      'organization_id'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Organization'), 'column' => 'id')),
      'show_added_field'   => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_mailed'          => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'organizations_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'organization', 'required' => false)),
      'departments_list'   => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'departments', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('client_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addOrganizationsListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.ClientOrganization ClientOrganization')
      ->andWhereIn('ClientOrganization.organization_id', $values)
    ;
  }

  public function addDepartmentsListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->andWhereIn('client_departments.departments_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'client';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'phone'              => 'Text',
      'mobilephone'        => 'Text',
      'user_id'            => 'ForeignKey',
      'organization_id'    => 'ForeignKey',
      'show_added_field'   => 'Boolean',
      'is_mailed'          => 'Boolean',
      'organizations_list' => 'ManyKey',
      'departments_list'   => 'ManyKey',
    );
  }
}
