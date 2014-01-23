<?php

/**
 * DocDocumentGroupSfGroups form.
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrinePluginFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
 
class DocDocumentGroupSfGroupsForm extends PluginDocDocumentGroupSfGroupsForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'sfguardgroup_id'      => new sfWidgetFormDoctrineChoice(array('multiple' => false, 'model' => 'sfGuardGroup', 'add_empty' =>false)),
      'actionkey'           => new sfWidgetFormChoice(array('choices' => array('action_show' => 'Просмотр', 'action_edit' => 'Редактирование', 'action_all' => 'Полный доступ'))),
    ));
    
    $this->setValidators(array(
      'sfguardgroup_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('sfGroups'), 'required' => true, 'multiple'=> false)),
      'actionkey'           => new sfValidatorString(),
    ));
    $row_format = "<div class='field'>%error%%field%%help%%hidden_fields%</div>";
    $decoratorFormat = '<div>%content%<div class="delete_embed_form"><a href="#">удалить</a></div></div>';
    $this->getWidgetSchema()->getFormFormatter()->setRowFormat($row_format);
    $this->getWidgetSchema()->getFormFormatter()->setDecoratorFormat($decoratorFormat);
    $this->widgetSchema->setNameFormat('group_permission[%s]'); 
  }
    
  public function updateObject($values = null)
  {
    return $this->getObject();
  }
  
  public function saveObjectsList($con = null, $values, $parentid)
  {
      
     if (!DocDocumentGroupSfGroups::isExist($values['sfguardgroup_id'], $parentid, $values['actionkey']))
     { 
         $newobj = new DocDocumentGroupSfGroups();
         $newobj->setDocdocumentgroupId($parentid);
         $newobj->setActionkey($values['actionkey']);
         $newobj->setSfguardgroupId($values['sfguardgroup_id']);
         $newobj->save();
     }
        
  }
} 
 
class GroupPermissionForm extends PluginDocDocumentGroupSfGroupsForm
{
  public function configure()
  {
      parent::setup();
      $this->setWidgets(array(
      'sfGuardGroup_list'      => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardGroup', 'add_empty' =>false)),
      //'docdocumentgroup_id' => new sfWidgetFormDoctrineChoice(array('multiple' => false, 'model' => 'DocDocumentGroup', 'add_empty' =>false)),
      'actionkey'           => new sfWidgetFormChoice(array('choices' => array('action_show' => 'Просмотр', 'action_edit' => 'Редактирование', 'action_all' => 'Полный доступ'))),
    ));
    
    $this->setValidators(array(
      'sfGuardGroup_list'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('sfGroups'), 'required' => true, 'multiple'=> true)),
      //'docdocumentgroup_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('DocGroups'), 'required' => false)),
      'actionkey'           => new sfValidatorString(),
    ));
    $this->widgetSchema->setNameFormat('group_permission[%s]'); 
    
  }
  
  
  
  public function saveObjectsList($con = null, $values, $parentid)
  {
      
      foreach ($values['sfGuardGroup_list'] as $groupid)
      {
          if (!DocDocumentGroupSfGroups::isExist($groupid, $parentid, $values['actionkey']))
          { 
              $newobj = new DocDocumentGroupSfGroups();
              $newobj->setDocdocumentgroupId($parentid);
              $newobj->setActionkey($values['actionkey']);
              $newobj->setSfguardgroupId($groupid);
              $newobj->save();
          }
          
      } 
        
  }
  
}
