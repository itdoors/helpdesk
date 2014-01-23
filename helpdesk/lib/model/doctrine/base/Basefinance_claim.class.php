<?php

/**
 * Basefinance_claim
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $claim_id
 * @property string $mpk
 * @property string $work
 * @property float $costs_n
 * @property float $costs_nds
 * @property float $costs_nonnds
 * @property float $costs_beznalnonnds
 * @property float $income_nds
 * @property float $income_nonnds
 * @property string $bill_number
 * @property float $profitability
 * @property integer $status_id
 * @property float $nds
 * @property float $obnal
 * @property boolean $is_closed
 * @property status $Status
 * @property claim $claim
 * @property Doctrine_Collection $FcCostsn
 * @property Doctrine_Collection $LogClaim
 * 
 * @method integer             getId()                 Returns the current record's "id" value
 * @method integer             getClaimId()            Returns the current record's "claim_id" value
 * @method string              getMpk()                Returns the current record's "mpk" value
 * @method string              getWork()               Returns the current record's "work" value
 * @method float               getCostsN()             Returns the current record's "costs_n" value
 * @method float               getCostsNds()           Returns the current record's "costs_nds" value
 * @method float               getCostsNonnds()        Returns the current record's "costs_nonnds" value
 * @method float               getCostsBeznalnonnds()  Returns the current record's "costs_beznalnonnds" value
 * @method float               getIncomeNds()          Returns the current record's "income_nds" value
 * @method float               getIncomeNonnds()       Returns the current record's "income_nonnds" value
 * @method string              getBillNumber()         Returns the current record's "bill_number" value
 * @method float               getProfitability()      Returns the current record's "profitability" value
 * @method integer             getStatusId()           Returns the current record's "status_id" value
 * @method float               getNds()                Returns the current record's "nds" value
 * @method float               getObnal()              Returns the current record's "obnal" value
 * @method boolean             getIsClosed()           Returns the current record's "is_closed" value
 * @method status              getStatus()             Returns the current record's "Status" value
 * @method claim               getClaim()              Returns the current record's "claim" value
 * @method Doctrine_Collection getFcCostsn()           Returns the current record's "FcCostsn" collection
 * @method Doctrine_Collection getLogClaim()           Returns the current record's "LogClaim" collection
 * @method finance_claim       setId()                 Sets the current record's "id" value
 * @method finance_claim       setClaimId()            Sets the current record's "claim_id" value
 * @method finance_claim       setMpk()                Sets the current record's "mpk" value
 * @method finance_claim       setWork()               Sets the current record's "work" value
 * @method finance_claim       setCostsN()             Sets the current record's "costs_n" value
 * @method finance_claim       setCostsNds()           Sets the current record's "costs_nds" value
 * @method finance_claim       setCostsNonnds()        Sets the current record's "costs_nonnds" value
 * @method finance_claim       setCostsBeznalnonnds()  Sets the current record's "costs_beznalnonnds" value
 * @method finance_claim       setIncomeNds()          Sets the current record's "income_nds" value
 * @method finance_claim       setIncomeNonnds()       Sets the current record's "income_nonnds" value
 * @method finance_claim       setBillNumber()         Sets the current record's "bill_number" value
 * @method finance_claim       setProfitability()      Sets the current record's "profitability" value
 * @method finance_claim       setStatusId()           Sets the current record's "status_id" value
 * @method finance_claim       setNds()                Sets the current record's "nds" value
 * @method finance_claim       setObnal()              Sets the current record's "obnal" value
 * @method finance_claim       setIsClosed()           Sets the current record's "is_closed" value
 * @method finance_claim       setStatus()             Sets the current record's "Status" value
 * @method finance_claim       setClaim()              Sets the current record's "claim" value
 * @method finance_claim       setFcCostsn()           Sets the current record's "FcCostsn" collection
 * @method finance_claim       setLogClaim()           Sets the current record's "LogClaim" collection
 * 
 * @package    helpdesk
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Basefinance_claim extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('finance_claim');
        $this->hasColumn('id', 'integer', null, array(
             'primary' => true,
             'type' => 'integer',
             'autoincrement' => true,
             ));
        $this->hasColumn('claim_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('mpk', 'string', 50, array(
             'type' => 'string',
             'length' => 50,
             ));
        $this->hasColumn('work', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('costs_n', 'float', null, array(
             'type' => 'float',
             ));
        $this->hasColumn('costs_nds', 'float', null, array(
             'type' => 'float',
             ));
        $this->hasColumn('costs_nonnds', 'float', null, array(
             'type' => 'float',
             ));
        $this->hasColumn('costs_beznalnonnds', 'float', null, array(
             'type' => 'float',
             ));
        $this->hasColumn('income_nds', 'float', null, array(
             'type' => 'float',
             ));
        $this->hasColumn('income_nonnds', 'float', null, array(
             'type' => 'float',
             ));
        $this->hasColumn('bill_number', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             ));
        $this->hasColumn('profitability', 'float', null, array(
             'type' => 'float',
             ));
        $this->hasColumn('status_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('nds', 'float', null, array(
             'type' => 'float',
             ));
        $this->hasColumn('obnal', 'float', null, array(
             'type' => 'float',
             ));
        $this->hasColumn('is_closed', 'boolean', null, array(
             'type' => 'boolean',
             'default' => false,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('status as Status', array(
             'local' => 'status_id',
             'foreign' => 'id'));

        $this->hasOne('claim', array(
             'local' => 'claim_id',
             'foreign' => 'id'));

        $this->hasMany('FcCostsn', array(
             'local' => 'id',
             'foreign' => 'finance_claim_id'));

        $this->hasMany('log_claim as LogClaim', array(
             'local' => 'id',
             'foreign' => 'finance_claim_id'));
    }
}