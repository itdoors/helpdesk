<?php

/**
 * attach filter form base class.
 *
 * @package    helpdesk
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseattachFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'filename'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'filepath'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'comments_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Comments'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'filename'    => new sfValidatorPass(array('required' => false)),
      'filepath'    => new sfValidatorPass(array('required' => false)),
      'comments_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Comments'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('attach_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'attach';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'filename'    => 'Text',
      'filepath'    => 'Text',
      'comments_id' => 'ForeignKey',
    );
  }
}
