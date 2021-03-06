<?php

/**
 * cityTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class cityTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object cityTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('city');
    }
    
    public function getCityOrderName()
    {
        $departments = Doctrine::getTable('Departments')->getAllDepartmentsClient();
        if ($departments) $dep_ids = $departments->getPrimaryKeys();
        if (count($dep_ids))
        {
            return Doctrine::getTable('city')
            ->createQuery('c')
            ->leftJoin('c.Departments d')
            ->whereIn('d.id', $dep_ids)
            ->orderBy('c.name ASC')
            ->execute();
        } else return null;
       
    }
    
    
    public function getCityByOrganizationOrderName($orgid)
    {
        $departments = Doctrine::getTable('Departments')->getDepartmentsByOrganization($orgid);
        if ($departments) $dep_ids = $departments->getPrimaryKeys();
        if (count($dep_ids))
        {
            return Doctrine::getTable('city')
            ->createQuery('c')
            ->leftJoin('c.Departments d')
            ->whereIn('d.id', $dep_ids)
            ->orderBy('c.name ASC')
            ->execute();
        } else return null;
       
    }
    
    public function getCityQuery($refValue)
    {
        $departments = Doctrine::getTable('Departments')->getDepartmentsByOrganization($refValue);
        if ($departments) $dep_ids = $departments->getPrimaryKeys() ? $departments->getPrimaryKeys() : 0; 
        return $this->createQuery('c')
               ->select('c.name')
               ->leftJoin('c.Departments d')
               ->whereIn('d.id', $dep_ids)
               ->orderBy('c.name ASC');
    }
    
    
    
    public function NoInfo()
   {
       return Null;
   }
   
}
