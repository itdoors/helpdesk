<?php

/**
 * Basecontract_importance
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $contract_id
 * @property integer $importance_id
 * @property integer $organization_id
 * @property integer $duration
 * @property contract $contract
 * @property importance $importance
 * @property organization $Organization
 * @property Doctrine_Collection $Groupclaim
 * @property Doctrine_Collection $Claim
 * 
 * @method integer             getId()              Returns the current record's "id" value
 * @method integer             getContractId()      Returns the current record's "contract_id" value
 * @method integer             getImportanceId()    Returns the current record's "importance_id" value
 * @method integer             getOrganizationId()  Returns the current record's "organization_id" value
 * @method integer             getDuration()        Returns the current record's "duration" value
 * @method contract            getContract()        Returns the current record's "contract" value
 * @method importance          getImportance()      Returns the current record's "importance" value
 * @method organization        getOrganization()    Returns the current record's "Organization" value
 * @method Doctrine_Collection getGroupclaim()      Returns the current record's "Groupclaim" collection
 * @method Doctrine_Collection getClaim()           Returns the current record's "Claim" collection
 * @method contract_importance setId()              Sets the current record's "id" value
 * @method contract_importance setContractId()      Sets the current record's "contract_id" value
 * @method contract_importance setImportanceId()    Sets the current record's "importance_id" value
 * @method contract_importance setOrganizationId()  Sets the current record's "organization_id" value
 * @method contract_importance setDuration()        Sets the current record's "duration" value
 * @method contract_importance setContract()        Sets the current record's "contract" value
 * @method contract_importance setImportance()      Sets the current record's "importance" value
 * @method contract_importance setOrganization()    Sets the current record's "Organization" value
 * @method contract_importance setGroupclaim()      Sets the current record's "Groupclaim" collection
 * @method contract_importance setClaim()           Sets the current record's "Claim" collection
 * 
 * @package    helpdesk
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Basecontract_importance extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('contract_importance');
        $this->hasColumn('id', 'integer', null, array(
             'primary' => true,
             'type' => 'integer',
             'autoincrement' => true,
             ));
        $this->hasColumn('contract_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('importance_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('organization_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('duration', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('contract', array(
             'local' => 'contract_id',
             'foreign' => 'id'));

        $this->hasOne('importance', array(
             'local' => 'importance_id',
             'foreign' => 'id'));

        $this->hasOne('organization as Organization', array(
             'local' => 'organization_id',
             'foreign' => 'id'));

        $this->hasMany('Groupclaim', array(
             'local' => 'id',
             'foreign' => 'contract_importance_id'));

        $this->hasMany('claim as Claim', array(
             'local' => 'id',
             'foreign' => 'contract_importance_id'));
    }
}