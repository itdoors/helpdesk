<?php

/**
 * BaseGroupclaimClaim
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $claim_id
 * @property integer $groupclaim_id
 * @property timestamp $createdatetime
 * @property Groupclaim $Groupclaim
 * @property claim $Claim
 * 
 * @method integer         getClaimId()        Returns the current record's "claim_id" value
 * @method integer         getGroupclaimId()   Returns the current record's "groupclaim_id" value
 * @method timestamp       getCreatedatetime() Returns the current record's "createdatetime" value
 * @method Groupclaim      getGroupclaim()     Returns the current record's "Groupclaim" value
 * @method claim           getClaim()          Returns the current record's "Claim" value
 * @method GroupclaimClaim setClaimId()        Sets the current record's "claim_id" value
 * @method GroupclaimClaim setGroupclaimId()   Sets the current record's "groupclaim_id" value
 * @method GroupclaimClaim setCreatedatetime() Sets the current record's "createdatetime" value
 * @method GroupclaimClaim setGroupclaim()     Sets the current record's "Groupclaim" value
 * @method GroupclaimClaim setClaim()          Sets the current record's "Claim" value
 * 
 * @package    helpdesk
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseGroupclaimClaim extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('groupclaim_claim');
        $this->hasColumn('claim_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('groupclaim_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('createdatetime', 'timestamp', null, array(
             'type' => 'timestamp',
             'notnull' => true,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Groupclaim', array(
             'local' => 'groupclaim_id',
             'foreign' => 'id'));

        $this->hasOne('claim as Claim', array(
             'local' => 'claim_id',
             'foreign' => 'id'));
    }
}