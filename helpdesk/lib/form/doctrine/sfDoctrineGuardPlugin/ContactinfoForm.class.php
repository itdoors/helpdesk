<?php

/**
 * Contactinfo form.
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrinePluginFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ContactinfoForm extends BaseContactinfoForm
{
  public function configure()
  {
      $this->useFields(
        array(
            'name',
        )
      );
  }
}
