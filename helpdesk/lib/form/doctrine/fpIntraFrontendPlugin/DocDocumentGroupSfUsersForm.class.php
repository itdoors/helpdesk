<?php

/**
 * DocDocumentGroupSfUsers form.
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrinePluginFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class DocDocumentGroupSfUsersForm extends PluginDocDocumentGroupSfUsersForm
{
  public function configure()
  {
     $this->setWidgets(array(
      'sfguarduser_id'      => new sfWidgetFormDoctrineChoice(array('multiple' => false, 'model' => 'sfGuardUser', 'add_empty' =>false)),
      //'docdocumentgroup_id' => new sfWidgetFormDoctrineChoice(array('multiple' => false, 'model' => 'DocDocumentGroup', 'add_empty' =>false)),
      'actionkey'           => new sfWidgetFormChoice(array('choices' => array('action_show' => 'Просмотр', 'action_edit' => 'Редактирование', 'action_all' => 'Полный доступ'))),
    ));
    
    $this->setValidators(array(
      'sfguarduser_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('sfUsers'), 'required' => true, 'multiple'=> false)),
      //'docdocumentgroup_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('DocGroups'), 'required' => false)),
      'actionkey'           => new sfValidatorString(),
    ));
    $row_format = "<div class='field'>%error%%field%%help%%hidden_fields%</div>";
    $decoratorFormat = '<div>%content%<div class="delete_embed_form"><a href="#">удалить</a></div></div>';
    $this->getWidgetSchema()->getFormFormatter()->setRowFormat($row_format);
    $this->getWidgetSchema()->getFormFormatter()->setDecoratorFormat($decoratorFormat);
    $this->widgetSchema->setNameFormat('user_permission[%s]'); 
  }



  public function saveObjectsList($con = null, $values, $parentid)
  {
     if (!DocDocumentGroupSfUsers::isExist($values['sfguarduser_id'], $parentid, $values['actionkey']))
     {        
       $newobj = new DocDocumentGroupSfUsers();
       $newobj->setDocdocumentgroupId($parentid);
       $newobj->setActionkey($values['actionkey']);
       $newobj->setSfguarduserId($values['sfguarduser_id']);
       $newobj->save();
     }
         
  }
  
  public function updateObject($values = null)
  {
   
    return $this->getObject();
  }
  

  
  
}

class CategoryPermissionForm extends PluginDocDocumentGroupSfUsersForm
{
  public function configure()
  {
      parent::setup();
      $this->setWidgets(array(
      'sfGuardUser_list'      => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardUser', 'add_empty' =>false)),
      'actionkey'           => new sfWidgetFormChoice(array('choices' => array('action_show' => 'Просмотр', 'action_edit' => 'Редактирование', 'action_all' => 'Полный доступ'))),
    ));
    
    $this->setValidators(array(
      'sfGuardUser_list'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('sfUsers'), 'required' => true, 'multiple'=> true)),
      'actionkey'           => new sfValidatorString(),
    ));
    
    
    $this->widgetSchema->setNameFormat('user_permission[%s]'); 
    
  }
  

  
  public function saveObjectsList($con = null, $values, $parentid)
  {
      //функция вызывается при добавлении новой записи(или update если пустое значение) когда значени multiply 
      foreach ($values['sfGuardUser_list'] as $userid)
      {
          if (!DocDocumentGroupSfUsers::isExist($userid, $parentid, $values['actionkey']))
          {        
              $newobj = new DocDocumentGroupSfUsers();
              $newobj->setDocdocumentgroupId($parentid);
              $newobj->setActionkey($values['actionkey']);
              $newobj->setSfguarduserId($userid);
              $newobj->save();
           }
          
      } 
        
  }
  

  
  
}
