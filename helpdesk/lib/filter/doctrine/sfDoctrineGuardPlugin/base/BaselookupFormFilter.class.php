<?php

/**
 * lookup filter form base class.
 *
 * @package    helpdesk
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaselookupFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'lukey' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'name'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'lukey' => new sfValidatorPass(array('required' => false)),
      'name'  => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('lookup_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'lookup';
  }

  public function getFields()
  {
    return array(
      'id'    => 'Number',
      'lukey' => 'Text',
      'name'  => 'Text',
    );
  }
}
