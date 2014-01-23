<?php 

class categoryComponents extends sfComponents
{
  public function executeCategory_list(sfWebRequest $request)
  {
      
  }
  
  public function executeDocuments_list(sfWebRequest $request)
  {
     $this->documents = Doctrine::getTable('DocDocument')->getDocumentsByCategoryId($this->category_id);  
  }
  
  public function executeForm_load_template(sfWebRequest $request)
  {
      
  }
  
  public function executeBreadcrumbs(sfWebRequest $request)
  {
      //если мы находимся на странице просмотра версий надо последний элемент
      //хвоста сделать активным
/*      $module = sfContext::getInstance()->getModuleName();
      $document_id = $document_id = $this->getUser()->getAttribute('document_id');
      if ($document_id && $module='docdocument') 
      {
          $document = Doctrine::getTable('DocDocument')->find($document_id);
          $parent_id = $document->getCategoryId();
      }  else */ 
      
      $parent_id = $this->getUser()->getAttribute('category_id');
      
      $category_id = $parent_id ? $parent_id : 0;
      
      if ($category_id)
      {
         $this->current_category = Doctrine::getTable('DocDocumentGroup')->find($category_id); 
      }
      else 
      {
         $this->current_category = null;  
      }
      
  }


}