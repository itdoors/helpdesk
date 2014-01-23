<?php

/**
 * claim actions.
 *
 * @package    helpdesk
 * @subpackage claim
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class claimopenfinanceActions extends sfActions
{
  public function preExecute()
  {
     $this->app = ucfirst(sfContext::getInstance()->getConfiguration()->getApplication());
     /*$form_name = "claim".$this->app."NewForm";
     $group_form_name = "claim".$this->app."GroupNewForm";
     $this->form_name = $form_name;
     $this->group_form_name = $group_form_name;*/
  }
  
  public function executeIndex(sfWebRequest $request)
  {
    $table_method =  "getOpenedFinanceClaimsFor".$this->app;
    $this->claimsopen = Doctrine_Core::getTable('claim')->$table_method();
    $this->setTemplate($this->app);
  }
}