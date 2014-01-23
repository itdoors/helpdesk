<?php

/**
 * importance filter form base class.
 *
 * @package    helpdesk
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseimportanceFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'color'         => new sfWidgetFormFilterInput(),
      'duration'      => new sfWidgetFormFilterInput(),
      'contract_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'contract')),
    ));

    $this->setValidators(array(
      'name'          => new sfValidatorPass(array('required' => false)),
      'color'         => new sfValidatorPass(array('required' => false)),
      'duration'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'contract_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'contract', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('importance_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addContractListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->andWhereIn('contract_importance.contract_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'importance';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'name'          => 'Text',
      'color'         => 'Text',
      'duration'      => 'Number',
      'contract_list' => 'ManyKey',
    );
  }
}
