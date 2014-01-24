<?php

/**
 * sfGuardUser form.
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrinePluginFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sfGuardUserForm extends PluginsfGuardUserForm
{
  public function configure()
  {
  }
}

class sfGuardUserChangePass extends PluginsfGuardUserForm
{
  public function configure()
  {
    parent::setup();

    $this->useFields(array('password'));

    $this->widgetSchema['password'] = new sfWidgetFormInputPassword();
    $this->validatorSchema['password']->setOption('required', true);
    $this->widgetSchema['password_again'] = new sfWidgetFormInputPassword();
    $this->validatorSchema['password_again'] = clone $this->validatorSchema['password'];
    $this->validatorSchema['password_again']->setOption('required', true);

    $this->mergePostValidator(new sfValidatorSchemaCompare('password', sfValidatorSchemaCompare::EQUAL, 'password_again', array(), array('invalid' => 'The two passwords must be the same.')));
  
  }
  
}

class UserIntranetProfileAboutForm extends PluginsfGuardUserForm
{
  public function configure()
  {
    parent::setup();
   
    $this->useFields(
    array(
           'about'
        )
    );
  }
}

class IntranetContactInfoForm extends PluginsfGuardUserForm
{
  public function configure()
  {
    $user_contactinfo_forms = new sfForm();
    $contacts_exists = $this->getObject()->getUserContactinfo();
    foreach($contacts_exists as $key=>$value)
    {
       $UserContactinfoForm = new UserContactinfoForm($value);
       unset($UserContactinfoForm['user_id']);
       $user_contactinfo_forms->embedForm('user_contactinfo'.($key+1), $UserContactinfoForm);
    }             
    
     $this->embedForm('user_contactinfos', $user_contactinfo_forms); 

  }
  
}


  
  
