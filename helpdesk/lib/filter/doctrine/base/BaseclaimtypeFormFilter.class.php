<?php

/**
 * claimtype filter form base class.
 *
 * @package    helpdesk
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseclaimtypeFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'description' => new sfWidgetFormFilterInput(),
      'stuff_list'  => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'stuff')),
    ));

    $this->setValidators(array(
      'name'        => new sfValidatorPass(array('required' => false)),
      'description' => new sfValidatorPass(array('required' => false)),
      'stuff_list'  => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'stuff', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('claimtype_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
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

  public function getModelName()
  {
    return 'claimtype';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'name'        => 'Text',
      'description' => 'Text',
      'stuff_list'  => 'ManyKey',
    );
  }
}
