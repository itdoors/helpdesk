<?php

/**
 * userclient form base class.
 *
 * @method userclient getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseuserclientForm extends sfGuardUserForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('userclient[%s]');
  }

  public function getModelName()
  {
    return 'userclient';
  }

}
