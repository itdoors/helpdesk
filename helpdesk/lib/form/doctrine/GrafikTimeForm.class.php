<?php

/**
 * GrafikTime form.
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class GrafikTimeForm extends BaseGrafikTimeForm
{
  public function configure()
  {
    sfContext::getInstance()->getConfiguration()->loadHelpers('Url');

    $this->i18n = sfContext::getInstance()->getI18N();

    $this->setWidget('from_time', new helpdeskWidgetFormTime());
    $this->setWidget('to_time', new helpdeskWidgetFormTime());
    $this->getWidget('to_time')->setOption('range_type', 'to');

    $this->setValidator('year', new sfValidatorInteger());
    $this->setValidator('month', new sfValidatorInteger());
    $this->setValidator('day', new sfValidatorInteger());
    $this->setValidator('department_id', new sfValidatorInteger());
    $this->setValidator('department_people_id', new sfValidatorInteger());
    $this->setValidator('department_people_replacement_id', new sfValidatorInteger());

    $this->validatorSchema->setPostValidator(
      new sfValidatorAnd(
        array(
          new sfValidatorCallback(
            array(
              'callback' => array($this, 'checkTime'),
            )
          ),
          new sfValidatorCallback(
            array(
              'callback' => array($this, 'checkIsOfficial'),
            )
          )
        ))
    );

    if ($this->getObject()->isNew())
    {
      $this->setDefaultTime();
    }

    $this->disableCSRFProtection();

    $this->useFields(array(
      'from_time',
      'to_time',
      'not_officially',
      'year',
      'month',
      'day',
      'department_id',
      'department_people_id',
      'department_people_replacement_id',
      'replacement_type'
    ));
  }

  protected function setDefaultTime()
  {
    $this->getWidget('from_time')->setOption('default_time', array('hour' => 9));
    $this->getWidget('to_time')->setOption('default_time', array('hour' => 18));
  }

  public function save($con = null)
  {
    /** @var GrafikTime $object*/
    $object = parent::save();

    $object->recount();

    /** @var Grafik $grafik*/
    $grafik = Grafik::findOrCreateGrafik($object->toArray());

    $grafik->recount();

    return $object;
  }

  public function checkTime($validator, $values, $arguments)
  {
    $isNew = $this->isNew();

    $form_time = $values['from_time'];
    $to_time = $values['to_time'];

    $from_time_timestamp = strtotime($form_time);
    $to_time_timestamp = $to_time == '00:00:00' ? strtotime('23:00:00') + 3600 : strtotime($to_time);

    $diff = ($to_time_timestamp - $from_time_timestamp)/3600;

    if ( $diff <= 0 )
    {
      $error = $this->i18n->__('Invalid. Enter correct time range');
      throw new sfValidatorError($validator, $error);
    }

    //check if total < 24

    //check if new hours not in already saved hours

    $params = $isNew ? $values : $this->getObject()->toArray();

    //if not new current record dont use to validate
    $id = $isNew ? null : $this->getObject()->getId();

    $grafikTimes = Grafik::getGrafikTimes($params, $id);

    foreach ($grafikTimes as $grafikTime)
    {
      $from_temp_timestamp = strtotime($grafikTime->getFromTime());
      $to_temp_timestamp = strtotime($grafikTime->getToTime());

      if (
        (($from_temp_timestamp < $from_time_timestamp) &&  ($from_time_timestamp < $to_temp_timestamp))
      )
      {
        $error = $this->i18n->__('Invalid. Enter correct time range. From time error');
        throw new sfValidatorError($validator, $error);
      }

      if (
      (($from_temp_timestamp < $to_time_timestamp) &&  ($to_time_timestamp < $to_temp_timestamp))
      )
      {
        $error = $this->i18n->__('Invalid. Enter correct time range. To time error');
        throw new sfValidatorError($validator, $error);
      }

      if (
      (($from_time_timestamp <= $from_temp_timestamp) &&  ($to_temp_timestamp <= $to_time_timestamp))
      )
      {
        $error = $this->i18n->__('Invalid. Enter correct time range. From-to time error');
        throw new sfValidatorError($validator, $error);
      }
    }

    return $values;
  }

  public function checkIsOfficial($validator, $values, $arguments)
  {
    if ($values['not_officially'] == false) {
      /** @var DepartmentPeople $person */
      $person = Doctrine::getTable('DepartmentPeople')->findOneBy('id', $values['department_people_id']);

      $person->setParamMonth($values['month']);
      $person->setParamYear($values['year']);
      $person->setParamReplacementId($values['department_people_replacement_id']);
      $person->setParamReplacementType($values['replacement_type']);

      if (!$person->isOfficial()) {
        $error = $this->i18n->__("Invalid. Person can't work officially");
        throw new sfValidatorError($validator, $error);
      }

      if ($values['department_people_replacement_id']) {
        /** @var DepartmentPeople $personReplacement */
        $personReplacement  = Doctrine::getTable('DepartmentPeople')->findOneBy('id', $values['department_people_replacement_id']);

        if (!$personReplacement->isOfficial()) {
          $error = $this->i18n->__("Invalid. Person can't work officially");
          throw new sfValidatorError($validator, $error);
        }
      }
    }

    return $values;
  }

  public function unsetDefaults()
  {
    unset(
     $this['department_id'],
     $this['department_people_id'],
     $this['department_people_replacement_id'],
     $this['day'],
     $this['month'],
     $this['year']);
  }
}
