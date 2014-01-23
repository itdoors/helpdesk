<?php

/**
 * Salary form.
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class SalaryForm extends BaseSalaryForm
{
  public function configure()
  {
    $years = range(date('Y') - 5, date('Y'));

    $years = array_combine($years, $years);

    $this->setWidget('year', new sfWidgetFormChoice(array('choices' => $years)));

    $culture = 'ru';

    $months = array_combine(range(1, 12), sfDateTimeFormatInfo::getInstance($culture)->getMonthNames());

    $this->setWidget('month', new sfWidgetFormChoice(array('choices' => $months)));

    $this->useFields(array(
      'year',
      'month',
      'days_count',
      'weekends',
      'day_salary'
    ));
  }
}
