<?php

/**
 * departments
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    helpdesk
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class departments extends Basedepartments
{
    public function __toString()
    {
        return $this->getCity().' | '.$this->getName();
    }

  public function getAddressWithCity()
  {
    return $this->getCity().' | '.$this->getAddress();
  }

  public function getWithOrganization()
  {
    return $this->getOrganization() .' | '. $this->getCity().' | '.$this->getName();
  }
    
    public function getFullDepartment()
    {
       return $this->getCity().' | '.$this->getName().' | '.$this->getContract()->getOrganization(); 
    }
    /*public function getOrganization()
    {
      if ($this->_data['organization_id'])
      {
        $organization = organizationTable::getInstance()->find($this->_data['organization_id']);

        return $organization;
      }

      if ($this->getContract())
      {
        return $this->getContract()->getOrganization();
      }

      return null;
    }*/
    public function getRegion()
    {
      return $this->getCity() ? $this->getCity()->getRegion() : ''; 
    }
    
    public function getPersons()
    {
        $s = '<table>';
        //$stuffss = $this->getStuff();
        $stuff_departmentss = $this->getStuffDepartments();
        foreach ($stuff_departmentss as $stuff_departments)
        {
            $s .= '<tr>';
              $s .= "<td>".$stuff_departments->getStuff()->getUsers()."</td>";
              $s .= "<td>".$stuff_departments->getUserkey()."</td>";
              $s .= "<td>".$stuff_departments->getClaimtype()."</td>"; 
            $s .= '</tr>';
        }
        $s .= "</table>";
        return $s; 
    }
    
    public function getPersonsWithDel()
    {
        $s = '<table>';
        $stuffss = $this->getStuff();
        $stuff_departmentss = $this->getStuffDepartments();
        foreach ($stuff_departmentss as $stuff_departments)
        {
            $s .= '<tr class="depperson">';
            $s .= "<td>".$stuff_departments->getStuff()->getUsers()."</td><td>".$stuff_departments->getUserkey()."</td><td>".$stuff_departments->getClaimtype()."</td>"; 
            $s .= '
            <td>
               <form action="'.url_for('departments/deluser').'/departmentsstuff_id/'.$stuff_departments->getId().'">
                  <input type="submit" value="Удалить">
               </form>
            </td>';
            $s .= '</tr>';
        }
        $s .= "</table>";
        return $s; 
    }
    
    public function getClientList()
    {
        $s = '<table>';
        $clients = $this->getClient();
        foreach ($clients as $client)
        {
            $s .= '<tr>';
            $s .= "<td>".$client->getUsers()."</td>"; 
            $s .= '</tr>';
        }
        $s .= "</table>";
        return $s; 
    }
    
    public function isClient()
    {
        //$user_id = sfContext::getInstance()->getRequest()->getParameter('id');
        /*$user_id = 29;
        //if (!$user_id) return 0;
        //if (!$user_id)  $user_id = 106;
        /*$client = Doctrine::getTable('Client')
        ->createQuery('c')
        ->where('c.user_id ='.$user_id)
        ->execute()->getFirst();
        if (!count($client)) return 0; 
        $q = Doctrine::getTable('client_departments')
        ->createQuery('cd')
        //->where('cd.client_id = '.$client->getId())
        ->where('cd.client_id = '.$user_id)
        ->andWhere('cd.departments_id ='.$this->getId())
        ->execute();
        return count($q); */
        return 0;
    }
    
    /*public function getOrganizationId()
    {
      $request = sfContext::getInstance()->getRequest();
      $module = $request->getParameter('module');
      $action = $request->getParameter('action');
      
      if (($module == 'departmentsorganization' &&
          $action != 'index' ) || 
         ($module == 'ajaxdata' && $action == 'department_form') )
      {
         return $this->_data['organization_id'];
      }      
      
      return $this->getContract()->getOrganization()->getId();

    }*/
    
  public function objectFieldSaveToLogClaim($field = null, $toString  = null)
  {
    if (!$field||!$toString) return null;  
    
    if (!sizeof($this->_oldValues))
    {
      return;
    }
    $history = new History();
    
    $history->setModelName(History::MODEL_DEPARTMENTS);
    $history->setModelId($this->getId());
    $history->setFieldName($field);
    $history->setOldValue($this->_oldValues[$field]);
    $history->setValue($this->$toString());
    $history->save();
    
    //$history->set
  }

  public function getStatusString()
  {
    return $this->getStatus() . ' ';
  }

  public function getOpermanagerString()
  {
    return $this->getOpermanager() . ' ';
  }

  /**
   * Returns mpks collection)
   *
   * @return Doctrine_Collection|Mpk[]
   */
  public function getMpks()
  {
    return Doctrine::getTable('Mpk')
      ->createQuery('m')
      ->where('department_id = ?', $this->getId())
      ->execute();
  }

  /**
   * Returns mpks array()
   *
   * @return Doctrine_Collection|Mpk[]
   */
  public function getMpksArray()
  {
    return $this->getMpks()->toKeyValueArray('id', 'name');
  }

  /**
   * Returns mpks string with coma separator
   *
   * @return string
   */
  public function getMpksString()
  {
    return implode(', ', $this->getMpksArray());
  }
}