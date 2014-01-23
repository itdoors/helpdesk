<?php

/**
 * docdocument_version actions.
 *
 * @package    helpdesk
 * @subpackage docdocument_version
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class docdocument_versionActions extends sfActions
{
/*  public function executeIndex(sfWebRequest $request)
  {
    
      $this->doc_document_versions = Doctrine_Core::getTable('DocDocumentVersion')
      ->createQuery('a')
      ->execute();
  } */
  

  public function executeNew(sfWebRequest $request)
  {
      $this->forwardUnless(DocDocumentGroup::hasPermmisions() == 'action_all', 'category', 'not_permmited');
      $this->form = new DocDocumentVersionForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));
    $this->forwardUnless(DocDocumentGroup::hasPermmisions() == 'action_all', 'category', 'not_permmited');
    $this->form = new DocDocumentVersionForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($doc_document_version = Doctrine_Core::getTable('DocDocumentVersion')->find(array($request->getParameter('id'))), sprintf('Object doc_document_version does not exist (%s).', $request->getParameter('id')));
    $this->forwardUnless(DocDocumentGroup::hasPermmisions() == 'action_edit'||DocDocumentGroup::hasPermmisions() == 'action_all', 'category', 'not_permmited');
    $this->form = new DocDocumentVersionForm($doc_document_version);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($doc_document_version = Doctrine_Core::getTable('DocDocumentVersion')->find(array($request->getParameter('id'))), sprintf('Object doc_document_version does not exist (%s).', $request->getParameter('id')));
    $this->forwardUnless(DocDocumentGroup::hasPermmisions() == 'action_edit'||DocDocumentGroup::hasPermmisions() == 'action_all', 'category', 'not_permmited');
    $this->form = new DocDocumentVersionForm($doc_document_version);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
      $this->forwardUnless(DocDocumentGroup::hasPermmisions() == 'action_all', 'category', 'not_permmited');
      $request->checkCSRFProtection();

    $this->forward404Unless($doc_document_version = Doctrine_Core::getTable('DocDocumentVersion')->find(array($request->getParameter('id'))), sprintf('Object doc_document_version does not exist (%s).', $request->getParameter('id')));
    $doc_document_version->delete();
    $this->redirect('docdocument/show?id='.$doc_document_version->getDocumentId());
  }
  
  public function executeRestore(sfWebRequest $request)
  {
      $this->forwardUnless(DocDocumentGroup::hasPermmisions() == 'action_all', 'category', 'not_permmited');
      $request->checkCSRFProtection();

    $this->forward404Unless($doc_document_version = Doctrine_Core::getTable('DocDocumentVersion')->find(array($request->getParameter('id'))), sprintf('Object doc_document_version does not exist (%s).', $request->getParameter('id')));
    $doc_document_version->restore();
    $this->redirect('docdocument/show?id='.$doc_document_version->getDocumentId());
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $doc_document_version = $form->save();
      $this->redirect('docdocument/show?id='.$doc_document_version->getDocumentId());
    }
  }
  
  //ф-ция будет отображать где лежат реальные файлы и куда их надо перенести
  public function executeShowRealDocuments(sfWebRequest $request)
  {
      $this->doc_document_versions = Doctrine_Core::getTable('DocDocumentVersion')
      ->createQuery('a')
      ->execute();
  }
  
  
}
