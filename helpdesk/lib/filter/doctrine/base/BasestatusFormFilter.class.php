<?php

/**
 * status filter form base class.
 *
 * @package    helpdesk
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasestatusFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'stakey'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'name'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'timereminder' => new sfWidgetFormFilterInput(),
      'color'        => new sfWidgetFormFilterInput(),
      'icon'         => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'stakey'       => new sfValidatorPass(array('required' => false)),
      'name'         => new sfValidatorPass(array('required' => false)),
      'timereminder' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'color'        => new sfValidatorPass(array('required' => false)),
      'icon'         => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('status_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'status';
  }

  public function getFields()
  {
    return array(
      'id'           => 'Number',
      'stakey'       => 'Text',
      'name'         => 'Text',
      'timereminder' => 'Number',
      'color'        => 'Text',
      'icon'         => 'Text',
    );
  }
}
