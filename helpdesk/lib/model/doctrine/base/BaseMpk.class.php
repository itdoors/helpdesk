<?php

/**
 * BaseMpk
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property integer $department_id
 * @property departments $Department
 * @property Doctrine_Collection $DepartmentPeople
 * 
 * @method integer             getId()               Returns the current record's "id" value
 * @method string              getName()             Returns the current record's "name" value
 * @method integer             getDepartmentId()     Returns the current record's "department_id" value
 * @method departments         getDepartment()       Returns the current record's "Department" value
 * @method Doctrine_Collection getDepartmentPeople() Returns the current record's "DepartmentPeople" collection
 * @method Mpk                 setId()               Sets the current record's "id" value
 * @method Mpk                 setName()             Sets the current record's "name" value
 * @method Mpk                 setDepartmentId()     Sets the current record's "department_id" value
 * @method Mpk                 setDepartment()       Sets the current record's "Department" value
 * @method Mpk                 setDepartmentPeople() Sets the current record's "DepartmentPeople" collection
 * 
 * @package    helpdesk
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseMpk extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('mpk');
        $this->hasColumn('id', 'integer', null, array(
             'primary' => true,
             'type' => 'integer',
             'autoincrement' => true,
             ));
        $this->hasColumn('name', 'string', 50, array(
             'type' => 'string',
             'unique' => true,
             'length' => 50,
             ));
        $this->hasColumn('department_id', 'integer', null, array(
             'type' => 'integer',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('departments as Department', array(
             'local' => 'department_id',
             'foreign' => 'id'));

        $this->hasMany('DepartmentPeople', array(
             'local' => 'id',
             'foreign' => 'mpk_id'));
    }
}