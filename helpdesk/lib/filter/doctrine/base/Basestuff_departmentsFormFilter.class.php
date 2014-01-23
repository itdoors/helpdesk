<?php

/**
 * stuff_departments filter form base class.
 *
 * @package    helpdesk
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class Basestuff_departmentsFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('stuff_departments_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'stuff_departments';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'stuff_id'       => 'Number',
      'departments_id' => 'Number',
      'claimtype_id'   => 'Number',
      'userkey'        => 'Text',
    );
  }
}
