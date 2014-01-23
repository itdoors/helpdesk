<?php

/**
 * global_messages actions.
 *
 * @package    helpdesk
 * @subpackage global_messages
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class global_messagesActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->redirect('@homepage');
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->global_message = Doctrine_Core::getTable('GlobalMessage')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->global_message);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new GlobalMessageForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new GlobalMessageForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($global_message = Doctrine_Core::getTable('GlobalMessage')->find(array($request->getParameter('id'))), sprintf('Object global_message does not exist (%s).', $request->getParameter('id')));
    $this->form = new GlobalMessageForm($global_message);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($global_message = Doctrine_Core::getTable('GlobalMessage')->find(array($request->getParameter('id'))), sprintf('Object global_message does not exist (%s).', $request->getParameter('id')));
    $this->form = new GlobalMessageForm($global_message);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($global_message = Doctrine_Core::getTable('GlobalMessage')->find(array($request->getParameter('id'))), sprintf('Object global_message does not exist (%s).', $request->getParameter('id')));
    $global_message->delete();

    $this->redirect('global_messages/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $global_message = $form->save();

      $this->redirect('global_messages/edit?id='.$global_message->getId());
    }
  }
}
