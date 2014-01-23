<?php

/**
 * maruk_to_klen actions.
 *
 * @package    helpdesk
 * @subpackage maruk_to_klen
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class maruk_to_klenActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    //$this->forward('default', 'module');
    // stuff_id 
    $id = 29;
    $new_id = 114;
    $stuff_departments = Doctrine::getTable('stuff_departments')
    ->createQuery('sd')
    ->where('sd.stuff_id = '.$id)
    ->execute();
    $i = 0;
    foreach($stuff_departments as $user)
    {
        
        if ($user->getStuffId() == $id) 
        {
           
           $isex = Doctrine::getTable('stuff_departments')
           ->createQuery('sd')
           ->where('sd.stuff_id = '.$new_id)
           ->andWhere('sd.userkey = \''.$user->getUserkey().'\'')
           ->andWhere('sd.departments_id = '.$user->getDepartmentsId().'')
           ->andWhere('sd.claimtype_id = '.$user->getClaimtypeId().'')
           ->execute();
           if (!count($isex))
           {
             $user->setStuffId($new_id);
             $user->save();
             $i++;  
           }
           
              
        }
        
    }
    return $this->renderText($i);
  }
  
   public function executeIndexclaimusers(sfWebRequest $request)
  {
    //$this->forward('default', 'module');
    //  юзеры в заявках
    //userid
    $id = 36;
    $new_id = 204;
    $claimusers = Doctrine::getTable('claimusers')
    ->createQuery('cu')
    ->where('cu.user_id = '.$id)
    ->execute();
    $i = 0;
    foreach($claimusers as $user)
    {
        
        if ($user->getUserId() == $id) 
        {
           $i++;
           $user->setUserId($new_id);
           $user->save();   
        }
        
    }
    return $this->renderText($i);
  }
}
