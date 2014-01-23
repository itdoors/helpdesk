<?php

/**
 * claim actions.
 *
 * @package    helpdesk
 * @subpackage claim
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class claimopenedActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->claimsopen = Doctrine_Core::getTable('claim')->getOpenedClaims();
  }

  
  public function executeClose(sfWebRequest $request)
  {
     $claim_id = $request->getParameter('claimid');
     $close_claim = Doctrine::getTable('claim')->find($claim_id);
     $close_claim->closeClaimClient();
     $user_id = $this->getUser()->getAttribute('user_id',null, 'sfGuardSecurityUser');
     $new_log_claim = new log_claim();
     $new_log_claim->NewLogRecord($close_claim->getId(), $user_id, sfConfig::get('logcliam_close'));
          
     $this->redirect('claimopened/index'); 
  }
  
  public function executeNew(sfWebRequest $request)
  {
    $this->form = new claimManagerNewForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));
    $form = new claimForm();
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isCSRFProtected())
    {
        $claim = $request->getParameter($form->getName());
        $new_claim = $form->getObject();
        //$new_claim->setIsreadclient(true); 
        $new_claim_id = $new_claim->saveManager($claim);
        
        $user_id = $this->getUser()->getAttribute('user_id',null, 'sfGuardSecurityUser');    
        $user_data = Doctrine::getTable('sfGuardUser')->find($user_id);
        $user_dispatcher = Doctrine::getTable('sfGuardUser')->findOneBy('username', sfConfig::get('user_dispatcher'));
        //die($user_dispatcher->getEmailAddress()); 
        if ($new_claim_id) 
        {
           $message = $this->getMailer()->compose(
              array('noreply@griffin.ua' => 'Service Desk Griffin'),
              $user_data->getEmailAddress(),
              'Заявка №'.$new_claim_id.' cоздана',
              'Спасибо, Ваш запрос принят и один из операторов ответит Вам в ближайшее время. 
Ниже приведена информация относительно вашего запроса.
Номер заявки: '.$new_claim_id.'
Отдел: '.$new_claim->getClaimtype().'
Адрес: '.$new_claim->getDepartments().'
Важность: '.$new_claim->getImportance().'
Куратор: '.$new_claim->getKurator().'
Исполнитель: '.$new_claim->getStuff().'


Подробную информацию можно получить по адресу: http://helpdesk.griffin.ua/
                                                                                              
Не отвечайте на это письмо.
'
           );
           $this->getMailer()->send($message);
           //mail('ppehcheny@i.ua','dd','dd');
           
           $message = $this->getMailer()->compose(
              array('noreply@griffin.ua' => 'Service Desk Griffin'),
              //'muzyka@luckry.com',
              $user_dispatcher->getEmailAddress(),
              'Заявка №'.$new_claim_id.' cоздана',
              'Поступила заявка.
Ниже приведена информация относительно запроса.
Номер заявки: '.$new_claim_id.'
Отдел: '.$new_claim->getClaimtype().'
Важность: '.$new_claim->getImportance().'

Подробную информацию можно получить по адресу: http://helpdesk.griffin.ua/dispatcher.php/
                                                                                              
Не отвечайте на это письмо.
'
           );
           $this->getMailer()->send($message);
        }                  
        
        
        
        $new_comment = new comments();
        $new_comment->saveManager($claim, $new_claim_id);
        
        
        $new_log_claim = new log_claim();
        $new_log_claim->NewLogRecord($new_claim_id, $user_id, sfConfig::get('logcliam_newclaim'));   
        

        
   } else $this->getUser()->setFlash('error','Ошибка добавления заявки');
       
    $this->redirect('claimopened/index');
  }

  
}
