<?php

/**
 * contract_importance filter form base class.
 *
 * @package    helpdesk
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class Basecontract_importanceFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'contract_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('contract'), 'add_empty' => true)),
      'importance_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('importance'), 'add_empty' => true)),
      'organization_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Organization'), 'add_empty' => true)),
      'duration'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'contract_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('contract'), 'column' => 'id')),
      'importance_id'   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('importance'), 'column' => 'id')),
      'organization_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Organization'), 'column' => 'id')),
      'duration'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('contract_importance_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'contract_importance';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'contract_id'     => 'ForeignKey',
      'importance_id'   => 'ForeignKey',
      'organization_id' => 'ForeignKey',
      'duration'        => 'Number',
    );
  }
}
