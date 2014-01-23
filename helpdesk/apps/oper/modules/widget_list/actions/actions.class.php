<?php

/**
 * widget_list actions.
 *
 * @package    helpdesk
 * @subpackage widget_list
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class widget_listActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    //$this->forward('default', 'module');
    
    $user_id = $this->getUser()->getId();
    
    $credentialIds = $this->getUser()->getCredentialIds();
    
    $widget_list = $this->getWidgetList($credentialIds);
    
    $this->widget_list = $widget_list;  
  }
  
  public function getWidgetList($credentialIds)
  {
    if (!sizeof($credentialIds))
    {
      return array();
    }
    
    $widgetIdsCollection = WidgetListPermissionTable::getInstance()
      ->createQuery()
      ->select('widget_id')
      ->whereIn('permission_id', $credentialIds) 
      ->fetchArray();
      
    if (!sizeof($widgetIdsCollection))
    {
      return array();
    }
    
    $widgetIds = GlobalFunctions::getFormattedArray($widgetIdsCollection, 'widget_id');
      
    $widgets = WidgetListTable::getInstance()
      ->createQuery()
      ->select('name')
      ->whereIn('id', $widgetIds)
      ->fetchArray();
      
    if (!sizeof($widgets))
    {
      return array();
    }
    
    $widgetNames = GlobalFunctions::getFormattedArray($widgets, 'name');
      
    return $widgetNames;  
  }
}
