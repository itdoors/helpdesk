<?php

/**
 * docdocument actions.
 *
 * @package    helpdesk
 * @subpackage docdocument
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class docdocumentActions extends sfActions
{
  public function executeShow(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::GET) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($this->doc_document = Doctrine_Core::getTable('DocDocument')->find(array($request->getParameter('id'))), sprintf('Object doc_document does not exist (%s).', $request->getParameter('id')));
    $document_id = $request->getParameter('id');
    $this->document_id = $document_id ? $document_id : 0;
    $this->getUser()->setAttribute('document_id', $this->document_id);
    $this->getUser()->setAttribute('category_id', $this->doc_document->getCategoryId());
  }

  public function executeNew(sfWebRequest $request)
  {
     $this->forwardUnless(DocDocumentGroup::hasPermmisions() == 'action_all', 'category', 'not_permmited');
     $this->getUser()->setAttribute('document_id', 0);  
     $this->form = new DocDocumentForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));
    $this->forwardUnless(DocDocumentGroup::hasPermmisions() == 'action_all', 'category', 'not_permmited');
    $this->form = new DocDocumentForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($doc_document = Doctrine_Core::getTable('DocDocument')->find(array($request->getParameter('id'))), sprintf('Object doc_document does not exist (%s).', $request->getParameter('id')));
    $this->forwardUnless(DocDocumentGroup::hasPermmisions() == 'action_edit'||DocDocumentGroup::hasPermmisions() == 'action_all', 'category', 'not_permmited');
    $this->form = new DocDocumentForm($doc_document);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($doc_document = Doctrine_Core::getTable('DocDocument')->find(array($request->getParameter('id'))), sprintf('Object doc_document does not exist (%s).', $request->getParameter('id')));
    $this->forwardUnless(DocDocumentGroup::hasPermmisions() == 'action_edit'||DocDocumentGroup::hasPermmisions() == 'action_all', 'category', 'not_permmited');
    $this->form = new DocDocumentForm($doc_document);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeRestore(sfWebRequest $request)
  {
    $this->forwardUnless(DocDocumentGroup::hasPermmisions() == 'action_all', 'category', 'not_permmited');
    $request->checkCSRFProtection();

    $this->forward404Unless($doc_document = Doctrine_Core::getTable('DocDocument')->find(array($request->getParameter('id'))), sprintf('Object doc_document does not exist (%s).', $request->getParameter('id')));
    $doc_document->restore();

    $this->redirect('category/index?parent_id='.$doc_document->getCategoryId());
  }
  
  public function executeDelete(sfWebRequest $request)
  {
    $this->forwardUnless(DocDocumentGroup::hasPermmisions() == 'action_all', 'category', 'not_permmited');
    $request->checkCSRFProtection();

    $this->forward404Unless($doc_document = Doctrine_Core::getTable('DocDocument')->find(array($request->getParameter('id'))), sprintf('Object doc_document does not exist (%s).', $request->getParameter('id')));
    $doc_document->delete();

    $this->redirect('category/index?parent_id='.$doc_document->getCategoryId());
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $doc_document = $form->save();

      $this->redirect('category/index?parent_id='.$doc_document->getCategoryId());
    }
  }
  
  public function executeSearch(sfWebRequest $request)
  {
      
  }
  public function executeAjaxsearch(sfWebRequest $request)
  {
      if (!$request->isXmlHttpRequest()) return $this->renderText('Direct access');
      $keywords['search_documents'] = $request->getParameter('search_documents');
      $this->documents = Doctrine::getTable('DocDocument')->getDocumentsByKeywords($keywords);
      return $this->renderPartial('category/documents_list', array('documents'=>$this->documents));
  }
  
}
