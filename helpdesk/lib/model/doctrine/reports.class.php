<?php
    
    
class reports 
{
   static function getResultsGeneral($paramets_holder = array())
   {
      $claimtypes = $paramets_holder['claimtype'];
      //$claimfinance = $paramets_holder['claimfinance']; для диспетчера
      $claim_datetype = $paramets_holder['claim_datetype'];
      $from_date = $paramets_holder['date_range']['from']['year'].'-'.$paramets_holder['date_range']['from']['month'].'-'.$paramets_holder['date_range']['from']['day'].' 0:0:0'; 
      $to_date = $paramets_holder['date_range']['to']['year'].'-'.$paramets_holder['date_range']['to']['month'].'-'.$paramets_holder['date_range']['to']['day'].' 23:59:59'; 
      
                  
            
       $q = Doctrine_Query::create()
       ->select('c.id')
       ->addSelect('c.createdatetime')
       ->addSelect('c.closedatetime')
       ->addSelect('c.bill_date')
       ->addSelect('c.description')
       ->addSelect('c.mpk as mpk')
       ->addSelect('ct.name as claimtype')
       ->addSelect('d.address as departments_address')
       ->addSelect('cit.name as city_name')
       ->addSelect('org.name as organization_name')
       ->addSelect('i.name as importance_name')
       ->addSelect('i.color as importance_color')
       ->addSelect('st.name as status')
       ->addSelect('reg.name as region')
       
       ->addSelect('
         array_to_string(
          ARRAY (SELECT 
                     COALESCE(CONCAT(CONCAT(fcc.work, \'-pr;pr-\' ), COALESCE(fcc.income_nds, 0)), \'\') 
                  FROM
                    finance_claim fcc
                  WHERE
                     fcc.claim_id = c.id 
                  ),
          \'-*;*-\'
          ) AS worklist')
       ->addSelect('SUM(DISTINCT fc.income_nds) as total_income')
       ->addSelect('SUM(DISTINCT fc.costs_nds) as total_costs')
       ->addSelect('SUM(DISTINCT fc.income_nonnds) as total_incomenonnds')
       ->addSelect('SUM(DISTINCT fc.costs_nonnds) as total_costsnonnds')
       ->addSelect('SUM(DISTINCT fc.costs_beznalnonnds) as total_costsbeznalnonnds')
       ->addSelect('SUM(DISTINCT fc_cost.value) as total_costs_nal')
       ->addSelect('c.smeta_number')
       ->addSelect('c.bill_number')
       ->addSelect('
       array_to_string(
       ARRAY (SELECT
           CONCAT(CONCAT(CONCAT(docs1.name, \'-:::-\' ), docs1.filepath), CONCAT(\'-:d:-\', docs1.datetime))  
       from 
          Documents docs1,
          docs1.DocumentsClaim docs_claim, 
          docs1.Documentstype docs_type
       WHERE
          docs_claim.claim_id = c.id AND
          docs_type.dockey = \'akt_income\'
       ),
       \'-*;*-\'
       ) AS document_name')
       
       //->addSelect('i.color as importance_color')
       //->addSelect('st.name as status')
       
       ->from('Claim c')
       ->leftJoin('c.Claimtype ct')
       /*->leftJoin('c.DocumentsClaim dc')
       ->leftJoin('dc.Documents docs')*/
       ->leftJoin('c.FinanceClaim fc')
       ->leftJoin('fc.FcCostsn fc_cost')
       ->leftJoin('c.Departments d')
       ->leftJoin('d.City cit')
       ->leftJoin('cit.Region reg')
       ->leftJoin('d.Organization org')
       ->leftJoin('c.OrganizationImportance ci')
       ->leftJoin('ci.Importance i')
       ->leftJoin('c.Status st')
       ->groupBy('c.id, c.createdatetime, c.closedatetime, c.mpk, reg.name, ct.name, cit.name, org.name, d.address, st.name, i.name, i.color, c.description, c.smeta_number, c.bill_number, c.bill_date')
       ;
       switch ($claim_datetype){
                case 'open':
                  $datetype = 'createdatetime';
                break;
                case 'close':
                  $datetype = 'closedatetime';
                break;
                case 'bill_date':
                  $datetype = 'bill_date';
                break;
                
            }
       $q->addWhere("c.$datetype > '$from_date'"); 
       $q->andWhere("c.$datetype <'$to_date'");
       switch ($claimtypes){
                case 'all':
                break;
                case 'open':
                  $q->andWhere('c.isclosedclient is false');
                break;
                case 'close':
                  $q->andWhere('c.isclosedclient is true');
                break;
                
            }
       //->where()
       //->addWhere()
       //->fetchArray();     
            
       return $q;
   }
    
   static public function getResultsForDispatcher($paramets_holder = array())
   {
            $q = reports::getResultsGeneral($paramets_holder);
            $claimfinance = $paramets_holder['claimfinance'];
            switch ($claimfinance){
                case 'all':
                break;
                case 'open':
                  $q->andWhere('c.isclosedstuff is false');
                break;
                case 'close':
                  $q->andWhere('c.isclosedstuff is true');
                break;
                
            }
            $organization_id = $paramets_holder['organization']; 
            if ($organization_id)
            {
                $q->addWhere('org.id =?',$organization_id);
            }
            //$q->addWhere('c.id =?','2008');
            //return $q->execute();
            return $q->fetchArray();
   }
   
   static public function getResultsForSupervisor($paramets_holder = array())
   {
     return self::getResultsForDispatcher($paramets_holder);
   }
   
   
   
   static public function getResultsForClient($paramets_holder = array())
   {
            $q = reports::getResultsGeneral($paramets_holder);
            $organization = organization::getOrganizationByClient();
            $organization_id = $organization->getId(); 
            if ($organization_id)
            {
                $q->addWhere('o.id ='.$organization_id);
            }
            return $q->execute();
   }

  static public function getResultsForKurator($paramets_holder = array())
  {
    $q = reports::getResultsGeneral($paramets_holder);

    $userId = GlobalFunctions::getUserId();

    $q
      ->leftJoin('c.ClaimUsers clus')
      ->andWhere('clus.userkey = ?',sfConfig::get('claimuserkey_kurator'))
      ->andWhere('clus.user_id = ?',$userId);

    $claimfinance = $paramets_holder['claimfinance'];
    switch ($claimfinance){
      case 'all':
        break;
      case 'open':
        $q->andWhere('c.isclosedstuff is false');
        break;
      case 'close':
        $q->andWhere('c.isclosedstuff is true');
        break;

    }
    $organization_id = $paramets_holder['organization'];
    if ($organization_id)
    {
      $q->addWhere('org.id =?',$organization_id);
    }
    //$q->addWhere('c.id =?','2008');
    //return $q->execute();
    return $q->fetchArray();
  }

   static function getResultsGeneralFinance($paramets_holder = array())
   {
      $claimtypes = $paramets_holder['claimtype'];
      //$claimfinance = $paramets_holder['claimfinance']; для диспетчера
      $claim_datetype = $paramets_holder['claim_datetype'];
      $from_date = $paramets_holder['date_range']['from']['year'].'-'.$paramets_holder['date_range']['from']['month'].'-'.$paramets_holder['date_range']['from']['day'].' 0:0:0'; 
      $to_date = $paramets_holder['date_range']['to']['year'].'-'.$paramets_holder['date_range']['to']['month'].'-'.$paramets_holder['date_range']['to']['day'].' 23:59:59'; 
      
                  
            
       $q = Doctrine_Query::create()
       ->select('fc.id, fc.mpk, fc.claim_id')
       ->addSelect('d.address as departments_address')    
       ->addSelect('cit.name as city')
       ->addSelect('reg.name as region')
       ->addSelect('comp_str.name as company_structure')
       ->addSelect('sta.name as claim_status')
       ->addSelect('c.smeta_number as smeta_number')
       ->addSelect('fc.costs_nonnds as costs_nonnds')
       ->addSelect('fc.income_nonnds as income_nonnds')
       ->addSelect('fc.profitability as profitability')
       ->addSelect('fc.income_nds as income_nds')
       ->addSelect('c.bill_number as bill_number')
       ->addSelect('c.akt_date as akt_date')
       ->addSelect('c.createdatetime as claim_createdate') 
       ->addSelect('SUM(cstn.value) as costs_n')
       ->addSelect('fc.work as work') 
       ->addSelect('
        (CASE WHEN sta.stakey = \'sta_sclose_smclose_cclose\' 
              THEN (SELECT 
                        lc1.createdatetime
                    FROM 
                        log_claim lc1
                    WHERE
                        lc1.claim_id = c.id AND
                        lc1.log_claim_type = \'status\'
                    ORDER BY lc1.id DESC
                    LIMIT 1
                   ) 
              ELSE NULL
        END) as status_last_date')
       ->addSelect('
       array_to_string(
       ARRAY (SELECT
          CONCAT(CONCAT(docs1.name, \'-:::-\' ), docs1.filepath)  
       from 
          Documents docs1,
          docs1.DocumentsClaim docs_claim, 
          docs1.Documentstype docs_type
       WHERE
          docs_claim.claim_id = c.id AND
          (docs_type.dockey = \'akt_income\' OR
           docs_type.dockey = \'nakl_income\' )
       ),
       \'-*;*-\'
       ) AS document_name')
       ->addSelect('
      array_to_string(
        ARRAY   (
                SELECT 
                   CONCAT(CONCAT(u1.last_name, \' \'), u1.first_name) 
                FROM sfGuardUser u1,
                   u1.ClaimUsers cu1
                WHERE
                   cu1.claim_id = c.id AND
                   cu1.userkey = \''.sfConfig::get('claimuserkey_client').'\'
                ),
        \', \'
        ) AS client') 
       ->from('finance_claim fc')
       ->leftJoin('fc.claim c')
       ->leftJoin('fc.FcCostsn cstn')
       ->leftJoin('c.Status sta')
       ->leftJoin('c.Departments d')
       ->leftJoin('d.City cit')
       ->leftJoin('cit.Region reg')
       ->leftJoin('reg.Companystructure comp_str')
       ;
       
       $q->groupBy('fc.id, fc.mpk, fc.claim_id, d.address, cit.name, reg.name, comp_str.name, sta.name, c.smeta_number, fc.costs_nonnds, sta.stakey, c.id, fc.income_nonnds, fc.profitability, fc.income_nds, c.bill_number, c.akt_date, fc.work, c.createdatetime');
        
       switch ($claim_datetype){
                case 'open':
                  $datetype = 'createdatetime';
                break;
                case 'close':
                  $datetype = 'closedatetime';
                break;
                
            }
       $q->addWhere("c.$datetype > '$from_date'"); 
       $q->andWhere("c.$datetype <'$to_date'");
       switch ($claimtypes){
                case 'all':
                break;
                case 'open':
                  $q->andWhere('c.isclosedclient is false');
                break;
                case 'close':
                  $q->andWhere('c.isclosedclient is true');
                break;
                
            }             
       //->where()
       //->addWhere()
       //->fetchArray();     
       return $q;     
       
   }
   
   
   static public function getResultsForFinance($paramets_holder = array())
   {
         $q = reports::getResultsGeneralFinance($paramets_holder);
            $claimfinance = $paramets_holder['claimfinance'];
            switch ($claimfinance){
                case 'all':
                break;
                case 'open':
                  $q->andWhere('fc.is_closed is false');
                break;
                case 'close':
                  $q->andWhere('fc.is_closed is true');
                break;
                
            }
            /*$organization_id = $paramets_holder['organization']; 
            if ($organization_id)
            {
                $q->addWhere('org.id =?',$organization_id);
            }   */
            //$q->addWhere('c.id =?','2008');
            //return $q->execute();
            return $q->fetchArray();
   }
   

   static public function getFiltersResultsForDispatcher($paramets_holder = array())
   {
      $claimtypes = $paramets_holder['claimtype'];
      //$claimfinance = $paramets_holder['claimfinance']; для диспетчера
      $claim_datetype = $paramets_holder['claim_datetype'];
      $from_date = $paramets_holder['date_range']['from']['year'].'-'.$paramets_holder['date_range']['from']['month'].'-'.$paramets_holder['date_range']['from']['day'].' 0:0:0'; 
      $to_date = $paramets_holder['date_range']['to']['year'].'-'.$paramets_holder['date_range']['to']['month'].'-'.$paramets_holder['date_range']['to']['day'].' 23:59:59'; 
      
      $where = '';
      
      switch ($claim_datetype){
          case 'open':
             $datetype = 'createdatetime';
          break;
          case 'close':
              $datetype = 'closedatetime';
          break;
       }
       
       $where .= "c.$datetype > '$from_date'";
       $where .= " AND c.$datetype <'$to_date'";
       
       switch ($claimtypes){
                case 'all':
                break;
                case 'open':
                  $where .= "AND c.isclosedclient is false";
                  //$q->andWhere('c.isclosedclient is false');
                break;
                case 'close':
                  $where .= "AND c.isclosedclient is true";
                  //$q->andWhere('c.isclosedclient is true');
                break;
                
       };
       
       $q = Doctrine_Query::create()
       ->select('cl.id')
       ->addSelect("
       array_to_string(
       ARRAY (SELECT
          distinct(ct.name)
       from 
          claim c,    
          c.Claimtype ct
          
       where 
         ct.id = c.claimtype_id 
         AND
         $where
       ),
       '-*;*-'
       ) AS claimtype_key") 
       ->addSelect("
       array_to_string(
       ARRAY (SELECT
          distinct(org.name)
       from 
          claim c_a11,    
          c_a11.Departments dep,
          dep.contract contr,
          contr.organization org
          
       where 
          ".str_replace('c.','c_a11.', $where)."
         
       ),
       '-*;*-'
       ) AS organization_key")
       ->addSelect("
       array_to_string(
       ARRAY (SELECT
          distinct(reg_a12.name)
       from 
          claim c_a12,    
          c_a12.Departments dep_a12,
          dep_a12.City cit_a12,
          cit_a12.Region reg_a12
       where 
          ".str_replace('c.','c_a12.', $where)."
         
       ),
       '-*;*-'
       ) AS region_key")
       ->addSelect("
       array_to_string(
       ARRAY (SELECT
          distinct(cit_a13.name)
       from 
          claim c_a13,    
          c_a13.Departments dep_a13,
          dep_a13.City cit_a13
          
       where 
          ".str_replace('c.','c_a13.', $where)."
       ),
       '-*;*-'
       ) AS city_key")
       ->addSelect("
       array_to_string(
       ARRAY (SELECT
          distinct(dep_a14.address)
       from 
          claim c_a14,    
          c_a14.Departments dep_a14
       where 
          ".str_replace('c.','c_a14.', $where)."
       ),
       '-*;*-'
       ) AS departments_key")
       ->addSelect("
       array_to_string(
       ARRAY (SELECT
          distinct(imp_a15.name)
       from 
          claim c_a15,    
          c_a15.ContractImportance contr_imp_a15,
          contr_imp_a15.importance imp_a15
       where 
          ".str_replace('c.','c_a15.', $where)."
       ),
       '-*;*-'
       ) AS importance_key")
       ->addSelect("
       array_to_string(
       ARRAY (SELECT
          distinct(stat_a16.name)
       from 
          claim c_a16,    
          c_a16.Status stat_a16
       where 
          ".str_replace('c.','c_a16.', $where)."
       ),
       '-*;*-'
       ) AS status_key")
       ;   
       $q->from('claim cl');
       $q->limit(1);
       
       return $q->fetchArray();
   }
   
   static public function getFiltersResultsForFinance($paramets_holder = array())
   {
       $claimtypes = $paramets_holder['claimtype'];
      //$claimfinance = $paramets_holder['claimfinance']; для диспетчера
      $claim_datetype = $paramets_holder['claim_datetype'];
      $from_date = $paramets_holder['date_range']['from']['year'].'-'.$paramets_holder['date_range']['from']['month'].'-'.$paramets_holder['date_range']['from']['day'].' 0:0:0'; 
      $to_date = $paramets_holder['date_range']['to']['year'].'-'.$paramets_holder['date_range']['to']['month'].'-'.$paramets_holder['date_range']['to']['day'].' 23:59:59'; 
      
      $where = '';
      
      switch ($claim_datetype){
          case 'open':
             $datetype = 'createdatetime';
          break;
          case 'close':
              $datetype = 'closedatetime';
          break;
       }
       
       $where .= "c.$datetype > '$from_date'";
       $where .= " AND c.$datetype <'$to_date'";
       
       switch ($claimtypes){
                case 'all':
                break;
                case 'open':
                  $where .= "AND c.isclosedclient is false";
                  //$q->andWhere('c.isclosedclient is false');
                break;
                case 'close':
                  $where .= "AND c.isclosedclient is true";
                  //$q->andWhere('c.isclosedclient is true');
                break;
                
       };
       
       $q = Doctrine_Query::create()
       ->select('c.id')
        ->addSelect("
       array_to_string(
       ARRAY (
       SELECT
          distinct(cit_a11.name)
       from 
          claim c_a11,    
          c_a11.Departments dep_a11,
          dep_a11.City cit_a11
          
       where 
          ".str_replace('c.','c_a11.', $where)."
       ),
       '-*;*-'
       ) AS city_key")
       ->addSelect("
       array_to_string(
       ARRAY (SELECT
          distinct(reg_a12.name)
       from 
          claim c_a12,    
          c_a12.Departments dep_a12,
          dep_a12.City cit_a12,
          cit_a12.Region reg_a12
       where 
          ".str_replace('c.','c_a12.', $where)."
         
       ),
       '-*;*-'
       ) AS region_key")
       ->addSelect("
       array_to_string(
       ARRAY (SELECT
          distinct(comp_struct.name)
       from 
          claim c_a13,    
          c_a13.Departments dep_a13,
          dep_a13.City cit_a13,
          cit_a13.Region reg_a13,
          reg_a13.Companystructure comp_struct
       where 
          ".str_replace('c.','c_a13.', $where)."
         
       ),
       '-*;*-'
       ) AS company_key")
       ->addSelect("
       array_to_string(
       ARRAY (SELECT
          distinct(stat_a14.name)
       from 
          claim c_a14,    
          c_a14.Status stat_a14
       where 
          ".str_replace('c.','c_a14.', $where)."
       ),
       '-*;*-'
       ) AS status_key")
       ;  
       $q->from('claim c');
       $q->limit(1);
       
       return $q->fetchArray();
   }
   
}
