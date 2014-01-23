<?php

/**
 * joinuser actions.
 * 
 * @package    fpJoinUsersPlugin
 * @subpackage joinuser
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12534 2008-11-01 13:38:27Z Kris.Wallsmith $
 */
class ajaxActions extends sfActions
{
    var $form_name = 'finance_claim';
    //var $lables = array('')
    
    
    public function executeAjaxFieldForm(sfWebRequest $request)
    {
      if ($request->isXmlHttpRequest())
      {
        $finance_claim = Doctrine::getTable('finance_claim')->getFinanceClaimByClaimId($request->getParameter('claim_id'));
        $form = new finance_claimForm($finance_claim);
        $formfield = $request->getParameter('field');
        $form->useFields(array($formfield,'claim_id'));
        return $this->renderPartial($request->getParameter('formtemplate'), array('form' => $form, 'formfield'=>$formfield, 'relfield'=>$request->getParameter('relfield'))); 
      }
    }
    
    public function executeAjaxFieldFormClaim(sfWebRequest $request)
    {
      if ($request->isXmlHttpRequest())
      {
        $claim = Doctrine::getTable('claim')->find($request->getParameter('id'));
        $form = new claimForm($claim);
        $formfield = $request->getParameter('field');
        $form->useFields(array($formfield));
        return $this->renderPartial($request->getParameter('formtemplate'), array('form' => $form, 'formfield'=>$formfield, 'relfield'=>$request->getParameter('relfield'))); 
      }
    }
    
    
    
    public function executeAjaxFieldFormSave(sfWebRequest $request)
    {
/*      if ($request->isXmlHttpRequest())
      { */
        $finance_claim_holder = $request->getParameter($this->form_name);
        $id = $finance_claim_holder['id'];
        $finance_claim = Doctrine::getTable('finance_claim')->find($id);
        $form = new finance_claimForm($finance_claim);
        $form->useFields(array('id',$request->getParameter('field'),'claim_id')); 
        $form->bind($request->getParameter($form->getName()),$request->getFiles($form->getName())); 
        if ($form->isValid())
        {
           $form->save();
           $new_log_claim = new log_claim();
           $obj = $form->getObject();
           if ($request->getParameter('relfield'))
           {
               $obj->ReCountField($request->getParameter('relfield'));
               $obj->trySave();
           } 
           $obj->refreshProfitability();
           $user_id = $this->getUser()->getAttribute('user_id',null, 'sfGuardSecurityUser');
           $new_log_claim->NewLogRecord($finance_claim_holder['claim_id'], $user_id, sfConfig::get('logcliam_'.$request->getParameter('field')).$obj[$request->getParameter('field')],sfConfig::get('logcliam_finance')); 
        //} else return $this->renderText('False'); 
        } else {
            return $this->renderPartial('ajaxFieldForm', array('form' => $form, 'formfield'=>$request->getParameter('field'))); 
        }
       
        return $this->renderText($obj[$request->getParameter('field')]); 
      //} else return $this->renderText('Direct access');
     $this->renderText('Direct access');
    }
    
    
    public function executeAjaxFieldFormSaveClaim(sfWebRequest $request)
    {
/*      if ($request->isXmlHttpRequest())
      { */
        $finance_claim_holder = $request->getParameter('claim');
        $id = $finance_claim_holder['claim_id'];
        $finance_claim = Doctrine::getTable('claim')->find($id);
        $form = new claimForm($finance_claim);
        $form->useFields(array('id',$request->getParameter('field'))); 
        $form->bind($request->getParameter($form->getName()),$request->getFiles($form->getName())); 
        if ($form->isValid())
        {
           $form->save();
           $new_log_claim = new log_claim();
/*           $obj = $form->getObject();
           if ($request->getParameter('relfield'))
           {
               $obj->ReCountField($request->getParameter('relfield'));
               $obj->trySave();
           }  */
           //$obj->refreshProfitability();
           $user_id = $this->getUser()->getAttribute('user_id',null, 'sfGuardSecurityUser');
           $new_log_claim->NewLogRecord($finance_claim_holder['claim_id'], $user_id, sfConfig::get('logcliam_'.$request->getParameter('field')).$obj[$request->getParameter('field')],sfConfig::get('logcliam_finance')); 
        //} else return $this->renderText('False'); 
        } else {
            return $this->renderPartial('ajaxFieldForm', array('form' => $form, 'formfield'=>$request->getParameter('field'))); 
        }
       
        return $this->renderText($obj[$request->getParameter('field')]); 
      //} else return $this->renderText('Direct access');
     $this->renderText('Direct access');
    }
    
    
    public function executeAjaxFieldFormSaveFile(sfWebRequest $request)
    {
/*      if ($request->isXmlHttpRequest())
      { */
        $finance_claim_holder = $request->getParameter($this->form_name);
        $id = $finance_claim_holder['id'];
        $finance_claim = Doctrine::getTable('finance_claim')->find($id);
        $form = new finance_claimForm($finance_claim);
        $form->useFields(array('id',$request->getParameter('field'),'claim_id')); 
        $form->bind($request->getParameter($form->getName()),$request->getFiles($form->getName())); 
        if ($form->isValid())
        {
           $form->save();
           $new_log_claim = new log_claim();
           $obj = $form->getObject();
           $user_id = $this->getUser()->getAttribute('user_id',null, 'sfGuardSecurityUser');
           $new_log_claim->NewLogRecord($finance_claim_holder['claim_id'], $user_id, sfConfig::get('logcliam_'.$request->getParameter('field')), sfConfig::get('logcliam_finance')); 
        } else return $this->renderText('False'); 
        //} else return $this->render; 
       
        return $this->renderPartial('ajaxFieldFile', array('src' => $obj[$request->getParameter('field')]));    
      //} else return $this->renderText('Direct access');
     $this->renderText('Direct access');
    }
    

    
     public function executeGetAjaxField(sfWebRequest $request)
    {
      if ($request->isXmlHttpRequest())
      {
        $relfield = $request->getParameter('relfield');
        $claim_id = $request->getParameter('claim_id');
        $finance_claim = Doctrine::getTable('finance_claim')->getFinanceClaimByClaimId($request->getParameter('claim_id'));
        /*$finance_claim->ReCountField($relfield);
        $finance_claim->trySave()*/;
        $new_log_claim = new log_claim();
        $user_id = sfContext::getInstance()->getUser()->getAttribute('user_id',null, 'sfGuardSecurityUser');
        $new_log_claim->NewLogRecord($claim_id, $user_id, sfConfig::get('logcliam_'.$relfield).$finance_claim[$relfield], sfConfig::get('logcliam_finance')); 
        return $this->renderText($finance_claim[$relfield]); 
      //  return true; 
      } else return $this->renderText('Direct access');
    }
    
