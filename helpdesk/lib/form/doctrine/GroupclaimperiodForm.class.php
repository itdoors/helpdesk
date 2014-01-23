<?php

/**
 * Groupclaimperiod form.
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class GroupclaimperiodForm extends BaseGroupclaimperiodForm
{
  static function getChoicesDay()
  {
      return array(
        '00' => 'Ежедневно',
        '01' => '01',
        '02' => '02',
        '03' => '03',
        '04' => '04',
        '05' => '05',
        '06' => '06',
        '07' => '07',
        '08' => '08',
        '09' => '09',
        '10' => '10',
        '11' => '11',
        '12' => '12',
        '13' => '13',
        '14' => '14',
        '15' => '15',
        '16' => '16',
        '17' => '17',
        '18' => '18',
        '19' => '19',
        '20' => '20',
        '21' => '21',
        '22' => '22',
        '23' => '23',
        '24' => '24',
        '25' => '25',
        '26' => '26',
        '27' => '27',
        '28' => '28',
        '29' => '29',
        '30' => '30',
        '31' => '31',
      );
  }
  
  static function getChoicesMonth()
  {
      return array(
        '00' => 'Ежемесячно',
        '01' => '01',
        '02' => '02',
        '03' => '03',
        '04' => '04',
        '05' => '05',
        '06' => '06',
        '07' => '07',
        '08' => '08',
        '09' => '09',
        '10' => '10',
        '11' => '11',
        '12' => '12',
      );
  }
  
  static function getChoicesYear()
  {
      return array(
        '00' => 'Ежегодно',
        '2011' =>  date("Y"),
        '2012' =>  date("Y")+1,
        '2013' => date("Y")+2,
        '2014' => date("Y")+3,
        '2015' => date("Y")+4,
        '2016' => date("Y")+4,
        '2017' => date("Y")+5,
        '2018' => date("Y")+6,
        '2019' => date("Y")+7,
        '2020' => date("Y")+8,
        '2021' => date("Y")+9,
        '2022' => date("Y")+10,
      );
  }  
  public function configure()
  {
      $choises_day =  GroupclaimperiodForm::getChoicesDay();
      $choises_month =  GroupclaimperiodForm::getChoicesMonth();
      $choises_year = GroupclaimperiodForm::getChoicesYear();
      $this->setWidget('period_day', new sfWidgetFormChoice(array('choices'=>$choises_day)));
      $this->setWidget('period_month', new sfWidgetFormChoice(array('choices'=>$choises_month)));
      $this->setWidget('period_year', new sfWidgetFormChoice(array('choices'=>$choises_year)));
      
      $this->validatorSchema->setPostValidator(new sfValidatorPeriod($this['period_day'], $this['period_month'], $this['period_year']));
      $this->widgetSchema->setLabel('Период запуска');
      
        
      
  }
}

class sfValidatorPeriod extends sfValidatorSchema
{
    
public function __construct($period_day, $period_month, $period_year, $options = array(), $messages = array())
  {
    $this->addOption('period_day', $period_day);
    $this->addOption('period_month', $period_month);
    $this->addOption('period_year', $period_year);

    $this->addOption('throw_global_error', false);

    parent::__construct(null, $options, $messages);
  }
  
 
  protected function doClean($value)
  {
    
    $period_day = $value['period_day'];
    $period_month = $value['period_month'];
    $period_year = $value['period_year'];
    if ($period_day == '00' && $period_month == '00' && $period_year == '00') return $value;
    if ($period_day != '00' && $period_month == '00' && $period_year == '00') return $value;
    if ($period_day != '00' && $period_month != '00' && $period_year == '00') return $value;
    if ($period_day == '00' && $period_month != '00' && $period_year == '00') return $value;
    if ($period_day == '00' && $period_month != '00' && $period_year != '00') 
    {
        if ($period_month >= date("m") && $period_year >= date("Y")) return $value; 
    }
    if ($period_day == '00' && $period_month == '00' && $period_year != '00') return $value; 
    if ($period_day != '00' && $period_month == '00' && $period_year != '00') return $value; 
    if ($period_day != '00' && $period_month != '00' && $period_year != '00') 
    {
       
        if ($period_day > date("d") && $period_month >= date("m") && $period_year >= date("Y")) return $value;  
    }
    
    throw new sfValidatorError($this, 'Неверно введенна дата', array('value' => $value));
  }
 
  public function isEmpty($value)
  {
    return false;
  }
}
