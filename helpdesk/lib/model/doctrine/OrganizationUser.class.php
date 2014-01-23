<?php

/**
 * OrganizationUser
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    helpdesk
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class OrganizationUser extends BaseOrganizationUser
{
  static public function hasAccess($organizationId)
  {
    $userId = GlobalFunctions::getUserId();

    $user = sfContext::getInstance()->getUser();

    if (!$user->hasCredential('crmadmin'))
    {
      $query = Doctrine::getTable('OrganizationUser')
        ->createQuery('ou')
        ->where('ou.organization_id = ? ', $organizationId)
        ->addWhere('ou.user_id = ?', $userId)
        ->fetchOne();
      if ($query)
      {
        return true;
      }
    }
    else
    {
      return true;
    }


    return false;
  }
}
