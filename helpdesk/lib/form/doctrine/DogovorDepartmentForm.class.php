<?php

/**
 * DogovorDepartment form.
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
 
class DogovorDepartmentForm extends BaseDogovorDepartmentForm
{
  public function configure()
  {
    $this->setWidget('organization_id', new sfWidgetFormInputHidden());
    $this->setValidator('organization_id', new sfValidatorString());
    
    $this->disableCSRFProtection();
  }
}