    public function executeGetAjaxProfitability(sfWebRequest $request)
    {
      if ($request->isXmlHttpRequest())
      {
        $claim_id = $request->getParameter('claim_id');
        $finance_claim = Doctrine::getTable('finance_claim')->getFinanceClaimByClaimId($request->getParameter('claim_id'));                                   
        return $this->renderText($finance_claim->getProfitabilityResponse()); 
      }
    }
    
    
    
    public function executeAjaxFieldFormDocuments(sfWebRequest $request)
    {
      if ($request->isXmlHttpRequest())
      {
        
        $form_document = new Documents();
        $form_document->setUserId($this->getUser()->getAttribute('user_id',null, 'sfGuardSecurityUser'));
        $form = new DocumentsForm($form_document);
        $form->getWidget('claim_id')->setDefault($request->getParameter('claim_id'));
        return $this->renderPartial($request->getParameter('formtemplate'), array('form' => $form)); 
      }
    }
    
    
    public function executeAjaxFieldFormDocumentsTransfer(sfWebRequest $request)
    {
      if ($request->isXmlHttpRequest())
      {
        
        $form_document = new Documents();
        $form_document->setUserId($this->getUser()->getAttribute('user_id',null, 'sfGuardSecurityUser'));
        $form_document->setFilepath($request->getParameter('file_path'));
        $form = new DocumentsTransferForm($form_document);
        $form->getWidget('claim_id')->setDefault($request->getParameter('claim_id'));
        return $this->renderPartial($request->getParameter('formtemplate'), array('form' => $form)); 
      }
    }
    
    
    

    
    public function executeAjaxFieldFormSaveDocuments(sfWebRequest $request)
    {
        $form = new DocumentsForm();
        $paramets_holder = $request->getParameter($form->getName());
        $form->bind($request->getParameter($form->getName()),$request->getFiles($form->getName())); 
        if ($form->isValid())
        {
            $form->getObject()->setCreatedateTime(date("Y-m-d H:i:s"));
            $form->save();
            $new_log_claim = new log_claim();
            $user_id = $this->getUser()->getAttribute('user_id',null, 'sfGuardSecurityUser');
            $new_log_claim->NewLogRecord($paramets_holder['claim_id'], $user_id, 'Добавлен документ: '.$paramets_holder['name'], sfConfig::get('logcliam_finance')); 
            $documents_claim = new DocumentsClaim();
            $documents_claim->setDocumentsId($form->getObject()->getId());
            $documents_claim->setClaimId($paramets_holder['claim_id']);
            $documents_claim->trySave();
          
        } //else return $this->renderText('False'); 
        else return $this->renderPartial('ajaxFieldFormDocuments', array('form' => $form));
        //} else return $this->render;
       
      return $this->renderPartial('ajaxAllDocuments', array('claim_id' => $paramets_holder['claim_id'])); 
       // return $this->renderPartial('ajaxFieldFile', array('src' => $obj[$request->getParameter('field')]));    
      //} else return $this->renderText('Direct access');
     $this->renderText('Direct access');
    }
    
    
    public function executeAjaxFieldFormSaveDocumentsTransfer(sfWebRequest $request)
    {
        $form = new DocumentsTransferForm();
        $paramets_holder = $request->getParameter($form->getName());
        $form->bind($request->getParameter($form->getName()),$request->getFiles($form->getName())); 
        if ($form->isValid())
        {
            $form->getObject()->setCreatedateTime(date("Y-m-d H:i:s"));
            $form->save();
            $new_log_claim = new log_claim();
            $user_id = $this->getUser()->getAttribute('user_id',null, 'sfGuardSecurityUser');
            $new_log_claim->NewLogRecord($paramets_holder['claim_id'], $user_id, 'Добавлен документ: '.$paramets_holder['name'], sfConfig::get('logcliam_finance')); 
            $documents_claim = new DocumentsClaim();
            $documents_claim->setDocumentsId($form->getObject()->getId());
            $documents_claim->setClaimId($paramets_holder['claim_id']);
            $documents_claim->trySave();
          
        } //else return $this->renderText('False'); 
        else return $this->renderPartial('ajaxFieldFormDocumentsTransfer', array('form' => $form));
        //} else return $this->render;
      //$claim =  
      //return $this->renderText('Документ перенесен'); 
      return $this->renderPartial('documentTransfered', array('claim_id' => $paramets_holder['claim_id']));
       // return $this->renderPartial('ajaxFieldFile', array('src' => $obj[$request->getParameter('field')]));    
      //} else return $this->renderText('Direct access');
     $this->renderText('Direct access');
    }
    
