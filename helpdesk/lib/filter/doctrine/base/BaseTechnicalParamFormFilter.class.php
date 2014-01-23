<?php

/**
 * TechnicalParam filter form base class.
 *
 * @package    helpdesk
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseTechnicalParamFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'type_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TechnicalParamType'), 'add_empty' => true)),
      'sort'    => new sfWidgetFormFilterInput(),
      'unit'    => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'name'    => new sfValidatorPass(array('required' => false)),
      'type_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TechnicalParamType'), 'column' => 'id')),
      'sort'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'unit'    => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('technical_param_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'TechnicalParam';
  }

  public function getFields()
  {
    return array(
      'id'      => 'Number',
      'name'    => 'Text',
      'type_id' => 'ForeignKey',
      'sort'    => 'Number',
      'unit'    => 'Text',
    );
  }
}
