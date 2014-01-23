<?php

require_once dirname(__FILE__).'/../lib/BaseFmodelActions.class.php';

/**
 * Fmodel actions.
 * 
 * @package    fpAppFunctionsPlugin
 * @subpackage Fmodel
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12534 2008-11-01 13:38:27Z Kris.Wallsmith $
 */
class FmodelActions extends BaseFmodelActions
{
    public function executeEdit_field(sfWebRequest $request)
    {
      if ($request->isXmlHttpRequest())
      {
          $model = $request->getParameter('model');
          $field = $request->getParameter('field');
          $id = $request->getParameter('id');
          $toString = $request->getParameter('toString');
          $form_class = $model."Form";
          $default = Doctrine::getTable($model)->find($id);
          $form = new $form_class($default);
          $form->useFields(array($field));
          return $this->renderPartial('edit_field', array('form'=>$form, 'field'=>$field, 'model'=>$model, 'id'=>$id, 'toString'=>$toString));
      }
    }
    public function executeSave_field(sfWebRequest $request)
    {
      if ($request->isXmlHttpRequest())
      { 
          $model = $request->getParameter('model');
          $field = $request->getParameter('field');
          $id = $request->getParameter('id');
          $toString = $request->getParameter('toString');
          $default = Doctrine::getTable($model)->find($id);
          $form_class = $model."Form";
          $form = new $form_class($default, $default);
          $form->useFields(array($field));
          $form->bind($request->getParameter($form->getName()),$request->getFiles($form->getName()));
          if ($form->isValid())
          {
              $form->save();
              $object = $form->getObject();
              $object->objectFieldSaveToLogClaim($field, $toString);
              return $this->renderText($object->$toString());

          }  
          return $this->renderPartial('edit_field', array('form'=>$form, 'field'=>$field, 'model'=>$model, 'id'=>$id, 'toString'=>$toString));
          
      }
    }
    
    
    public function executeEdit_form(sfWebRequest $request)
    {
      if ($request->isXmlHttpRequest())
      {
          $model = $request->getParameter('model');
          $default = $request->getParameter('default');
          $form_base_class = $request->getParameter('form_class');
          $form_class =  $form_base_class."Form";
          if ($request->getParameter('form_class') != $request->getParameter('model'))
          {
              $object = new $model();
                if ($default){
                    foreach ($default as $key => $value)
                    {
                        $object->$key = $value;
                    }
                }
               $form = new $form_class($object);
          }
          else
          {
            $form = new $form_class(null, $default);
          }

          if ($default){
              foreach ($default as $key => $value)
              {
                  $form->setWidget($key, new sfWidgetFormInputHidden);
                  $form->setDefault($key, $value);
              }
          }
          if ($default) return $this->renderPartial('edit_form', array('form'=>$form, 'model'=>$model, 'form_class'=>$form_base_class, 'default'=>$default));
          return $this->renderPartial('edit_form', array('form'=>$form, 'model'=>$model, 'form_class'=>$form_base_class));
      }
    }
    public function executeSave_form(sfWebRequest $request)
    {
      $model = $request->getParameter('model');
      $default = $request->getParameter('default');
      $form_base_class = $request->getParameter('form_class');
      $form_class = $form_base_class."Form";
      //$form_class = $model."Form";
      $form = new $form_class(null, $default);
      if ($default){
          foreach ($default as $key => $value)
          {
              $form->setWidget($key, new sfWidgetFormInputHidden);
              //$form->setDefault($key, $value);
          }
      }

      $form->bind($request->getParameter($form->getName()),$request->getFiles($form->getName()));

      if ($form->isValid())
      {
          $form->save();
          $return = array(
            'success' => 1,
            'text' => 'сохранено'
          );

          return $this->renderText(json_encode($return));
      }

      $return = array(
        'success' => 0,
      );

      if ($default)
      {
        $return['text'] = $this->getPartial('edit_form', array('form'=>$form, 'model'=>$model,'form_class'=>$form_base_class, 'default'=>$default));
      }
      else
      {
        $return['text'] = $this->getPartial('edit_form', array('form'=>$form, 'model'=>$model, 'form_class'=>$form_base_class));
      }

      return $this->renderText(json_encode($return));
    }
    
