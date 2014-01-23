<?php

/**
 * client form.
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class clientForm extends BaseclientForm
{
  public function configure()
  {
      
  }
}

class clientAddForm extends BaseclientForm
{
  public function configure()
  {
     unset($this['user_id']);
     unset($this['organization_id']);
     unset($this['departments_list']);
  }
  
  
}
