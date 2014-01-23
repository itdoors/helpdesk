<?php

/**
 * userstuff form.
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class UserIntranetForm extends sfGuardUserForm
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
      //$this['is_blocked'],
      $this['is_super_admin'],
      $this['groups_list'],
      $this['permissions_list'],
      $this['doc_groups_list'],
      $this['sex_id'],
      $this['password'],
      $this['photo'],
      $this['contactinfo_list'],
      $this['about']
    );

    $years_range = range(date('Y') - 80, date('Y')-18);
    $years = array_combine($years_range, $years_range);

    $this->setWidget('birthday', new sfWidgetFormDate(array('years' => $years)));
    
    $sfUser = $this->getObject()->getStuff();
    $stuffAddForm = new stuffAddForm($sfUser);
    unset($stuffAddForm['user_id'], $stuffAddForm['description']);
    $this->embedForm('stuffform', $stuffAddForm );
 
    $this->widgetSchema->setNameFormat('user_intranet[%s]');
  }
  
  protected function findStuffBySfUser($sfUser_id)
  {
     if (!$sfUser_id) return null;
     return Doctrine::getTable('stuff')
     ->createQuery('s')
     ->where('s.user_id = ? ', $sfUser_id)
     ->execute()->getFirst(); 
  }
  
  public function save($con = null)
  {
    $isNew = false;
    
    if ($this->getObject()->isNew())
    {
      $isNew = true;
    }
    
    $object = parent::save();
    
    if ($isNew)
    {
      $object->setPassword('12345678');
      $object->save();
    }
    
    //set permission
    if ($isNew)
    {
      $user_id = $object->getId();
      $permission_id = $this->getPermossionIdByName('intranet');
      
      $user_permission = DOctrine::getTable('sfGuardUserPermission')
        ->createQuery('up')
        ->where('up.user_id = ?', $user_id)
        ->addWhere('up.permission_id = ? ', $permission_id)
        ->fetchOne();
        
      if (!$user_permission)  
      {
        unset($user_permission);
        $user_permission = new sfGuardUserPermission();
        $user_permission->setUserId($user_id);
        $user_permission->setPermissionId($permission_id);
        $user_permission->save();
      }
    }
      
    
    
    return $object;
  }
  
  public function getPermossionIdByName($name)
  {
    $permission = Doctrine::getTable('sfGuardPermission')
      ->createQuery('u')
      ->where('u.name = ?', $name)
      ->fetchOne();
    
    return $permission ? $permission->getId() : null;
  }
}
