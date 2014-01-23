<?php

/**
 * DocDocumentGroup form.
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrinePluginFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class DocDocumentGroupForm extends PluginDocDocumentGroupForm
{
  public function configure()
  {
      $this->useFields(
      array(
         'name',
         'description',
         'parent_id',
         
         )
      );
      $category_id = sfContext::getInstance()->getUser()->getAttribute('category_id');
      //die("Xxx");
      if ($category_id&&$this->getObject()->isNew()) 
      {
         $category_choices = $this->getCategoryById($category_id);
         $this->setWidget('parent_id', new sfWidgetFormChoice(array('choices' => $category_choices)));
         $this->setDefault('parent_id', $category_id); 
      } else
      { 
         $this->setWidget('parent_id' , new sfWidgetFormDoctrineChoiceTree(array('model' => $this->getRelatedModelName('ParentCategory'),'table_method' => 'getParentTree','method'=>'getTreeElement', 'add_empty' => true)));
      } 
      //$this->setWidget('parent_id' , new sfWidgetFormDoctrineChoiceTree(array('model' => $this->getRelatedModelName('ParentCategory'), 'add_empty' => true)));  
      $this->setValidator('parent_id', new sfValidatorDoctrineChoiceParent(array('model' => $this->getRelatedModelName('ParentCategory'), 'required' => false, 'object_id'=>$this->getObject()->getId())));
      $user_permission_forms = new sfForm();
      $group_permission_forms = new sfForm();
      $users_exists = $this->getObject()->getDocDocumentGroupSfUsers();
      $groups_exists = $this->getObject()->getDocDocumentGroupSfGroups();
      //если действие update надо подключить все формы заново, при узменении полей формы на disabled
      //значения не передаются, а формы подключаются 
      if (sfContext::getInstance()->getActionName() == 'edit') 
      {
          foreach($users_exists as $key=>$value)
          {
             $DocDocumentGroupsfUsersForm = new DocDocumentGroupSfUsersForm($value);
             $DocDocumentGroupsfUsersForm->widgetSchema->setAttribute('cross', 'user_permissions'.($key+1)); 
             unset($DocDocumentGroupsfUsersForm['docdocumentgroup_id']);
             $user_permission_forms->embedForm('user_permissions'.($key+1), $DocDocumentGroupsfUsersForm);
             
          }
          foreach($groups_exists as $key=>$value)
          {
             $DocDocumentGroupsfGropsForm = new DocDocumentGroupSfGroupsForm($value);
             $DocDocumentGroupsfGropsForm->widgetSchema->setAttribute('cross', 'group_permissions'.($key+1)); 
             unset($DocDocumentGroupsfGropsForm['docdocumentgroup_id']);
             $group_permission_forms->embedForm('group_permissions'.($key+1), $DocDocumentGroupsfGropsForm);
             
          } 
      }
      


      $this->embedForm('user_permissions', $user_permission_forms); 
      $this->embedForm('group_permissions', $group_permission_forms);
      
     
  }
  protected function getCategoryById($category_id)
  {
      $q = Doctrine::getTable('DocDocumentGroup')->find($category_id);
      return array($category_id => $q->getName());
  }
  
  /*
  в зависимости от места из которого вызывается действие
  подключается разные формы 
  CategoryPermissionForm - multiply список пользователей
  DocDocumentGroupSfUsersForm - один пользователь, который уже добавлен в базу
  */
  public function addUsersPermissionForm($key, $formName)
  {
     
      $DocDocumentGroupsfUsers = new DocDocumentGroupSfUsers();
      $DocDocumentGroupsfUsers->setDocGroups($this->getObject());
      $permission_form =  new $formName($DocDocumentGroupsfUsers);
      $permission_form->widgetSchema->setAttribute('cross', $key); 
      unset($permission_form['docdocumentgroup_id']);
      $this->embeddedForms['user_permissions']->embedForm($key, $permission_form);
      $this->embedForm('user_permissions', $this->embeddedForms['user_permissions']);

  } 
  
  /*
  в зависимости от места из которого вызывается действие
  подключается разные формы 
  GroupPermissionForm - multiply список групп(должностей)
  DocDocumentGroupSfGroupsForm - одна группа, которая уже добавлена в базу
  */
  public function addGroupPermissionForm($key, $formname)
  {
      $DocDocumentGroupsfGroups = new DocDocumentGroupSfGroups();
      $DocDocumentGroupsfGroups->setDocGroups($this->getObject());
      $group_permission_form =  new $formname($DocDocumentGroupsfGroups);
      $group_permission_form->widgetSchema->setAttribute('cross', $key); 
      unset($group_permission_form['docdocumentgroup_id']);
      $this->embeddedForms['group_permissions']->embedForm($key, $group_permission_form);
      $this->embedForm('group_permissions', $this->embeddedForms['group_permissions']);

  } 
  
  
  
   public function bind(array $taintedValues = null, array $taintedFiles = null)
  {
   if (isset($taintedValues['user_permissions'])){
        foreach($taintedValues['user_permissions'] as $key=>$form)
        {
           //  $formname - тип формы, определяется по передаваемым параметрам
           $formname = isset($form['sfGuardUser_list']) ? 'CategoryPermissionForm':( isset($form['sfguarduser_id'])?'DocDocumentGroupSfUsersForm':'CategoryPermissionForm');
           if (false === $this->embeddedForms['user_permissions']->offsetExists($key))
           {
               $this->addUsersPermissionForm($key, $formname);
           }
        } 
   }
   if (isset($taintedValues['group_permissions'])){
      foreach($taintedValues['group_permissions'] as $key=>$form)
        {
           //  $formname - тип формы, определяется по передаваемым параметрам
           $formname = isset($form['sfGuardGroup_list']) ? 'GroupPermissionForm':( isset($form['sfguardgroup_id'])?'DocDocumentGroupSfGroupsForm':'GroupPermissionForm');
           if (false === $this->embeddedForms['group_permissions']->offsetExists($key))
           {
               $this->addGroupPermissionForm($key, $formname);
           }
        }             
   }
   
   parent::bind($taintedValues, $taintedFiles);
  }
  
  public function save($con = null)
  {
    

    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $this->doSave($con);
  
    
    return $this->getObject();
   
  } 
  
  public function doSave($con = null)
  {
    $this->updateObject();
    if ($this->getObject()->isNew())
    {
        $user_id = sfContext::getInstance()->getUser()->getAttribute('user_id',null, 'sfGuardSecurityUser');
        $this->getObject()->setCreatedatetime(date("Y-m-d H:i:s"));
        $this->getObject()->setUserId($user_id);
     }
    $this->getObject()->save();
    // embedded forms
    $this->saveEmbeddedForms($con);
    
    //$this->saveEmbeddedForms($con);    
      
   } 
    
   public function saveEmbeddedForms($con = null, $forms = null)
  {

    //die($this->getObject()->getName());
    if (null === $con)
    {
      $con = $this->getConnection();
    }

    if (null === $forms)
    {
      $forms = $this->embeddedForms;
    }
    
    $user_values =  $this->getValue('user_permissions');
    $group_values =  $this->getValue('group_permissions');
    $this->deleteAllChildren();
    foreach ($forms as $form)
    {
      if ($form instanceof sfFormObject)
      {
           
        /*foreach($values as $embeded_forms_values) 
        { } */
        $lab = $form->widgetSchema->getAttribute('cross');
        
        $str_user_count = substr_count($lab,"user");
        $values = $str_user_count?$user_values:$group_values;
          
        $form->saveObjectsList($con, $values[$lab], $this->getObject()->getId());
        
      }
      else
      {
        $this->saveEmbeddedForms($con, $form->getEmbeddedForms());
      }
    }
  }
    
  protected function deleteAllChildren()
  {
      $exist_users = $this->getObject()->getDocDocumentGroupSfUsers();
      foreach($exist_users as $user)
      {
         $user->delete(); 
      }
      
      $exist_groups = $this->getObject()->getDocDocumentGroupSfGroups();
      foreach($exist_groups as $group)
      {
         $group->delete(); 
      };

  } 

}

class sfValidatorDoctrineChoiceParent extends sfValidatorDoctrineChoice
{
  protected function configure($options = array(), $messages = array())
  {
     parent::configure();
     $this->addOption('object_id'); 
  }
 
  protected function doClean($values)
  {
    parent::doClean($values);
    $id = $this->getOption('object_id');
    if (!$id) return $values;
    $errorSchema = new sfValidatorErrorSchema($this);
    if ($id == $values)
    {
        throw new sfValidatorError($this, 'You can\'t choose this element', array('value' => $values));
    }
    $arr = array();
    $this->getParentKeys($id, $arr);
    if (in_array($values, $arr))
    {
        throw new sfValidatorError($this, 'You can\'t choose this element', array('value' => $values));
    }
    return $values;
  } 
  
  protected function getParentKeys($id = 0, &$arr = array())
  {
      $q = Doctrine::getTable('DocDocumentGroup')
      ->createQuery('d')
      ->select('d.id')
      ->where('d.parent_id = '.$id)
      ->execute();
      foreach ($q as $key => $value)
      {
          $arr[] = $value['id'];
          $this->getParentKeys($value['id'], $arr);
      }
  }
  
}
