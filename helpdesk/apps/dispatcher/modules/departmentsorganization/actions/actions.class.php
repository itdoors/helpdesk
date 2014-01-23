<?php

require_once dirname(__FILE__).'/../lib/departmentsorganizationGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/departmentsorganizationGeneratorHelper.class.php';

/**
 * departmentsorganization actions.
 *
 * @package    helpdesk
 * @subpackage departmentsorganization
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class departmentsorganizationActions extends autoDepartmentsorganizationActions
{
  protected function getPager()
  {
    $pager = $this->configuration->getPager('departments');
    $pager->setQuery($this->buildQuery());
    $pager->setPage($this->getPage());
    $pager->init();

    return $pager;
  }
  
  /*protected function buildQuery()
  {
    $tableMethod = $this->configuration->getTableMethod();
    if (null === $this->filters)
    {
      $this->filters = $this->configuration->getFilterForm($this->getFilters());
    }

    $this->filters->setTableMethod($tableMethod);

    $query = $this->filters->buildQuery($this->getFilters());
    $d = $query->getRootAlias();
    $query->select("
        $d.id, 
        $d.mpk, 
        $d.address, 
        contr_table.name, 
        org_table.name,
        cit_table.name, 
        reg_table.name, 
        client_table.*, 
        userclient_table.first_name, 
        userclient_table.last_name, 
        sd_table.userkey, 
        stuff_table.*, 
        userstuff_table.first_name, 
        userstuff_table.last_name,
        claimtype_table.name
    ");      
    $query->leftJoin("$d.contract contr_table");
    $query->leftJoin("$d.City cit_table");
    $query->leftJoin('cit_table.Region reg_table');
    $query->leftJoin('contr_table.organization org_table');
    $query->leftJoin("$d.Client client_table");
    $query->leftJoin('client_table.Users userclient_table');
    $query->leftJoin("$d.StuffDepartments sd_table");
    $query->leftJoin('sd_table.Claimtype claimtype_table');
    $query->leftJoin('sd_table.Stuff stuff_table');
    $query->leftJoin('stuff_table.Users userstuff_table'); 

    $this->addSortQuery($query);
     
    $event = $this->dispatcher->filter(new sfEvent($this, 'admin.build_query'), $query);
    
    $query = $event->getReturnValue();

    return $query;
  }                     */
}
