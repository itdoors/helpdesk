<?php

/**
 * claim actions.
 *
 * @package    helpdesk
 * @subpackage claim
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class claimclosedActions extends sfActions
{
  public function preExecute()
  {
     $this->app = ucfirst(sfContext::getInstance()->getConfiguration()->getApplication());
  }
  
  public function executeIndex(sfWebRequest $request)
  {
    $this->form = new claimclosedRangeForm(); 
    $this->setTemplate('Index');
  }
  
  public function executeDone(sfWebRequest $request)
  {
    $form = new claimclosedRangeForm();
    $paramets_holder = $request->getParameter($form->getName());
    
    if (!$paramets_holder)
    {
      $this->redirect('claimclosed/index');
    }
    
    $form->bind($paramets_holder,$request->getFiles($form->getName()));
    $this->form = $form;
    
    $table_method = "getClosedClaimsFor".$this->app;
    $this->claimsclosed = Doctrine_Core::getTable('claim')->$table_method($paramets_holder);
    $this->setTemplate($this->app);
    
    $this->show_added_field = false;
    if ($this->app == 'Client') 
    {
        $user_id = $this->getUser()->getAttribute('user_id',null, 'sfGuardSecurityUser');
        $user = Doctrine::getTable('sfGuardUser')->find($user_id)->getClient()->getFirst();
        $this->show_added_field = $user->getShowAddedField();
    }
  }
  
/*    
  public function executeClose(sfWebRequest $request)
  {
     $claim_id = $request->getParameter('claimid');
     $close_claim = Doctrine::getTable('claim')->find($claim_id);
     $close_claim->closeClaim();
     $user_id = $this->getUser()->getAttribute('user_id',null, 'sfGuardSecurityUser');
     $new_log_claim = new log_claim();
     $new_log_claim->NewLogRecordClosed($close_claim->getId(), $user_id, sfConfig::get('logcliam_close'));
     $this->redirect('claimclosed/index'); 
  }  */

}
