<?php

/**
 * stuff form.
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class stuffForm extends BasestuffForm
{
  public function configure()
  {
    $this->widgetSchema['position_id']->setOption('table_method','getUserStuffLookup');
  }
}

class stuffAddForm extends BasestuffForm
{
  public function configure()
  {

     $stuffclass =  new sfWidgetFormInputHidden();
     $stuffclass->setDefault('stuff');
     $this->setWidget('stuffclass', $stuffclass);
     $this->widgetSchema['stuffclass']->setDefault('stuff');

    $choices = Doctrine::getTable('companystructure')->getTreeChoices();

    $this->setWidget('companystructure_id', new sfWidgetFormChoice(array('choices' => $choices)));

    $years_range = range(date('Y') - 30, date('Y'));
    $years = array_combine($years_range, $years_range);

    $this->setWidget('hire_date', new sfWidgetFormDate(array('years' => $years)));
    $this->setWidget('fire_date', new sfWidgetFormDate(array('years' => $years)));

     $this->useFields(
     array(
          'user_id',
          'companystructure_id',
          'mobilephone',
          'mobilephone_personal',
          'phone_inside',
          'birth_place',
          'hire_date',
          'fire_date',
          'education',
          'issues',
          'description',
       )
     );
  }
  
  
}

class stuffInfoForm extends BasestuffForm
{
  public function configure()
  {

  }
  
  
}

class stuffFullInfoForm extends BasestuffForm
{
  public function configure()
  {

  }
  
  
}
