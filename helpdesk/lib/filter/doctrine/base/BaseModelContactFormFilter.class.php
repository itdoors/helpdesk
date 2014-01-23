<?php

/**
 * ModelContact filter form base class.
 *
 * @package    helpdesk
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseModelContactFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'model_name'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'model_id'    => new sfWidgetFormFilterInput(),
      'sort'        => new sfWidgetFormFilterInput(),
      'first_name'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'last_name'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'middle_name' => new sfWidgetFormFilterInput(),
      'phone1'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'phone2'      => new sfWidgetFormFilterInput(),
      'position'    => new sfWidgetFormFilterInput(),
      'email'       => new sfWidgetFormFilterInput(),
      'birthday'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'model_name'  => new sfValidatorPass(array('required' => false)),
      'model_id'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'sort'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'first_name'  => new sfValidatorPass(array('required' => false)),
      'last_name'   => new sfValidatorPass(array('required' => false)),
      'middle_name' => new sfValidatorPass(array('required' => false)),
      'phone1'      => new sfValidatorPass(array('required' => false)),
      'phone2'      => new sfValidatorPass(array('required' => false)),
      'position'    => new sfValidatorPass(array('required' => false)),
      'email'       => new sfValidatorPass(array('required' => false)),
      'birthday'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('model_contact_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ModelContact';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'model_name'  => 'Text',
      'model_id'    => 'Number',
      'sort'        => 'Number',
      'first_name'  => 'Text',
      'last_name'   => 'Text',
      'middle_name' => 'Text',
      'phone1'      => 'Text',
      'phone2'      => 'Text',
      'position'    => 'Text',
      'email'       => 'Text',
      'birthday'    => 'Date',
    );
  }
}
