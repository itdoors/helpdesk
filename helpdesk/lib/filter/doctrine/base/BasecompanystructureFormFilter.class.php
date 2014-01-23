<?php

/**
 * companystructure filter form base class.
 *
 * @package    helpdesk
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasecompanystructureFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'parent_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('companystructure'), 'add_empty' => true)),
      'name'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'mpk'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'address'     => new sfWidgetFormFilterInput(),
      'phone'       => new sfWidgetFormFilterInput(),
      'stuff_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Stuff'), 'add_empty' => true)),
      'region_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'region')),
    ));

    $this->setValidators(array(
      'parent_id'   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('companystructure'), 'column' => 'id')),
      'name'        => new sfValidatorPass(array('required' => false)),
      'mpk'         => new sfValidatorPass(array('required' => false)),
      'address'     => new sfValidatorPass(array('required' => false)),
      'phone'       => new sfValidatorPass(array('required' => false)),
      'stuff_id'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Stuff'), 'column' => 'id')),
      'region_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'region', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('companystructure_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addRegionListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.companystructure_region companystructure_region')
      ->andWhereIn('companystructure_region.region_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'companystructure';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'parent_id'   => 'ForeignKey',
      'name'        => 'Text',
      'mpk'         => 'Text',
      'address'     => 'Text',
      'phone'       => 'Text',
      'stuff_id'    => 'ForeignKey',
      'region_list' => 'ManyKey',
    );
  }
}
