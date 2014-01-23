<?php

/**
 * workstypes filter form base class.
 *
 * @package    helpdesk
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseworkstypesFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'parent_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('workstypes'), 'add_empty' => true)),
      'name'      => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'parent_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('workstypes'), 'column' => 'id')),
      'name'      => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('workstypes_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'workstypes';
  }

  public function getFields()
  {
    return array(
      'id'        => 'Number',
      'parent_id' => 'ForeignKey',
      'name'      => 'Text',
    );
  }
}
