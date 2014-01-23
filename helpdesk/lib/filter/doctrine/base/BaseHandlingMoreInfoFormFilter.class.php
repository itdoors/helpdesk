<?php

/**
 * HandlingMoreInfo filter form base class.
 *
 * @package    helpdesk
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseHandlingMoreInfoFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'handling_id'                => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Handling'), 'add_empty' => true)),
      'handling_more_info_type_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('HandlingMoreInfoType'), 'add_empty' => true)),
      'value'                      => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'handling_id'                => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Handling'), 'column' => 'id')),
      'handling_more_info_type_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('HandlingMoreInfoType'), 'column' => 'id')),
      'value'                      => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('handling_more_info_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'HandlingMoreInfo';
  }

  public function getFields()
  {
    return array(
      'id'                         => 'Number',
      'handling_id'                => 'ForeignKey',
      'handling_more_info_type_id' => 'ForeignKey',
      'value'                      => 'Text',
    );
  }
}
