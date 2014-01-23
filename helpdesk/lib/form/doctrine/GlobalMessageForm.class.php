<?php

/**
 * GlobalMessage form.
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class GlobalMessageForm extends BaseGlobalMessageForm
{
  public function configure()
  {
    unset($this['createdatetime'], $this['user_id']);
    $this->setWidget('description' , 
          new isicsWidgetFormTinyMCE(
             array(
                'tiny_options' => sfConfig::get('app_tiny_mce_my_settings', array()),
                
                 )
          ,
          array('class'=>'claim_message')
      ));
  }
  
  public function save($conn = null)
  {                   
    $object = parent::save($conn);
    
    $object->setUserId(GlobalFunctions::getUserId());
    $object->setCreatedatetime(date("Y-m-d H:i:s")); 
    $object->save();
    return $object;
  }
}
