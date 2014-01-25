<?php

/**
 * departmentsTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class departmentsTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object departmentsTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('departments');
    }
    
    //getAllDepartments
    public function getAllDepartmentsClient($cityid = null)
  {
      
      $sf_user = sfContext::getInstance()->getUser();
      $userid = $sf_user->getAttribute('user_id', 'null', 'sfGuardSecurityUser');
      $dep_user_id = Doctrine::getTable('client')
      ->createQuery('ff')
      ->where('ff.user_id = '.$userid)
      ->fetchOne();
      //die($dep_user_id->id);
      if ($dep_user_id<>null)
      {
          //$departments = Doctrine::getTable('departments')
          $q = Doctrine::getTable('departments')
          ->createQuery('d')
          ->innerJoin('d.client_departments cd')
          ->leftJoin('d.City cit')
          ->where('d.id = cd.departments_id')
          ->addWhere('cd.client_id = '.$dep_user_id->id);
          if ($cityid) $q->addWhere('d.city_id = '.$cityid);
          //->orderBy('d.name ASC')
          $q->orderBy('d.name ASC');
          $departments = $q->execute(); 
           return $departments;    
      } else return null;  
  } 
  
  
  public function getDepartmentsQuery($refValue)
  {
      return $this->createQuery('d')
      ->select('d.name, d.address, cit.name')
      //->leftJoin('d.contract c')
      ->leftJoin('d.City cit')
      ->leftJoin('d.Organization o')
      ->where('d.organization_id = ?', $refValue)
      ->orderBy('cit.name ASC, d.name ASC');
  }
      
  
  public function getDepartmentsByOrganizationQuery($org_id , $cityid = null, $ignore_superkurator = false) 
  {
    $query = Doctrine::getTable('departments')
      ->createQuery('d')
      //->leftJoin('d.contract c')
      ->leftJoin('d.Organization o')
      ->leftJoin('d.City cit')
      //->where('d.contract_id =  c.id')
      ->addWhere('d.organization_id = ?', $org_id)
      ->orderBy('cit.name ASC, d.name ASC');
      
    return $query;
  }
  
  public function getDepartmentsByOrganization($org_id , $cityid = null, $ignore_superkurator = false)
  {
    $is_superkurator =  sfContext::getInstance()->getUser()->hasCredential('superkurator');
    if (sfContext::getInstance()->getUser()->hasCredential('superkurator'))
    {
        if (sfContext::getInstance()->getUser()->isSuperAdmin()||sfContext::getInstance()->getUser()->hasCredential('dispatcher'))
        $is_superkurator = false;
    }  
     
    $user_id = sfContext::getInstance()->getUser()->getAttribute('user_id' , null, 'sfGuardSecurityUser');
    if (!$org_id) $org_id=0;
    $q = Doctrine::getTable('departments')
    ->createQuery('d')
    ->select('d.name, d.address, c.name')
    //->leftJoin('d.contract c')
    ->leftJoin('d.stuff_departments sd')
    //->leftJoin('c.organization o')
    ->leftJoin('d.City cit')
    /*->where('d.contract_id =  c.id')
    ->addWhere('c.organization_id = '.$org_id)*/
    ->addWhere('d.organization_id = ?',$org_id);
    
    if ($is_superkurator && !$ignore_superkurator)
    {
      $q->leftJoin('sd.Stuff s')
        ->andWhere('s.user_id = '.$user_id)    
        ->andWhere('sd.userkey = \''.sfConfig::get('claimuserkey_kurator').'\'');  
    }
    
    if ($cityid<>null) 
    {
      $q->addWhere('d.city_id = ?', $cityid);
    }
    
    $q->orderBy('cit.name ASC, d.name ASC');
    
    return $q->execute();
  }
  
  static public function getDepartmentsByOrganizationArray($org_id , $cityid = null, $search_field_value = null, $ignore_superkurator = false)
  {
    $is_superkurator =  sfContext::getInstance()->getUser()->hasCredential('superkurator');
    if (sfContext::getInstance()->getUser()->hasCredential('superkurator'))
    {
        if (sfContext::getInstance()->getUser()->isSuperAdmin()||sfContext::getInstance()->getUser()->hasCredential('dispatcher'))
        $is_superkurator = false;
    }  
     
    $user_id = sfContext::getInstance()->getUser()->getAttribute('user_id' , null, 'sfGuardSecurityUser');
    if (!$org_id) $org_id=0;
    $q = Doctrine::getTable('departments')
    ->createQuery('d')
    ->select('d.name, d.address, c.name')
    ->leftJoin('d.contract c')
    ->leftJoin('d.stuff_departments sd')
    ->leftJoin('sd.Stuff s')
    ->leftJoin('c.organization o')
    ->leftJoin('d.City cit')
    ->where('d.contract_id =  c.id')
    ->addWhere('c.organization_id = '.$org_id)  ;
    
    if ($is_superkurator && !$ignore_superkurator)
    {
      $q->andWhere('s.user_id = '.$user_id)    
        ->andWhere('sd.userkey = \''.sfConfig::get('claimuserkey_kurator').'\'');  
    }
    
    if ($cityid<>null) $q->addWhere('d.city_id = '.$cityid)  ;
    $q->orderBy('cit.name ASC, d.name ASC');
    
    if ($search_field_value)
    {
      $q->addWhere('LOWER(d.address) LIKE ?', '%'.$search_field_value."%");
    }
    
    $q = $q->fetchArray();
      
    $result = array();
    foreach ($q as $dep)
    {
      $result[$dep['id']] = $dep['address'];
    }
    
    return $result;
  } 
  
  public function getAllSortDepartments()
  {
    $q = Doctrine::getTable('departments')
    ->createQuery('d')
    ->leftJoin('d.contract c')
    ->leftJoin('c.organization o')
    ->leftJoin('d.City cit')
    ->where('d.contract_id =  c.id');
    //die($q);
    //$q->orderBy('d.name ASC ');
    $q->orderBy('cit.name ASC');
    return $q->execute();
      
  } 
  
  
  
  
  public function getNullDepartments()
  {
      return null;
  }
   public function NoInfo()
   {
       /*$org_id = sfContext::getInstance()->getUser()->getAttribute('organization_id');
       if ($org_id) return $this->getDepartmentsByOrganization($org_id); */
       return Null;
   }
   
  static public function getMyDepartmentsQuery($userId = null)
  {
    $departments_query = departmentsTable::getInstance()
      ->createQuery('d')
      ->select('DISTINCT (d.id)')
      ->select('d.*')
      ->addSelect('city.*')
      ->addSelect('organization.*')
      ->addSelect('region.*')
      ->addSelect('Status.*')
      ->addSelect('DepartmentsType.*');

    $isSupervisor = false;

    if (!$userId)
    {
      $user = sfContext::getInstance()->getUser();
      $userId = $user->getId();
      $isSupervisor = $user->hasCredential('supervisor');
    }

    if (!$isSupervisor)
    {
      $stuff = stuffTable::getInstance()
        ->createQuery()
        ->where('user_id = ?', $userId)
        ->fetchOne();

      if (!$stuff)
      {
        return $departments_query
          ->where('d.id = ?', 0);
      }

      $stuff_id = $stuff->getId();

      /*$departmentsIds = stuff_departmentsTable::getInstance()
      ->createQuery()
      ->select('DISTINCT(departments_id) as departments_id')
      ->where('stuff_id = ?', $stuff_id)
      ->fetchArray();

      $departmentsIds = GlobalFunctions::getFormattedArray($departmentsIds, 'departments_id');

      $departments_query
      ->whereIn('d.id', $departmentsIds);*/

      $departments_query
      //->addWhere('d.id = 2254');
      ->leftJoin('d.stuff_departments as sd')
      ->addWhere('sd.stuff_id = ?', $stuff_id);
    }

    $departments_query
      ->leftJoin('d.Organization as organization')
      ->leftJoin('d.City as city')
      ->leftJoin('city.Region as region')
      ->leftJoin('d.Status as Status')
      ->leftJoin('d.DepartmentsType as DepartmentsType')
      ->orderBy('city.name');

    return $departments_query;
  }

  static public function getStuffDepartmentIdsByStuffId($stuffId = null)
  {
    /** @var Doctrine_Query $departmentsQuery*/
    $departmentsQuery = departmentsTable::getInstance()
      ->createQuery('d');

    $departmentsQuery
      ->leftJoin('d.stuff_departments as sd')
      ->addWhere('sd.stuff_id = ?', $stuffId);

    /** @var Doctrine_Collection $departments*/
    $departments = $departmentsQuery->execute();

    return sizeof($departments) ? $departments->getPrimaryKeys() : array();
  }

  static public function getStuffDepartmentIdsByUserId($userId = null)
  {
    /** @var Doctrine_Query $departmentsQuery*/
    $departmentsQuery = departmentsTable::getInstance()
      ->createQuery('d');

    $stuff = stuffTable::getInstance()
        ->createQuery()
        ->where('user_id = ?', $userId)
        ->fetchOne();

    if (!$stuff)
    {
      return array();
    }

    $stuffId = $stuff->getId();

    $departmentsQuery
      ->leftJoin('d.stuff_departments as sd')
      ->addWhere('sd.stuff_id = ?', $stuffId);

    /** @var Doctrine_Collection $departments*/
    $departments = $departmentsQuery->execute();

    return sizeof($departments) ? $departments->getPrimaryKeys() : array();
  }
}