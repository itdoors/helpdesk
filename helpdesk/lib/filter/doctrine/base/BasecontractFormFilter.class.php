<?php

/**
 * contract filter form base class.
 *
 * @package    helpdesk
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasecontractFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'fileupload'      => new sfWidgetFormFilterInput(),
      'organization_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('organization'), 'add_empty' => true)),
      'createdate'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'closedate'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'importance_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'importance')),
    ));

    $this->setValidators(array(
      'name'            => new sfValidatorPass(array('required' => false)),
      'fileupload'      => new sfValidatorPass(array('required' => false)),
      'organization_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('organization'), 'column' => 'id')),
      'createdate'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'closedate'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'importance_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'importance', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('contract_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addImportanceListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.contract_importance contract_importance')
      ->andWhereIn('contract_importance.importance_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'contract';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'name'            => 'Text',
      'fileupload'      => 'Text',
      'organization_id' => 'ForeignKey',
      'createdate'      => 'Date',
      'closedate'       => 'Date',
      'importance_list' => 'ManyKey',
    );
  }
}
