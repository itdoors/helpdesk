<?php

/**
 * organization form.
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class organizationForm extends BaseorganizationForm
{
  public function configure()
  {
  }
}
class organizationAdminForm extends BaseorganizationForm
{
  public function configure()
  {
      unset($this['shortname']);
  }
}
