<?php

/**
 * claim filter form base class.
 *
 * @package    helpdesk
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseclaimFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'mpk'                        => new sfWidgetFormFilterInput(),
      'claimtype_id'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Claimtype'), 'add_empty' => true)),
      'departments_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Departments'), 'add_empty' => true)),
      'createdatetime'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'isclosedclient'             => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'status_id'                  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Status'), 'add_empty' => true)),
      'smeta_status_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('SmetaStatus'), 'add_empty' => true)),
      'closedatetime'              => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'contract_importance_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ContractImportance'), 'add_empty' => true)),
      'organization_importance_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('OrganizationImportance'), 'add_empty' => true)),
      'description'                => new sfWidgetFormFilterInput(),
      'stuffdescription'           => new sfWidgetFormFilterInput(),
      'ourcosts'                   => new sfWidgetFormFilterInput(),
      'isclosedstuff'              => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'bill_number'                => new sfWidgetFormFilterInput(),
      'bill_description'           => new sfWidgetFormFilterInput(),
      'bill_date'                  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'akt_date'                   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'smeta_costs'                => new sfWidgetFormFilterInput(),
      'smeta_number'               => new sfWidgetFormFilterInput(),
      'organization_type_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('OrganizationType'), 'add_empty' => true)),
      'documents_list'             => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Documents')),
      'works_list'                 => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'works')),
    ));

    $this->setValidators(array(
      'mpk'                        => new sfValidatorPass(array('required' => false)),
      'claimtype_id'               => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Claimtype'), 'column' => 'id')),
      'departments_id'             => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Departments'), 'column' => 'id')),
      'createdatetime'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'isclosedclient'             => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'status_id'                  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Status'), 'column' => 'id')),
      'smeta_status_id'            => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('SmetaStatus'), 'column' => 'id')),
      'closedatetime'              => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'contract_importance_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('ContractImportance'), 'column' => 'id')),
      'organization_importance_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('OrganizationImportance'), 'column' => 'id')),
      'description'                => new sfValidatorPass(array('required' => false)),
      'stuffdescription'           => new sfValidatorPass(array('required' => false)),
      'ourcosts'                   => new sfValidatorPass(array('required' => false)),
      'isclosedstuff'              => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'bill_number'                => new sfValidatorPass(array('required' => false)),
      'bill_description'           => new sfValidatorPass(array('required' => false)),
      'bill_date'                  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'akt_date'                   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'smeta_costs'                => new sfValidatorPass(array('required' => false)),
      'smeta_number'               => new sfValidatorPass(array('required' => false)),
      'organization_type_id'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('OrganizationType'), 'column' => 'id')),
      'documents_list'             => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Documents', 'required' => false)),
      'works_list'                 => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'works', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('claim_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addDocumentsListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.DocumentsClaim DocumentsClaim')
      ->andWhereIn('DocumentsClaim.documents_id', $values)
    ;
  }

  public function addWorksListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.claim_works claim_works')
      ->andWhereIn('claim_works.works_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'claim';
  }

  public function getFields()
  {
    return array(
      'id'                         => 'Number',
      'mpk'                        => 'Text',
      'claimtype_id'               => 'ForeignKey',
      'departments_id'             => 'ForeignKey',
      'createdatetime'             => 'Date',
      'isclosedclient'             => 'Boolean',
      'status_id'                  => 'ForeignKey',
      'smeta_status_id'            => 'ForeignKey',
      'closedatetime'              => 'Date',
      'contract_importance_id'     => 'ForeignKey',
      'organization_importance_id' => 'ForeignKey',
      'description'                => 'Text',
      'stuffdescription'           => 'Text',
      'ourcosts'                   => 'Text',
      'isclosedstuff'              => 'Boolean',
      'bill_number'                => 'Text',
      'bill_description'           => 'Text',
      'bill_date'                  => 'Date',
      'akt_date'                   => 'Date',
      'smeta_costs'                => 'Text',
      'smeta_number'               => 'Text',
      'organization_type_id'       => 'ForeignKey',
      'documents_list'             => 'ManyKey',
      'works_list'                 => 'ManyKey',
    );
  }
}
