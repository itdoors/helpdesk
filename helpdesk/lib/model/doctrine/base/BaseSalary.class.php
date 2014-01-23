<?php

/**
 * BaseSalary
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $year
 * @property integer $month
 * @property integer $days_count
 * @property string $weekends
 * @property float $day_salary
 * @property float $summary_coef
 * 
 * @method integer getId()           Returns the current record's "id" value
 * @method integer getYear()         Returns the current record's "year" value
 * @method integer getMonth()        Returns the current record's "month" value
 * @method integer getDaysCount()    Returns the current record's "days_count" value
 * @method string  getWeekends()     Returns the current record's "weekends" value
 * @method float   getDaySalary()    Returns the current record's "day_salary" value
 * @method float   getSummaryCoef()  Returns the current record's "summary_coef" value
 * @method Salary  setId()           Sets the current record's "id" value
 * @method Salary  setYear()         Sets the current record's "year" value
 * @method Salary  setMonth()        Sets the current record's "month" value
 * @method Salary  setDaysCount()    Sets the current record's "days_count" value
 * @method Salary  setWeekends()     Sets the current record's "weekends" value
 * @method Salary  setDaySalary()    Sets the current record's "day_salary" value
 * @method Salary  setSummaryCoef()  Sets the current record's "summary_coef" value
 * 
 * @package    helpdesk
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseSalary extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('salary');
        $this->hasColumn('id', 'integer', null, array(
             'primary' => true,
             'type' => 'integer',
             'autoincrement' => true,
             ));
        $this->hasColumn('year', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('month', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('days_count', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('weekends', 'string', 128, array(
             'type' => 'string',
             'length' => 128,
             ));
        $this->hasColumn('day_salary', 'float', null, array(
             'type' => 'float',
             ));
        $this->hasColumn('summary_coef', 'float', null, array(
             'type' => 'float',
             ));


        $this->index('year_month', array(
             'fields' => 
             array(
              0 => 'year',
              1 => 'month',
             ),
             'type' => 'unique',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        
    }
}