    public function executeChangeBool(sfWebRequest $request)
    {
      if ($request->isXmlHttpRequest())
      {
        $claim_id = $request->getParameter('claim_id');
        $finance_claim = Doctrine::getTable('finance_claim')->getFinanceClaimByClaimId($claim_id);
        if ($finance_claim->getIsClosed()) 
        {
           $finance_claim->setIsClosed(false); 
        }  else  $finance_claim->setIsClosed(true);
        $finance_claim->trySave();
        $status = $finance_claim->getIsClosed()?'Закрыта':'Открыта';
        $new_log_claim = new log_claim();
        $user_id = $this->getUser()->getAttribute('user_id',null, 'sfGuardSecurityUser');
        $new_log_claim->NewLogRecord($claim_id, $user_id, "Заявка $status (фин. показатели): ", sfConfig::get('logcliam_finance')); 
        $status_form_submit = $finance_claim->getIsClosed()?'Открыть':'Закрыть';
        return $this->renderPartial('boolForm',
        array('claim_id'=>$claim_id,
              'status'=>$status,
              'status_form_submit'=>$status_form_submit, 
              'url_change'=>$request->getParameter('url_change'))); 
      } 
    }
    //функция изменена, финансово закрывается сущность claim а не finance_claim(смотреть выше в закомменченом)
    public function executeChange_bool_claim(sfWebRequest $request)
    {
      if ($request->isXmlHttpRequest())
      {
        $claim_id = $request->getParameter('claim_id');
        $claim = Doctrine::getTable('claim')->find($claim_id);
        if ($claim->getIsClosedstuff()) 
        {
           $claim->setIsclosedstuff(false); 
        }  else  $claim->setIsclosedstuff(true);
        $claim->trySave();
        $status = $claim->getIsclosedstuff()?'Закрыта':'Открыта';
        $new_log_claim = new log_claim();
        $user_id = $this->getUser()->getAttribute('user_id',null, 'sfGuardSecurityUser');
        $new_log_claim->NewLogRecord($claim_id, $user_id, "Заявка $status (фин. показатели): "); 
        $status_form_submit = $claim->getIsclosedstuff()?'Открыть':'Закрыть';
        return $this->renderPartial('boolForm',
        array('claim_id'=>$claim_id,
              'status'=>$status,
              'status_form_submit'=>$status_form_submit, 
              'url_change'=>$request->getParameter('url_change'))); 
      } 
    }
    
    public function executeRefreshFilesTransfered(sfWebRequest $request)
    {
       return $this->renderPartial('ajaxAllDocuments', array('claim_id' => $request->getParameter('claim_id'))); 
    }
}
