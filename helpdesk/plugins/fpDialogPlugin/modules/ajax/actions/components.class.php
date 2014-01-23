<?php 

class ajaxComponents extends sfComponents
{
   public function executeAjaxField(sfWebRequest $request)
  {
      
  }
  public function executeBoolButton(sfWebRequest $request)
  {
     //$this->finance_claim = Doctrine::getTable('finance_claim')->getFinanceClaimByClaimId($this->claim_id);
     $this->claim = Doctrine::getTable('claim')->find($this->claim_id);
     
  }
  
  public function executeBoolForm(sfWebRequest $request)
  {
       
  }  
  
  public function executeAjaxFieldDialog(sfWebRequest $request)
  {
       
  }
  
  public function executeAjaxAllDocumentsList(sfWebRequest $request)
  {
     $this->documents = Doctrine::getTable('Documents')->getAllDocumetsByClaim($this->claim_id); 
  }
  
  
  public function executeShow_data_by_button(sfWebRequest $request)
  {
      
  }

}