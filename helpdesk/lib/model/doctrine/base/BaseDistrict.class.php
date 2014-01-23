<?php

/**
 * BaseDistrict
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property integer $region_id
 * @property float $population
 * @property float $square
 * @property float $density
 * @property region $Region
 * @property Doctrine_Collection $City
 * 
 * @method integer             getId()         Returns the current record's "id" value
 * @method string              getName()       Returns the current record's "name" value
 * @method integer             getRegionId()   Returns the current record's "region_id" value
 * @method float               getPopulation() Returns the current record's "population" value
 * @method float               getSquare()     Returns the current record's "square" value
 * @method float               getDensity()    Returns the current record's "density" value
 * @method region              getRegion()     Returns the current record's "Region" value
 * @method Doctrine_Collection getCity()       Returns the current record's "City" collection
 * @method District            setId()         Sets the current record's "id" value
 * @method District            setName()       Sets the current record's "name" value
 * @method District            setRegionId()   Sets the current record's "region_id" value
 * @method District            setPopulation() Sets the current record's "population" value
 * @method District            setSquare()     Sets the current record's "square" value
 * @method District            setDensity()    Sets the current record's "density" value
 * @method District            setRegion()     Sets the current record's "Region" value
 * @method District            setCity()       Sets the current record's "City" collection
 * 
 * @package    helpdesk
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseDistrict extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('district');
        $this->hasColumn('id', 'integer', null, array(
             'primary' => true,
             'type' => 'integer',
             'autoincrement' => true,
             ));
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('region_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('population', 'float', null, array(
             'type' => 'float',
             ));
        $this->hasColumn('square', 'float', null, array(
             'type' => 'float',
             ));
        $this->hasColumn('density', 'float', null, array(
             'type' => 'float',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('region as Region', array(
             'local' => 'region_id',
             'foreign' => 'id'));

        $this->hasMany('city as City', array(
             'local' => 'id',
             'foreign' => 'district_id'));
    }
}