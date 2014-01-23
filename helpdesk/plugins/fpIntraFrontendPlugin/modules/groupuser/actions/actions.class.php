<?php

/**
 * groupuser actions.
 *
 * @package    helpdesk
 * @subpackage groupuser
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class groupuserActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->doc_document_group_sf_userss = Doctrine_Core::getTable('DocDocumentGroupSfUsers')
      ->createQuery('a')
      ->execute();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new CategoryPermissionForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new CategoryPermissionForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($doc_document_group_sf_users = Doctrine_Core::getTable('DocDocumentGroupSfUsers')->find(array($request->getParameter('sf_guard_user_id'),
    $request->getParameter('doc_document_group_id'),
    $request->getParameter('actionkey'))), sprintf('Object doc_document_group_sf_users does not exist (%s).', $request->getParameter('sf_guard_user_id'),
    $request->getParameter('doc_document_group_id'),
    $request->getParameter('actionkey')));
    $this->form = new DocDocumentGroupSfUsersForm($doc_document_group_sf_users);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($doc_document_group_sf_users = Doctrine_Core::getTable('DocDocumentGroupSfUsers')->find(array($request->getParameter('sf_guard_user_id'),
$request->getParameter('doc_document_group_id'),
$request->getParameter('actionkey'))), sprintf('Object doc_document_group_sf_users does not exist (%s).', $request->getParameter('sf_guard_user_id'),
$request->getParameter('doc_document_group_id'),
$request->getParameter('actionkey')));
    $this->form = new DocDocumentGroupSfUsersForm($doc_document_group_sf_users);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($doc_document_group_sf_users = Doctrine_Core::getTable('DocDocumentGroupSfUsers')->find(array($request->getParameter('sf_guard_user_id'),
$request->getParameter('doc_document_group_id'),
$request->getParameter('actionkey'))), sprintf('Object doc_document_group_sf_users does not exist (%s).', $request->getParameter('sf_guard_user_id'),
$request->getParameter('doc_document_group_id'),
$request->getParameter('actionkey')));
    $doc_document_group_sf_users->delete();

    $this->redirect('groupuser/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $doc_document_group_sf_users = $form->save();

      $this->redirect('groupuser/index');
    }
  }
}
