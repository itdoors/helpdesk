<?php

/**
 * userstuff form.
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class userstuffForm extends sfGuardUserForm
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
      $this['permissions_list'],
      $this['doc_groups_list']
    );

    $this->widgetSchema['sex_id']->setOption('table_method','getOnlySex');
    $this->widgetSchema['password'] = new sfWidgetFormInputPassword();
    $this->validatorSchema['password']->setOption('required', false);
    $this->widgetSchema['password_again'] = new sfWidgetFormInputPassword();
    
    $this->validatorSchema['password_again'] = clone $this->validatorSchema['password'];

    $this->widgetSchema->moveField('password_again', 'after', 'password');

    $this->mergePostValidator(new sfValidatorSchemaCompare('password', sfValidatorSchemaCompare::EQUAL, 'password_again', array(), array('invalid' => 'The two passwords must be the same.')));
    
    //$exist_client = Doctrine::getTable('sfGuardUser')->find($this->object->id);
    //if ($exist_client) $bool = true; else $bool = false;
    $sfUser = $this->getObject()->getStuff();
    //$stuff = $this->findStuffBySfUser($sfUser->getId());
    $stuffAddForm = new stuffAddForm($sfUser);
    unset($stuffAddForm['user_id']);
    $this->embedForm('stuffform', $stuffAddForm );
    
/*    $this->embedRelations(array(
    'Stuff' => array(
      'considerNewFormEmptyFields'    => array(),
      'noNewForm'                     => $bool,
      'newFormLabel'                  => 'Данные Сотрудника',
      //'displayEmptyRelations'         => false,
      'newFormAfterExistingRelations' => false,
      'multipleNewForms'              => false,
      'formClass'                     => 'stuffAddForm',
      'newFormClass'                  => 'stuffAddForm'
        )
                
     ));*/  
    $this->widgetSchema->setNameFormat('user_stuff[%s]');
  }
  
  protected function findStuffBySfUser($sfUser_id)
  {
     if (!$sfUser_id) return null;
     return Doctrine::getTable('stuff')
     ->createQuery('s')
     ->where('s.user_id = ? ', $sfUser_id)
     ->execute()->getFirst(); 
  }
}
