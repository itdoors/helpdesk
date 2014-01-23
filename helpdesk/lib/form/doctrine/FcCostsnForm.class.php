<?php

/**
 * FcCostsn form.
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class FcCostsnForm extends BaseFcCostsnForm
{
  public function configure()
  {
      $this->setWidget('value', new sfWidgetFormInputText());
      $this->setValidator('value', new sfValidatorNumber(array('min' => 0), array('min' => 'Введите положительно число') ));
  }
}
