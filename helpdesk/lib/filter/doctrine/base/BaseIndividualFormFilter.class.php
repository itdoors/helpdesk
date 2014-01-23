<?php

/**
 * Individual filter form base class.
 *
 * @package    helpdesk
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseIndividualFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'guid'        => new sfWidgetFormFilterInput(),
      'first_name'  => new sfWidgetFormFilterInput(),
      'middle_name' => new sfWidgetFormFilterInput(),
      'last_name'   => new sfWidgetFormFilterInput(),
      'birthday'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'tin'         => new sfWidgetFormFilterInput(),
      'passport'    => new sfWidgetFormFilterInput(),
      'phone'       => new sfWidgetFormFilterInput(),
      'address'     => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'guid'        => new sfValidatorPass(array('required' => false)),
      'first_name'  => new sfValidatorPass(array('required' => false)),
      'middle_name' => new sfValidatorPass(array('required' => false)),
      'last_name'   => new sfValidatorPass(array('required' => false)),
      'birthday'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'tin'         => new sfValidatorPass(array('required' => false)),
      'passport'    => new sfValidatorPass(array('required' => false)),
      'phone'       => new sfValidatorPass(array('required' => false)),
      'address'     => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('individual_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Individual';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'guid'        => 'Text',
      'first_name'  => 'Text',
      'middle_name' => 'Text',
      'last_name'   => 'Text',
      'birthday'    => 'Date',
      'tin'         => 'Text',
      'passport'    => 'Text',
      'phone'       => 'Text',
      'address'     => 'Text',
    );
  }
}
