<?php

/**
 * userclient form.
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class userclientForm extends sfGuardUserForm
{
  public function configure()
  {
    unset(
      $this['last_login'],
      $this['created_at'],
      $this['updated_at'],
      $this['salt'],
      $this['algorithm'],
      $this['is_active'],
      $this['is_super_admin'],
      $this['groups_list'],
      $this['permissions_list']
    );
    
    $this->widgetSchema['sex_id']->setOption('table_method','getOnlySex');
    $this->widgetSchema['password'] = new sfWidgetFormInputPassword();
    $this->validatorSchema['password']->setOption('required', false);
    $this->widgetSchema['password_again'] = new sfWidgetFormInputPassword();
    
    $this->validatorSchema['password_again'] = clone $this->validatorSchema['password'];

    $this->widgetSchema->moveField('password_again', 'after', 'password');

    $this->mergePostValidator(new sfValidatorSchemaCompare('password', sfValidatorSchemaCompare::EQUAL, 'password_again', array(), array('invalid' => 'The two passwords must be the same.')));
    
    $exist_client = Doctrine::getTable('sfGuardUser')->find($this->object->id);
    if ($exist_client) $bool = true; else $bool = false;
                                                                      
     $this->embedRelations(array(
    'Client' => array(
      'considerNewFormEmptyFields'    => array(),
      'noNewForm'                     => $bool,
      'newFormLabel'                  => 'Данные клиента',
      'displayEmptyRelations'         => false,
      'newFormAfterExistingRelations' => false,
      'multipleNewForms'              => false,
      'formClass'                     => 'clientAddForm',
      'newFormClass'                  => 'clientAddForm'
        )
                
     ));                                                                 
     /*$clientform = new clientForm();
     $this->embedForm('Client', $clientform);     */
     //$this->embedRelation('Client','clientAddForm');
                                                                      
       //$this->widgetSchema['user_id'] = new sfWidgetFormInputHidden();                                                             
    
                                                                     
    $this->widgetSchema->setNameFormat('user_clients[%s]'); 
    
  }
}
