<?php

/**
 * organization_importance filter form base class.
 *
 * @package    helpdesk
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class Baseorganization_importanceFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'organization_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Organization'), 'add_empty' => true)),
      'importance_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Importance'), 'add_empty' => true)),
      'duration'        => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'organization_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Organization'), 'column' => 'id')),
      'importance_id'   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Importance'), 'column' => 'id')),
      'duration'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('organization_importance_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'organization_importance';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'organization_id' => 'ForeignKey',
      'importance_id'   => 'ForeignKey',
      'duration'        => 'Number',
    );
  }
}
