<?php     

/**
 * comments form.
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class commentsForm extends BasecommentsForm
{
   
   public function configure()
  {
      unset(
        $this['user_id'], $this['createdatetime'], $this['isvisible'] 
      );
      
     $this->setWidget('description' , 
          new isicsWidgetFormTinyMCE(
             array(
                'tiny_options' => sfConfig::get('app_tiny_mce_my_settings', array()),
                
                 )
          ,
          array('class'=>'claim_message')
      ));  
      $this->setValidator('description' , new sfValidatorString(array('required' => false))); 
  }
  
  public function updateDefaultsFromObject()
  //public function updateFromObject()
  {
    $user_id = isset($this->robot_id) ? 0 : sfContext::getInstance()->getUser()->getAttribute('user_id',null, 'sfGuardSecurityUser');
    $this->getObject()->setCreatedatetime(date("Y-m-d H:i:s"));
    $this->getObject()->setUserId($user_id);
    parent::updateDefaultsFromObject();
    //parent::updateFromObject();
  }
  
  public function doSave($con = null)
   {
       if ($this->getObject()->isNew())
       {
           $user_id = sfContext::getInstance()->getUser()->getAttribute('user_id',null, 'sfGuardSecurityUser');
           //$user_id = isset($this->robot_id) ? 0 : sfContext::getInstance()->getUser()->getAttribute('user_id',null, 'sfGuardSecurityUser');
           $this->getObject()->setUserId($user_id);
           $this->getObject()->setCreatedatetime(date("Y-m-d H:i:s"));
       }
       parent::doSave();
       $comment = $this->getObject();
       $claim = $comment->getClaim();
       $claim->setIsread();
       // todo 9: отправка сообщений, factories
       $app = sfContext::getInstance()->getConfiguration()->getApplication();
       $except = array(
            $app,
            'dispatcher',
            'supervisor',
       );
       
       if ($comment->getIsvisible()) $except[] = 'client';
       $subject = SDtexts::getClient_Messages_Create_Subject($claim);
       $text = SDtexts::getClient_Messages_Create_Text($claim);
       MailFunctions::sendMessageForAllExcept($claim, $except, $subject, $text);   
   }   
  
}
              
              
class commentsAttachForm extends BasecommentsForm
{
  public function configure()
  {
      unset(
        $this['user_id'], $this['createdatetime']
      );
      $this->setWidget('description' , 
          new isicsWidgetFormTinyMCE(
             array(
                'tiny_options' => sfConfig::get('app_tiny_mce_my_settings', array()),
                
                 )
          ,
          array('class'=>'claim_message')
      ));  
      $this->setValidator('description' , new sfValidatorBadString(array('required' => true)));
      
      $claim_id = sfContext::getInstance()->getUser()->getAttribute('claim_id');
      if ($claim_id)
      {
          $claim = Doctrine::getTable('claim')->find($claim_id);
          if ($claim->getIsclosedclient()) unset($this['is_visible']);
      }
      //DONE 7: на сервер
      
      $this->getWidgetSchema()->getFormFormatter()->setErrorRowFormat(
          "<div id=\"sf_admin_container\">
             <div class=\"error\">".
                $this->getWidgetSchema()->getFormFormatter()->translate('Invalid.').
             "</div>
          </div>"
      );
      $this->embedAttach();
  }
  
  
  
  protected function embedAttach()
 {
  $attach_forms = new sfForm();

  //we only need the form container for embedding form via ajax,
  if (false === sfContext::getInstance()->getRequest()->isXmlHttpRequest())
  {
      $attach_s = $this->getObject()->getAttach();
      foreach ($attach_s as $key=>$v)
      {
           $attachForm = new attachForm($v);
           unset($attachForm['comments_id']);
           $attach_forms->embedForm('attach'.($key+1), $attachForm);
           $attach_forms->widgetSchema['attach'.($key+1)]->setLabel('Attach'.($key+1));
      } 
  }
  $this->embedForm('attach', $attach_forms);
  $this->widgetSchema['attach']->setLabel('Attach');
 }
 
  public function addAttachForm($key)
  {
     $attach_s = new attach();
     $attach_s->setComments($this->getObject());
     $attach_form = new attachForm($attach_s);
     unset($attach_form['comments_id']);
     $this->embeddedForms['attach']->embedForm($key, $attach_form);
     $this->embedForm('attach', $this->embeddedForms['attach']);
  } 
 
  public function bind(array $taintedValues = null, array $taintedFiles = null)
  {
   if (isset($taintedValues['attach'])){
        foreach($taintedValues['attach'] as $key=>$form)
        {
           if (false === $this->embeddedForms['attach']->offsetExists($key))
           {
               if ($form['filename'] || $taintedFiles['attach'][$key]['filepath']['size'])
               {
                  $this->addAttachForm($key);
               } else {
                   unset($taintedValues['attach'][$key], $taintedFiles['attach'][$key]);
               }
           }
        } 
   }
   parent::bind($taintedValues, $taintedFiles);
  }
  
  
  public function doSave($con = null)
   {
       if ($this->getObject()->isNew())
       {
           $user_id = sfContext::getInstance()->getUser()->getAttribute('user_id',null, 'sfGuardSecurityUser');
           //$user_id = isset($this->robot_id) ? 0 : sfContext::getInstance()->getUser()->getAttribute('user_id',null, 'sfGuardSecurityUser');
           $this->getObject()->setUserId($user_id);
           $this->getObject()->setCreatedatetime(date("Y-m-d H:i:s"));
       }
       parent::doSave();
       $comment = $this->getObject();
       $claim = $comment->getClaim();
       $claim->setIsread();
       // todo 9: отправка сообщений, factories
       $app = sfContext::getInstance()->getConfiguration()->getApplication();
       $except = array(
            $app,
            'dispatcher',
            'supervisor',
       );
       
       if ($comment->getIsvisible()) $except[] = 'client';
       $subject = SDtexts::getClient_Messages_Create_Subject($claim);
       $text = SDtexts::getClient_Messages_Create_Text($claim);
       MailFunctions::sendMessageForAllExcept($claim, $except, $subject, $text);
   }   
  
}


class commentsAttachClientForm extends commentsAttachForm
{
   public function configure()
   {
       parent::configure();
       $this->setWidget('claim_id', new sfWidgetFormInputHidden());
       unset($this['isvisible']); 
   }
   
   public function doSave($con = null)
   {
       $this->getObject()->setIsvisible(false);
       parent::doSave();
       

   }
}

class sfValidatorBadString extends sfValidatorString
{
    
  protected function configure($options = array(), $messages = array())
  {
    parent::configure($options, $messages);
  }
  
 
  protected function doClean($value)
  {
      parent::doClean($value);
      $bad_string_array = array(
         "хуй",
         "пизда",
         "пизда",
         "жопа",
         "сбой в Сервис Деск",
         
      );
      foreach ($bad_string_array as $string)
      {
        // if (stripos($value, $string) || stripos($value, ucfirst($string))|| stripos($value, lcfirst($string))) 
        // if (stripos($value, $string) || stripos($value, ucfirst($string))|| stripos($value, lcfirst($string))) 
        //todo 8: на сервере нет функции lcfirst
         if (stripos($value, $string) || stripos($value, ucfirst($string))) 
         {
           throw new sfValidatorError($this,  'Invalid value', array('value' => $value));
         }  
      }
      return $value;
      
  }
 

} 

// todo 8: форма фиспетчера для коментариев
class commentsAttachDispatcherForm extends commentsAttachForm
{
   public function configure()
   {
       parent::configure();
       $this->setWidget('claim_id', new sfWidgetFormInputHidden());
       
   }
   
   public function doSave($con = null)
   {
       parent::doSave();

   }
}

class commentsAttachSupervisorForm extends commentsAttachDispatcherForm
{

}  

class commentsAttachSmetaForm extends commentsAttachDispatcherForm
{

}            
class commentsAttachFinanceForm extends commentsAttachDispatcherForm
{

}            


class commentsAttachKuratorForm extends commentsAttachForm
{
   public function configure()
   {
       parent::configure();
       $this->setWidget('claim_id', new sfWidgetFormInputHidden());
       
   }
   
   public function doSave($con = null)
   {
       parent::doSave();

   }
}     


class commentsAttachStuffForm extends commentsAttachForm
{
   public function configure()
   {
       parent::configure();
       $this->setWidget('claim_id', new sfWidgetFormInputHidden());
       unset($this['isvisible']);  
   }
   
   public function doSave($con = null)
   {
       $this->getObject()->setIsvisible(true);
       parent::doSave();

   }
}

class commentsAttachOperForm extends commentsAttachStuffForm
{}


