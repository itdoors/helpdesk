<?php

/**
 * Groupclaim filter form base class.
 *
 * @package    helpdesk
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseGroupclaimFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'                   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'claimtype_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Claimtype'), 'add_empty' => true)),
      'groupclaimwork_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Groupclaimwork'), 'add_empty' => true)),
      'formula'                => new sfWidgetFormFilterInput(),
      'client_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Client'), 'add_empty' => true)),
      'contract_importance_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ContractImportance'), 'add_empty' => true)),
      'message'                => new sfWidgetFormFilterInput(),
      'is_deleted'             => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'departments_list'       => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'departments')),
    ));

    $this->setValidators(array(
      'name'                   => new sfValidatorPass(array('required' => false)),
      'claimtype_id'           => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Claimtype'), 'column' => 'id')),
      'groupclaimwork_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Groupclaimwork'), 'column' => 'id')),
      'formula'                => new sfValidatorPass(array('required' => false)),
      'client_id'              => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Client'), 'column' => 'id')),
      'contract_importance_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('ContractImportance'), 'column' => 'id')),
      'message'                => new sfValidatorPass(array('required' => false)),
      'is_deleted'             => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'departments_list'       => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'departments', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('groupclaim_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
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
      ->leftJoin($query->getRootAlias().'.GroupclaimDepartments GroupclaimDepartments')
      ->andWhereIn('GroupclaimDepartments.departments_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Groupclaim';
  }

  public function getFields()
  {
    return array(
      'id'                     => 'Number',
      'name'                   => 'Text',
      'claimtype_id'           => 'ForeignKey',
      'groupclaimwork_id'      => 'ForeignKey',
      'formula'                => 'Text',
      'client_id'              => 'ForeignKey',
      'contract_importance_id' => 'ForeignKey',
      'message'                => 'Text',
      'is_deleted'             => 'Boolean',
      'departments_list'       => 'ManyKey',
    );
  }
}
