<?php

/**
 * Grafik form.
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class GrafikForm extends BaseGrafikForm
{
  public function configure()
  {
    unset($this['total'], $this['total_day'], $this['total_evening'], $this['total_night']);

    $this->i18n = sfContext::getInstance()->getI18N();

    $this->setValidator('year', new sfValidatorInteger());
    $this->setValidator('month', new sfValidatorInteger());
    $this->setValidator('day', new sfValidatorInteger());
    $this->setValidator('department_id', new sfValidatorInteger());
    $this->setValidator('department_people_id', new sfValidatorInteger());

    $this->setWidget('until_the_end_of_the_month', new sfWidgetFormInputCheckbox());
    $this->getWidget('until_the_end_of_the_month')->setLabel('Until the end of the month');
    $this->setValidator('until_the_end_of_the_month', new sfValidatorString(array('required' => false)));

    $year_ui = $this->getOption('year_ui') ? $this->getOption('year_ui') : date('Y');
    $month_ui = $this->getOption('month_ui') ? $this->getOption('month_ui') : date('n');

    $this->setWidget('from_not_work', new sfWidgetFormJQueryDate(
      array(
        'config' => '{}',
        'culture' => 'ru',
        'date_widget' => new sfWidgetFormDate(
          array(
            'format' => '%year%%month%%day%',
          ),
          array(
            'style'=>'min-width:70px;'
          )
        ),
        'minMonth' => $month_ui,
        'maxMonth' => $month_ui,
      )
    ));

    $this->setDefault('from_not_work', array(
      'year' => $year_ui,
      'month' => $month_ui,
      'day' => date('j')
    ));

    $this->setWidget('to_not_work', new sfWidgetFormJQueryDate(
      array(
        'config' => '{}',
        'culture' => 'ru',
        'date_widget' => new sfWidgetFormDate(
          array(
            'format' => '%year%%month%%day%'
          ),
          array(
            'style'=>'min-width:70px;'
          )
        ),
        'minMonth' => $month_ui,
        'maxMonth' => $month_ui,
      )
    ));

    $lastDayOfEditMonth = date('t', strtotime($year_ui . '-' . $month_ui . '-1'));

    $this->setDefault('to_not_work', array(
      'year' => $year_ui,
      'month' => $month_ui,
      'day' => $lastDayOfEditMonth
    ));

    /*$this->setValidator('from_not_work', new sfValidatorDate());
    $this->setValidator('to_not_work', new sfValidatorDate());*/

    $this->validatorSchema->setPostValidator(
      new sfValidatorCallback(
        array(
          'callback' => array($this, 'checkBooleanAndDate'),
        ))
    );

    $this->setValidator('department_people_replacement_id', new sfValidatorInteger(array(
      'required' => false
    )));

    $this->validatorSchema->setOption('allow_extra_fields', true);
    $this->validatorSchema->setOption('filter_extra_fields', false);

    $this->disableCSRFProtection();
  }

  public function save($con = null)
  {
    $object = parent::save();

    if ($this->getObject()->personDoesntWork())
    {
      $params = $this->getObject()->toArray();
      $grafikTimes = Grafik::getGrafikTimes($params);
      $grafikTimes->delete();
    }

    if ($this->getValue('until_the_end_of_the_month'))
    {
      $fromDayArray = $this->getValue('from_not_work');
      $toDayArray = $this->getValue('to_not_work');

      $fromDay = isset($fromDayArray['day']) ? $fromDayArray['day'] : null;
      $toDay = isset($toDayArray['day']) ? $toDayArray['day'] : null;

      $object->toEndOfTheMonth($fromDay, $toDay);
    }

    return $object;
  }

  public function checkBooleanAndDate($validator, $values, $arguments)
  {
    $is_sick = $values['is_sick'];
    $is_skip = $values['is_skip'];
    $is_fired = $values['is_fired'];
    $is_vacation = $values['is_vacation'];

    if (
      ($is_sick && $is_skip) || ($is_sick && $is_fired) || ($is_sick && $is_vacation) ||
      ($is_skip && $is_fired) || ($is_skip && $is_vacation) ||
      ($is_fired && $is_vacation)
    )
    {
      $error = $this->i18n->__('Invalid. People can\'t sick && skip && fired && $is_vacation at the same time');
      throw new sfValidatorError($validator, $error);
    }

    //date range check
    if ($values['until_the_end_of_the_month'] )
    {
      $fromDayArray = $values['from_not_work'];
      $toDayArray = $values['to_not_work'];

      $fromDay = isset($fromDayArray['day']) ? $fromDayArray['day'] : null;
      $toDay = isset($toDayArray['day']) ? $toDayArray['day'] : null;

      if ($fromDay && $toDay)
      {
        if ($fromDay > $toDay)
        {
          $this->setOption('dateRangeError', true);

          $error = $this->i18n->__('Invalid date range');
          throw new sfValidatorError($validator, $error);
        }
      }
    }

    return $values;
  }
}
