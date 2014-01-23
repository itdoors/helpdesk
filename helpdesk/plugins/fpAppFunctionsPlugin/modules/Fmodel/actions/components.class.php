<?php 

class FmodelComponents extends sfComponents
{
  public function executeAjax_field(sfWebRequest $request)
  {
      
  }
  
  public function executeForm_add(sfWebRequest $request)
  {
    if ($this->ref_functions_names)
    {
      $this->ref_functions_names = json_encode($this->ref_functions_names);
    }
  }
  
  public function executeDelete_record()
  {
    if ($this->ref_functions)
    {
      $this->ref_functions = json_encode($this->ref_functions);
    } 
  }
  
  public function executeDelete_record_advanced()
  {
    if ($this->ref_functions)
    {
      $this->ref_functions = json_encode($this->ref_functions);
    }
    
    if ($this->ref_functions_names)
    {
      $this->ref_functions_names = json_encode($this->ref_functions_names);
    }
    
    if ($this->where)
    {
      $this->where = json_encode($this->where);
    }
  }
  
  public function executeAjax_field_change()
  {
    $params= array(
      'where' => $this->where,
      'model' => $this->model,
      'field' => $this->field,
      'toString' => $this->toString
    );

    if ($this->withLabel)
    {
      $params['withLabel'] = $this->withLabel;
    }

    if ($this->form)
    {
      $params['form'] = $this->form;
    }

    if ($this->ref_functions)
    {
      $params['ref_functions'] = $this->ref_functions;
    }

    if ($this->ref_functions_names)
    {
      $params['ref_functions_names'] = $this->ref_functions_names;
    }

    $this->params = json_encode($params);
  }
  
  public function executeHistory()
  {
    $params = array(
      'model_id' => $this->model_id,
      'model_name' => $this->model_name
    );
    
    $this->params = json_encode($params);
  }
}