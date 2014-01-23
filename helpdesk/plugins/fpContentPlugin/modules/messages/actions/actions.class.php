<?php
class messagesActions extends sfActions
{
  public function preExecute()
  {
      $this->app = ucfirst(sfContext::getInstance()->getConfiguration()->getApplication());
      $this->form_name = "commentsAttach".$this->app."Form";
  }
    
  public function executeIndex(sfWebRequest $request)
  {
      $this->redirect('claimopened/index');
  }
  
  public function executeShow(sfWebRequest $request)
  {
    $claim_id = $request->getParameter('claimid');
    if (!$this->claim = Doctrine::getTable('claim')->getClaimById($claim_id))
    {
        $this->getUser()->setFlash('error', 'No object');
        $this->redirect('common/index');
    }
    if (!claim::hasClaimAccess($claim_id))
    {
        $this->getUser()->setFlash('error', 'You have no permission to access this page');
        $this->redirect('common/index');
    }
    if (!isset($claim_id)) $this->redirect('claimopened/index');      
    $comments_function = "getCommentsByClaim".$this->app;
    $this->comments = Doctrine_Core::getTable('comments')->$comments_function($claim_id);
    $this->form = new $this->form_name();
    Doctrine::getTable('claim')->find($claim_id)->setIsReadByUser();
    
    $this->setTemplate($this->app);
  }

 
  public function executeCreate(sfWebRequest $request)
  {
     $this->forward404Unless($request->isMethod(sfRequest::POST));
     $this->form = new $this->form_name();
     $this->processForm($request, $this->form); 
     
     $this->setTemplate($this->app); 
    
  }         
  
  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
/*     $claim_id = $this->getUser()->getAttribute(sfConfig::get('claim_container')); 
      $form->getObject()->setUserId($this->getUser()->getAttribute('user_id',null, 'sfGuardSecurityUser'));
      $form->getObject()->setCreatedatetime(date("Y-m-d H:i:s"));
      $form->getObject()->setClaimId($claim_id);   */
/*      $claim = Doctrine::getTable('claim')->find($claim_id)->setIsread();
      $isvisible = $comments->getIsvisible();
      $comments->sendMessageForAll($claim_id, !$isvisible, true, true);  */
      $comments = $form->save();
      $this->getUser()->setFlash('notice','Comment has been added successfully'); 
      $this->redirect('messages/show?claimid='.$comments->getClaimId()); 
    }
    $parametr_holder = $request->getParameter($form->getName());
    $comments_function = "getCommentsByClaim".$this->app;
    $this->comments = Doctrine_Core::getTable('comments')->$comments_function($parametr_holder['claim_id']);
    $this->claim = Doctrine::getTable('claim')->getClaimById($parametr_holder['claim_id']); 
    $this->getUser()->setFlash('error','Invalid.');
  }

  public function executeRefresh_worklist(sfWebRequest $request)
  {
      $claim = Doctrine::getTable('claim')->find($request->getParameter('claim_id'));
      $app = $request->getParameter('app');
      return $this->renderComponent('messages',ucfirst($app)."_worklist", array('claim'=>$claim));  
  }
}
