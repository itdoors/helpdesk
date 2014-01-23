<?php

/**
 * DocDocument form.
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrinePluginFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class DocDocumentForm extends PluginDocDocumentForm
{
  public function configure()
  {
      
      
      $category_id = sfContext::getInstance()->getUser()->getAttribute('category_id');
      if ($category_id&&$this->getObject()->isNew()) 
      {
         $category_choices = $this->getCategoryById($category_id);
         $this->setWidget('category_id', new sfWidgetFormChoice(array('choices' => $category_choices)));
         $this->setDefault('category_id', $category_id); 
      } else
      {
         $this->setWidget('category_id', new sfWidgetFormDoctrineChoiceTree(array('model' => $this->getRelatedModelName('Category'),'table_method' => 'getParentTree','method'=>'getTreeElement', 'add_empty' => true))); 
      }     
      
      $this->setValidator('category_id', new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Category'), 'required' => false)));
      $this->useFields(array(
        'name',
        'description',
        'tags',
        'category_id',
        //'user_id'
        )
      );
      if ($this->getObject()->isNew())
      {
         $DocDocumentVersion = new DocDocumentVersion();
         $DocDocumentVersion->setDocDocument($this->getObject());
         $DocDocumentVersionForm = new DocDocumentVersionForm($DocDocumentVersion);
         unset($DocDocumentVersionForm['document_id']);
         $this->embedForm('doc_version', $DocDocumentVersionForm); 
      }
      
  
  }

  protected function getCategoryById($category_id)
  {
      $q = Doctrine::getTable('DocDocumentGroup')->find($category_id);
      return array($category_id => $q->getName());
  }
  
   public function updateObject($values = null)
  {
    if (null === $values)
    {
      $values = $this->values;
    }
    $values = $this->processValues($values);

    $this->doUpdateObject($values);

    // embedded forms
    //$this->updateObjectEmbeddedForms($values);

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
    $this->getObject()->save($con);
    sfContext::getInstance()->getUser()->setAttribute('document_id',  $this->getObject()->getId());
    $values = $this->values;
    $values = $this->processValues($values);
    
    $this->updateObjectEmbeddedForms($values);
    
    $this->saveEmbeddedForms($con);
   }  
   
 

}


