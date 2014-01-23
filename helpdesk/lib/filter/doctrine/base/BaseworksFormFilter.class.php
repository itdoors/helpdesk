<?php

/**
 * works filter form base class.
 *
 * @package    helpdesk
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseworksFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'income_nonnds' => new sfWidgetFormFilterInput(),
      'costs_n'       => new sfWidgetFormFilterInput(),
      'costs_nonnds'  => new sfWidgetFormFilterInput(),
      'status_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Status'), 'add_empty' => true)),
      'workstypes_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('workstypes'), 'add_empty' => true)),
      'claim_list'    => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'claim')),
    ));

    $this->setValidators(array(
      'name'          => new sfValidatorPass(array('required' => false)),
      'income_nonnds' => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'costs_n'       => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'costs_nonnds'  => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'status_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Status'), 'column' => 'id')),
      'workstypes_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('workstypes'), 'column' => 'id')),
      'claim_list'    => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'claim', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('works_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addClaimListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->andWhereIn('claim_works.claim_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'works';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'name'          => 'Text',
      'income_nonnds' => 'Number',
      'costs_n'       => 'Number',
      'costs_nonnds'  => 'Number',
      'status_id'     => 'ForeignKey',
      'workstypes_id' => 'ForeignKey',
      'claim_list'    => 'ManyKey',
    );
  }
}