    public function executeDelete(sfWebRequest $request)
    {
        if (!$request->isXmlHttpRequest()) return $this->renderText('Direct access');
        $model = $request->getParameter('model');
        $field = $request->getParameter('field');
        $id = $request->getParameter('id');
        $default = Doctrine::getTable($model)->find($id);
        $default->delete();
        return true;
    }
    
    
    public function executeDelete_record(sfWebRequest $request)
    {
      if (!$request->isXmlHttpRequest()) return $this->renderText('Direct access');
      
      $model = $request->getParameter('model');
      $id = $request->getParameter('id');
      $default = Doctrine::getTable($model)->find($id);
      $default->delete();
      return true;
    }
    
    
    
    public function executeAjax_field_edit(sfWebRequest $request)
    {
      if ($request->isXmlHttpRequest())
      {
          $params = $request->getParameter('params');
        
          $model = $params['model'];
          $fields = explode(',', $params['field']);
          $params['fields'] = $fields;
          $where = $params['where'];
          $toString = $params['toString'];

          $form_class = $model."Form";

          if (isset($params['form']))
          {
            $form_class = $params['form'];
          }

          $query = Doctrine::getTable($model)
            ->createQuery();
          foreach($where as $key => $value)
          {
            $query->addWhere($key . ' = ?', $value);
          };  
          $default = $query->fetchOne();
          
          if (!$default)
          {
            $default = new $model();
            
            foreach($where as $key => $value)
            {
              $default->set($key, $value);
            };
          }
          
          $form = new $form_class($default);
          $form->useFields($fields);
          foreach ($fields as $field)
          {
            $form->getWidget($field)->setAttribute('class', 'form_value');
          }
          return $this->renderPartial('ajax_field_edit', array('form'=>$form, 'params' =>$params));
      }
    }
    
  public function executeAjax_field_save(sfWebRequest $request)  
  {
    $return = array();
    
    if ($request->isXmlHttpRequest())
    { 
      $params = $request->getParameter('params');
        
      $model = $params['model'];
      $field = $params['field'];
      $fields = explode(',', $params['field']);
      $params['fields'] = $fields;
      $where = $params['where'];
      $toString = $params['toString'];
      $form_class = $model."Form";

      if (isset($params['form']))
      {
        $form_class = $params['form'];
      }

      $query = Doctrine::getTable($model)
        ->createQuery();
      foreach($where as $key => $value)
      {
        $query->addWhere($key . ' = ?', $value);
      };  
      $default = $query->fetchOne();

      $previous = null;

      if ($default)
      {
        $previous = clone $default;
      }
      
      if (!$default)
      {
        $default = new $model();
        
        foreach($where as $key => $value)
        {
          $default->set($key, $value);
        };
      }
      $form = new $form_class($default, $default);
      $form->useFields($fields);
      foreach ($fields as $field)
      {
        $form->getWidget($field)->setAttribute('class', 'form_value');
      }

      $form->bind($request->getParameter($form->getName()),$request->getFiles($form->getName()));
      if ($form->isValid())
      {
          //$previousObject = $form->getObject();
          $form->save();
          $object = $form->getObject();
          if (method_exists($object, 'objectFieldSaveToLogClaim'))
          {
            $object->objectFieldSaveToLogClaim($field, $toString);
          }
          
          if (method_exists($object, 'history'))
          {
            $object->history($field, $toString, $previous);
          }
          
          $return['success'] = true;
          $return['result'] = $object->$toString(); 
      }
      else
      {
        $return['error'] = true;
        $return['form_partial'] = $this->getPartial('ajax_field_edit', array('form'=>$form, 'params' => $params));
      }
      
      return $this->renderText(json_encode($return));
        
    }
  }
  
  public function executeHistory(sfWebRequest $request)
  {
    if ($request->isXmlHttpRequest())
    {
      $params = $request->getParameter('params');
      
      $list = HistoryTable::getHistoryByIdAndModel($params['model_id'], $params['model_name']);
      return $this->renderPartial('Fmodel/history_show', array('list' => $list ));
    }   
    
    return $this->renderText('Direct access');
  }
  
  public function executeDelete_record_advanced(sfWebRequest $request)
  {
    if (!$request->isXmlHttpRequest()) return $this->renderText('Direct access');
    
    $model = $request->getParameter('model');
    $where = json_decode($request->getParameter('where'));
    
    $query = Doctrine::getTable($model)
      ->createQuery();
    foreach($where as $key => $value)
    {
      $query->addWhere($key . ' = ?', $value);
    };  
    $default = $query->fetchOne();

    $default->delete();
    return true;
  }
}
