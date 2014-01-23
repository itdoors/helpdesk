<?php

/**
 * city filter form base class.
 *
 * @package    helpdesk
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasecityFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'region_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Region'), 'add_empty' => true)),
      'district_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('District'), 'add_empty' => true)),
      'population'  => new sfWidgetFormFilterInput(),
      'square'      => new sfWidgetFormFilterInput(),
      'density'     => new sfWidgetFormFilterInput(),
      'citytype'    => new sfWidgetFormChoice(array('choices' => array('' => '', 'м' => 'м', 'смт' => 'смт', 'с' => 'с'))),
      'stuff_list'  => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'stuff')),
    ));

    $this->setValidators(array(
      'name'        => new sfValidatorPass(array('required' => false)),
      'region_id'   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Region'), 'column' => 'id')),
      'district_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('District'), 'column' => 'id')),
      'population'  => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'square'      => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'density'     => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'citytype'    => new sfValidatorChoice(array('required' => false, 'choices' => array('м' => 'м', 'смт' => 'смт', 'с' => 'с'))),
      'stuff_list'  => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'stuff', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('city_filters[%s]');

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
      ->leftJoin($query->getRootAlias().'.sfuff_city sfuff_city')
      ->andWhereIn('sfuff_city.stuff_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'city';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'name'        => 'Text',
      'region_id'   => 'ForeignKey',
      'district_id' => 'ForeignKey',
      'population'  => 'Number',
      'square'      => 'Number',
      'density'     => 'Number',
      'citytype'    => 'Enum',
      'stuff_list'  => 'ManyKey',
    );
  }
}
