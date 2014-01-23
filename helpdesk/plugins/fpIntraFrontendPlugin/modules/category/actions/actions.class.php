<?php

/**
 * category actions.
 *
 * @package    helpdesk
 * @subpackage category
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class categoryActions extends sfActions
{
    

  public function executeIndex(sfWebRequest $request)
  {
      $parent_id = $request->getParameter('parent_id');
      $this->category_id = $parent_id ? $parent_id : 0;
      $this->getUser()->setAttribute('category_id', $this->category_id);
      $this->getUser()->setAttribute('document_id', 0);
      $this->forwardUnless(DocDocumentGroup::hasPermmisions(), 'category', 'not_permmited');
      $this->categories = Doctrine::getTable('DocDocumentGroup')->getCategoryByParentId($parent_id);
  }
  public function executeNot_permmited(sfWebRequest $request)
  {
     
  }
  

  public function executeNew(sfWebRequest $request)
  {
      $this->forwardUnless(DocDocumentGroup::hasPermmisions() == 'action_all', 'category', 'not_permmited');
      $this->form = new DocDocumentGroupForm();
      
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forwardUnless(DocDocumentGroup::hasPermmisions() == 'action_all', 'category', 'not_permmited');
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new DocDocumentGroupForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($doc_document_group = Doctrine_Core::getTable('DocDocumentGroup')->find(array($request->getParameter('id'))), sprintf('Object doc_document_group does not exist (%s).', $request->getParameter('id'))); 
    $this->getUser()->setAttribute('category_id', $request->getParameter('id'));   
    $this->forwardUnless(DocDocumentGroup::hasPermmisions() == 'action_edit'||DocDocumentGroup::hasPermmisions() == 'action_all', 'category', 'not_permmited');
    
    $this->form = new DocDocumentGroupForm($doc_document_group);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forwardUnless(DocDocumentGroup::hasPermmisions() == 'action_edit'||DocDocumentGroup::hasPermmisions() == 'action_all', 'category', 'not_permmited');
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($doc_document_group = Doctrine_Core::getTable('DocDocumentGroup')->find(array($request->getParameter('id'))), sprintf('Object doc_document_group does not exist (%s).', $request->getParameter('id')));
    $this->form = new DocDocumentGroupForm($doc_document_group);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeRestore(sfWebRequest $request)
  {
    $this->forwardUnless(DocDocumentGroup::hasPermmisions() == 'action_all', 'category', 'not_permmited');
    $request->checkCSRFProtection();

    $this->forward404Unless($doc_document_group = Doctrine_Core::getTable('DocDocumentGroup')->find(array($request->getParameter('id'))), sprintf('Object doc_document_group does not exist (%s).', $request->getParameter('id')));
    $doc_document_group->restore();

    $this->redirect('category/index');
  }
  
  public function executeDelete(sfWebRequest $request)
  {
    $this->forwardUnless(DocDocumentGroup::hasPermmisions() == 'action_all', 'category', 'not_permmited');
    $request->checkCSRFProtection();

    $this->forward404Unless($doc_document_group = Doctrine_Core::getTable('DocDocumentGroup')->find(array($request->getParameter('id'))), sprintf('Object doc_document_group does not exist (%s).', $request->getParameter('id')));
    $doc_document_group->delete();

    $this->redirect('category/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $doc_document_group = $form->save();
      
      $this->redirect('category/edit?id='.$doc_document_group->getId());
    }
  }
  
//  какие должен иметь права пользователя, чтобы добавлять права к категориям!???????!!!!!!!!!!!!! 
  public function executeUser_load_permission_form(sfWebRequest $request) 
  {
     if ($request->isXmlHttpRequest())
     {
         $form = new CategoryPermissionForm();
         $form->getWidgetSchema()->setNameFormat('doc_document_group[user_permissions]['.$request->getParameter('cross').'][%s]');
         $form->disableCSRFProtection();
         return $this->renderPartial('user_permission_form_template', array('form'=>$form));
     } else return $this->renderText('Direct access');
  }
  
  public function executeGroup_load_permission_form(sfWebRequest $request) 
  {
     if ($request->isXmlHttpRequest())
     {
         $form = new GroupPermissionForm();
         $form->getWidgetSchema()->setNameFormat('doc_document_group[group_permissions]['.$request->getParameter('cross').'][%s]');
         $form->disableCSRFProtection();
         return $this->renderPartial('group_permission_form_template', array('form'=>$form));
     } else return $this->renderText('Direct access');
  }
  
}
