<?php

/**
 * claimusers filter form base class.
 *
 * @package    helpdesk
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseclaimusersFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Users'), 'add_empty' => true)),
      'claim_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Claim'), 'add_empty' => true)),
      'userkey'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'isread'   => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'user_id'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Users'), 'column' => 'id')),
      'claim_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Claim'), 'column' => 'id')),
      'userkey'  => new sfValidatorPass(array('required' => false)),
      'isread'   => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('claimusers_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'claimusers';
  }

  public function getFields()
  {
    return array(
      'id'       => 'Number',
      'user_id'  => 'ForeignKey',
      'claim_id' => 'ForeignKey',
      'userkey'  => 'Text',
      'isread'   => 'Boolean',
    );
  }
}
