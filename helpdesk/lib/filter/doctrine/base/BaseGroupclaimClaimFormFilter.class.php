<?php

/**
 * GroupclaimClaim filter form base class.
 *
 * @package    helpdesk
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseGroupclaimClaimFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'claim_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Claim'), 'add_empty' => true)),
      'groupclaim_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Groupclaim'), 'add_empty' => true)),
      'createdatetime' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'claim_id'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Claim'), 'column' => 'id')),
      'groupclaim_id'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Groupclaim'), 'column' => 'id')),
      'createdatetime' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('groupclaim_claim_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'GroupclaimClaim';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'claim_id'       => 'ForeignKey',
      'groupclaim_id'  => 'ForeignKey',
      'createdatetime' => 'Date',
    );
  }
}
