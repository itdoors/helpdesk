<?php

/**
 * ModelContact form.
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ModelContactForm extends BaseModelContactForm
{
  public function configure()
  {                    
    $this->setWidget('phone2', new sfWidgetFormInputText());
    $this->setValidator('phone2', new sfValidatorString(array('max_length' => 255)));

    $years = range(date('Y') - 75, date('Y')-14);

    $this->setWidget('birthday', new sfWidgetFormDate(
      array(
        'format' => '%day%%month%%year%',
        'years' =>  array_combine($years, $years)
      ), 
      array('style'=>'min-width:70px;')));
      
    unset($this['sort']);
  }
}
