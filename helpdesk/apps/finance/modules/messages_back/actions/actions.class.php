<?php
class messagesActions extends sfActions
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
    Doctrine::getTable('claim')->find($claim_id)->setIsReadByUser();
    $this->claim = Doctrine::getTable('claim')->getClaimById($claim_id);
    
  }


  public function executeNew(sfWebRequest $request)
  {
    $this->form = new commentsAttachForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
     $this->forward404Unless($request->isMethod(sfRequest::POST));
     $this->form = new commentsAttachForm();
     $this->processForm($request, $this->form); 
     $claim_id = $request->getParameter('claimid');
     $this->commentss = Doctrine_Core::getTable('comments')->getCommentsByClaimStuff($claim_id);
     $this->claim = Doctrine::getTable('claim')->getClaimById($claim_id); 
     $this->setTemplate('show'); 
    
  }         
  
  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $claim_id = $this->getUser()->getAttribute(sfConfig::get('claim_container')); 
      $form->getObject()->setUserId($this->getUser()->getAttribute('user_id',null, 'sfGuardSecurityUser'));
      $form->getObject()->setCreatedatetime(date("Y-m-d H:i:s"));
      $form->getObject()->setClaimId($claim_id);
      $comments = $form->save();
      $claim = Doctrine::getTable('claim')->find($claim_id)->setIsread();
      $comments->sendMessageForAll($claim_id, true, true, true);
      $this->redirect('messages/show?claimid='.$claim_id); 
    }
  }
 
}
