<?php

/**
 * DogovorHandling filter form base class.
 *
 * @package    helpdesk
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseDogovorHandlingFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'dogovor_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Dogovor'), 'add_empty' => true)),
      'handling_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Handling'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'dogovor_id'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Dogovor'), 'column' => 'id')),
      'handling_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Handling'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('dogovor_handling_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'DogovorHandling';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'dogovor_id'  => 'ForeignKey',
      'handling_id' => 'ForeignKey',
    );
  }
}
