<?php

/**
 * Groupclaimperiod filter form base class.
 *
 * @package    helpdesk
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseGroupclaimperiodFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'groupclaim_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Groupclaim'), 'add_empty' => true)),
      'period_day'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'period_month'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'period_year'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'groupclaim_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Groupclaim'), 'column' => 'id')),
      'period_day'    => new sfValidatorPass(array('required' => false)),
      'period_month'  => new sfValidatorPass(array('required' => false)),
      'period_year'   => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('groupclaimperiod_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Groupclaimperiod';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'groupclaim_id' => 'ForeignKey',
      'period_day'    => 'Text',
      'period_month'  => 'Text',
      'period_year'   => 'Text',
    );
  }
}
