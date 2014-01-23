<?php
class prntActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {

      $this->redirect('claimopened/index');
  }
  
  public function executeShow(sfWebRequest $request)
  {
    $claim_id = $request->getParameter('claimid');
    //set claimId to session   
    $this->getUser()->setAttribute(sfConfig::get('claim_container'),$claim_id); 
    $this->global_claim_id = $this->getUser()->getAttribute(sfConfig::get('claim_container')); 
    //set claimId to session end
    if (!isset($claim_id)||(!isset($this->global_claim_id))) $this->redirect('claimopened/index');      
    $this->commentss = Doctrine_Core::getTable('comments')->getCommentsByClaimStuff($claim_id);
    $this->form = new commentsAttachForm();
    $this->claim = Doctrine::getTable('claim')->getClaimById($claim_id);
  }  
  
  public function executeShowakt(sfWebRequest $request)
  {
    $claim_id = $request->getParameter('claimid');
    //set claimId to session   
    $this->getUser()->setAttribute(sfConfig::get('claim_container'),$claim_id); 
    $this->global_claim_id = $this->getUser()->getAttribute(sfConfig::get('claim_container')); 
    //set claimId to session end
    if (!isset($claim_id)||(!isset($this->global_claim_id))) $this->redirect('claimopened/index');      
    $this->commentss = Doctrine_Core::getTable('comments')->getCommentsByClaimStuff($claim_id);
    $this->form = new commentsAttachForm();
    $this->claim = Doctrine::getTable('claim')->getClaimById($claim_id);
  }  
 
}
