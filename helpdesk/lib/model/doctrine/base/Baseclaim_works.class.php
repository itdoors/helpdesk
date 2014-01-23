<?php

/**
 * Baseclaim_works
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $works_id
 * @property integer $claim_id
 * @property works $works
 * @property claim $claim
 * 
 * @method integer     getWorksId()  Returns the current record's "works_id" value
 * @method integer     getClaimId()  Returns the current record's "claim_id" value
 * @method works       getWorks()    Returns the current record's "works" value
 * @method claim       getClaim()    Returns the current record's "claim" value
 * @method claim_works setWorksId()  Sets the current record's "works_id" value
 * @method claim_works setClaimId()  Sets the current record's "claim_id" value
 * @method claim_works setWorks()    Sets the current record's "works" value
 * @method claim_works setClaim()    Sets the current record's "claim" value
 * 
 * @package    helpdesk
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Baseclaim_works extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('claim_works');
        $this->hasColumn('works_id', 'integer', null, array(
             'primary' => true,
             'type' => 'integer',
             ));
        $this->hasColumn('claim_id', 'integer', null, array(
             'primary' => true,
             'type' => 'integer',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('works', array(
             'local' => 'works_id',
             'foreign' => 'id'));

        $this->hasOne('claim', array(
             'local' => 'claim_id',
             'foreign' => 'id'));
    }
}