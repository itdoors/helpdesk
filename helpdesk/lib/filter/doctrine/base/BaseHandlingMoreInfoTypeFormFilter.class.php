<?php

/**
 * HandlingMoreInfoType filter form base class.
 *
 * @package    helpdesk
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseHandlingMoreInfoTypeFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'handling_result_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('HandlingResult'), 'add_empty' => true)),
      'name'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'data_type'          => new sfWidgetFormChoice(array('choices' => array('' => '', 'integer' => 'integer', 'float' => 'float', 'string' => 'string', 'select' => 'select'))),
      'enum_choices'       => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'handling_result_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('HandlingResult'), 'column' => 'id')),
      'name'               => new sfValidatorPass(array('required' => false)),
      'data_type'          => new sfValidatorChoice(array('required' => false, 'choices' => array('integer' => 'integer', 'float' => 'float', 'string' => 'string', 'select' => 'select'))),
      'enum_choices'       => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('handling_more_info_type_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'HandlingMoreInfoType';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'handling_result_id' => 'ForeignKey',
      'name'               => 'Text',
      'data_type'          => 'Enum',
      'enum_choices'       => 'Text',
    );
  }
}
