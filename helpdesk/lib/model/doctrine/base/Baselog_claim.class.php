<?php

/**
 * Baselog_claim
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $claim_id
 * @property string $description
 * @property timestamp $createdatetime
 * @property integer $user_id
 * @property string $log_claim_type
 * @property integer $finance_claim_id
 * @property claim $claim
 * @property sfGuardUser $Users
 * @property finance_claim $FinanceClaim
 * 
 * @method integer       getId()               Returns the current record's "id" value
 * @method integer       getClaimId()          Returns the current record's "claim_id" value
 * @method string        getDescription()      Returns the current record's "description" value
 * @method timestamp     getCreatedatetime()   Returns the current record's "createdatetime" value
 * @method integer       getUserId()           Returns the current record's "user_id" value
 * @method string        getLogClaimType()     Returns the current record's "log_claim_type" value
 * @method integer       getFinanceClaimId()   Returns the current record's "finance_claim_id" value
 * @method claim         getClaim()            Returns the current record's "claim" value
 * @method sfGuardUser   getUsers()            Returns the current record's "Users" value
 * @method finance_claim getFinanceClaim()     Returns the current record's "FinanceClaim" value
 * @method log_claim     setId()               Sets the current record's "id" value
 * @method log_claim     setClaimId()          Sets the current record's "claim_id" value
 * @method log_claim     setDescription()      Sets the current record's "description" value
 * @method log_claim     setCreatedatetime()   Sets the current record's "createdatetime" value
 * @method log_claim     setUserId()           Sets the current record's "user_id" value
 * @method log_claim     setLogClaimType()     Sets the current record's "log_claim_type" value
 * @method log_claim     setFinanceClaimId()   Sets the current record's "finance_claim_id" value
 * @method log_claim     setClaim()            Sets the current record's "claim" value
 * @method log_claim     setUsers()            Sets the current record's "Users" value
 * @method log_claim     setFinanceClaim()     Sets the current record's "FinanceClaim" value
 * 
 * @package    helpdesk
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Baselog_claim extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('log_claim');
        $this->hasColumn('id', 'integer', null, array(
             'primary' => true,
             'type' => 'integer',
             'autoincrement' => true,
             ));
        $this->hasColumn('claim_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('description', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('createdatetime', 'timestamp', null, array(
             'type' => 'timestamp',
             'notnull' => true,
             ));
        $this->hasColumn('user_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('log_claim_type', 'string', 50, array(
             'type' => 'string',
             'length' => 50,
             ));
        $this->hasColumn('finance_claim_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => false,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('claim', array(
             'local' => 'claim_id',
             'foreign' => 'id'));

        $this->hasOne('sfGuardUser as Users', array(
             'local' => 'user_id',
             'foreign' => 'id'));

        $this->hasOne('finance_claim as FinanceClaim', array(
             'local' => 'finance_claim_id',
             'foreign' => 'id'));
    }
}