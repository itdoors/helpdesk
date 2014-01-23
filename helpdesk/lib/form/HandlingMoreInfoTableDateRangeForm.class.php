<?php

class HandlingMoreInfoTableDateRangeForm extends sfForm
{
  public function configure()
  {
    /*$i18n = sfContext::getInstance()->getI18N();

    $results = Doctrine::getTable('HandlingResult')
      ->createQuery('hr')
      //->leftJoin('hr.HandlingMoreInfoType ')
      ->where('hr.slug is not null')
      ->execute();*/

    /*$choices = sizeof($results) ? $results->toKeyValueArray('slug', 'name') : array();

    $this->setWidget('type', new sfWidgetFormChoice(array('choices' => $choices)));*/

    $this->setWidget('date_range' , new  sfWidgetFormDateRange(
      array(
        'from_date' => new sfWidgetFormJQueryDate(array(
          'config' => '{}',
          'culture' => 'ru',
          'date_widget' => new sfWidgetFormDate(array('format' => '%day%%month%%year%',), array('style'=>'min-width:70px;'))
        )),
        'to_date' => new sfWidgetFormJQueryDate(array(
          'config' => '{}',
          'culture' => 'ru',
          'date_widget' => new sfWidgetFormDate(array('format' => '%day%%month%%year%', 'can_be_empty'=>false), array('style'=>'min-width:70px;'))
        ))
      )
    ));
    $this->setDefault('date_range',
      array(
        'from' =>array('year' => date('Y'), 'month' => 1, 'day' =>1),
        'to' =>array('year' => date('Y'), 'month' => date('n'), 'day' => date('j'))
      )
    );

    //$this->setValidator('type', new sfValidatorString());

    $this->setValidator('date_range',  new sfValidatorDateRange(
      array(
        'from_date' => new sfValidatorDate(array( 'max' => date("Y-m-d"), 'datetime_output'=>'Y-m-d')),
        'to_date' => new  sfValidatorDate(array( 'max' => date("Y-m-d"), 'datetime_output'=>'Y-m-d'))
      )
    ));

    $this->disableCSRFProtection();

    $this->widgetSchema->setNameFormat('soled_handlings_date_range[%s]');
  }
}

