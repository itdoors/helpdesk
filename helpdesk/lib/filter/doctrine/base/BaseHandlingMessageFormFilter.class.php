<?php

/**
 * HandlingMessage filter form base class.
 *
 * @package    helpdesk
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseHandlingMessageFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'type_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('HandlingMessageType'), 'add_empty' => true)),
      'createdatetime' => new sfWidgetFormFilterInput(),
      'createdate'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'description'    => new sfWidgetFormFilterInput(),
      'handling_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Handling'), 'add_empty' => true)),
      'user_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => true)),
      'filename'       => new sfWidgetFormFilterInput(),
      'filepath'       => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'type_id'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('HandlingMessageType'), 'column' => 'id')),
      'createdatetime' => new sfValidatorPass(array('required' => false)),
      'createdate'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'description'    => new sfValidatorPass(array('required' => false)),
      'handling_id'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Handling'), 'column' => 'id')),
      'user_id'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('User'), 'column' => 'id')),
      'filename'       => new sfValidatorPass(array('required' => false)),
      'filepath'       => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('handling_message_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'HandlingMessage';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'type_id'        => 'ForeignKey',
      'createdatetime' => 'Text',
      'createdate'     => 'Date',
      'description'    => 'Text',
      'handling_id'    => 'ForeignKey',
      'user_id'        => 'ForeignKey',
      'filename'       => 'Text',
      'filepath'       => 'Text',
    );
  }
}
