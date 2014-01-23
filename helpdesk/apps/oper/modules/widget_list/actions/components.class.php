<?php

/**
 * widget_list actions.
 *
 * @package    helpdesk
 * @subpackage widget_list
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class widget_listComponents extends sfComponents
{
  public function executeUnread_claims()
  {
    $user_id = sfContext::getInstance()->getUser()->getId();
    
    $claims_messages = claimTable::getUnreadClaims();
    
    if (!sizeof($claims_messages))
    {
      return sfView::NONE;
    }
    
    $formatted_data = array();
    $userIds = array();
    
    foreach($claims_messages as $value)
    {
      $message = explode('--||--', $value['message']);
      
      if (!isset($userIds[$message[0]]))
      {
        $userIds[$message[0]] = $message[0];
      }
      
      $formatted_data[] = array(
        'claim_id' => $value['id'],
        'user_id'  => $message[0],
        'createdatetime' => $message[1] 
      );
    }     
    
    $users = sfGuardUserTable::getInstance()
      ->createQuery()
      ->whereIn('id', $userIds)
      ->execute();
    
    $users_arr = array();
    
    foreach($users as $user)
    {
      $users_arr[$user->getId()] = $user;
    } 
    
    $this->messages = $formatted_data;
    
    $this->users = $users_arr; 
  }
  
  
  public function executeNot_closed_finnance_claims()
  {
    return sfView::NONE;
  }
  
  public function executeGlobal_messages()
  {
    $this->global_messages = GlobalMessageTable::getAllMessages();
    
    /*if (!sizeof($this->global_messages))
    {
      return sfView::NONE;
    }*/
  }
}