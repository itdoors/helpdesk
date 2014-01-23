<?php

/**
 * userstuff form base class.
 *
 * @method userstuff getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseuserstuffForm extends sfGuardUserForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('userstuff[%s]');
  }

  public function getModelName()
  {
    return 'userstuff';
  }

}
