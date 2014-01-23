<?php

/**
 * joinuser actions.
 * 
 * @package    fpJoinUsersPlugin
 * @subpackage joinuser
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12534 2008-11-01 13:38:27Z Kris.Wallsmith $
 */
class dialogActions extends sfActions
{
     public function executeFiananceDocumentTransferForm()
     {
         $form_document = new Documents();
         $form_document->setUserId($this->getUser()->getAttribute('user_id',null, 'sfGuardSecurityUser'));
         $form = new DocumentsForm($form_document);
         $form->getWidget('claim_id')->setDefault($request->getParameter('claim_id'));
         return $this->renderPartial($request->getParameter('formtemplate'), array('form' => $form)); 
     }
}
