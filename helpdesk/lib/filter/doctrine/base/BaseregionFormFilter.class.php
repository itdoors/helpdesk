<?php

/**
 * region filter form base class.
 *
 * @package    helpdesk
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseregionFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'                  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'square'                => new sfWidgetFormFilterInput(),
      'population'            => new sfWidgetFormFilterInput(),
      'flag'                  => new sfWidgetFormFilterInput(),
      'companystructure_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'companystructure')),
    ));

    $this->setValidators(array(
      'name'                  => new sfValidatorPass(array('required' => false)),
      'square'                => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'population'            => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'flag'                  => new sfValidatorPass(array('required' => false)),
      'companystructure_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'companystructure', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('region_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addCompanystructureListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->andWhereIn('companystructure_region.companystructure_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'region';
  }

  public function getFields()
  {
    return array(
      'id'                    => 'Number',
      'name'                  => 'Text',
      'square'                => 'Number',
      'population'            => 'Number',
      'flag'                  => 'Text',
      'companystructure_list' => 'ManyKey',
    );
  }
}
