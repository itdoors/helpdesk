<?php

/**
 * changepass actions.
 *
 * @package    helpdesk
 * @subpackage changepass
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class changepassActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
      $user_id = $this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser');;
      $this->redirect('changepass/edit?id='.$user_id);
  }

   public function executeEdit(sfWebRequest $request)
  {
    //$request->checkCSRFProtection();
    $user_id = $this->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser');;
    if ($request->getParameter('id') != $user_id) $this->redirect('changepass/edit?id='.$user_id);  
    $this->forward404Unless($sf_guard_user = Doctrine_Core::getTable('sfGuardUser')->find(array($request->getParameter('id'))), sprintf('Object sf_guard_user does not exist (%s).', $request->getParameter('id')));
    $this->form = new sfGuardUserChangePass($sf_guard_user);
    
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($sf_guard_user = Doctrine_Core::getTable('sfGuardUser')->find(array($request->getParameter('id'))), sprintf('Object sf_guard_user does not exist (%s).', $request->getParameter('id')));
    $this->form = new sfGuardUserChangePass($sf_guard_user);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

 
  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      
      $sf_guard_user = $form->save();
      $this->getUser()->setFlash('notice', sprintf('Your password change successfuly'));
      $this->redirect('changepass/edit?id='.$sf_guard_user->getId());
    }
  }
}
