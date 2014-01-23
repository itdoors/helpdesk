<?php

/**
 * groupclaim actions.
 *
 * @package    helpdesk
 * @subpackage groupclaim
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class groupclaimActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->groupclaims = Doctrine_Core::getTable('Groupclaim')->getCurrentsGroupclaims();

  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new GroupclaimForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new GroupclaimForm();

    $this->processForm($request, $this->form);
    $this->getUser()->setFlash('error', 'Проверьте верность введенных данных');
    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($groupclaim = Doctrine_Core::getTable('Groupclaim')->find(array($request->getParameter('id'))), sprintf('Object groupclaim does not exist (%s).', $request->getParameter('id')));
    $this->form = new GroupclaimForm($groupclaim);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($groupclaim = Doctrine_Core::getTable('Groupclaim')->find(array($request->getParameter('id'))), sprintf('Object groupclaim does not exist (%s).', $request->getParameter('id')));
    $this->form = new GroupclaimForm($groupclaim);

    $this->processForm($request, $this->form);
    $this->getUser()->setFlash('error', 'Проверьте верность введенных данных');
    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($groupclaim = Doctrine_Core::getTable('Groupclaim')->find(array($request->getParameter('id'))), sprintf('Object groupclaim does not exist (%s).', $request->getParameter('id')));
    $groupclaim->delete();

    $this->redirect('groupclaim/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $notice = $form->getObject()->isNew() ? 'The item was created successfully.' : 'The item was updated successfully.';
      $groupclaim = $form->save();
      $this->getUser()->setFlash('notice', $notice);
      $this->redirect('groupclaim/edit?id='.$groupclaim->getId());
    }
  }
  
  
  public function executeStartgroupclaim(sfWebRequest $request)
  {
      $this->message = Groupclaim::StartGroupclaim();
      
  }
  

  
}
