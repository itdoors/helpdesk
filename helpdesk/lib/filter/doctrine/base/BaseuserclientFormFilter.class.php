<?php

/**
 * userclient filter form base class.
 *
 * @package    helpdesk
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedInheritanceTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseuserclientFormFilter extends sfGuardUserFormFilter
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('userclient_filters[%s]');
  }

  public function getModelName()
  {
    return 'userclient';
  }
}
