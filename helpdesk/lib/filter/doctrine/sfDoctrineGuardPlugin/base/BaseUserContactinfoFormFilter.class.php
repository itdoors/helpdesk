<?php

/**
 * UserContactinfo filter form base class.
 *
 * @package    helpdesk
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseUserContactinfoFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'contactinfo_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Contactinfo'), 'add_empty' => true)),
      'user_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => true)),
      'value'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'contactinfo_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Contactinfo'), 'column' => 'id')),
      'user_id'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('User'), 'column' => 'id')),
      'value'          => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('user_contactinfo_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'UserContactinfo';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'contactinfo_id' => 'ForeignKey',
      'user_id'        => 'ForeignKey',
      'value'          => 'Text',
    );
  }
}
