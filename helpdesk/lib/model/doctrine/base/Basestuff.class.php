<?php

/**
 * Basestuff
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $companystructure_id
 * @property string $mobilephone
 * @property string $mobilephone_personal
 * @property string $phone_inside
 * @property string $birth_place
 * @property date $hire_date
 * @property date $fire_date
 * @property string $education
 * @property string $issues
 * @property string $description
 * @property integer $user_id
 * @property enum $stuffclass
 * @property companystructure $Companystructure
 * @property sfGuardUser $Users
 * @property Doctrine_Collection $Departments
 * @property Doctrine_Collection $StuffDepartments
 * @property Doctrine_Collection $City
 * @property Doctrine_Collection $Claimtype
 * @property Doctrine_Collection $DogovorStuff
 * @property Doctrine_Collection $StuffCity
 * 
 * @method integer             getId()                   Returns the current record's "id" value
 * @method integer             getCompanystructureId()   Returns the current record's "companystructure_id" value
 * @method string              getMobilephone()          Returns the current record's "mobilephone" value
 * @method string              getMobilephonePersonal()  Returns the current record's "mobilephone_personal" value
 * @method string              getPhoneInside()          Returns the current record's "phone_inside" value
 * @method string              getBirthPlace()           Returns the current record's "birth_place" value
 * @method date                getHireDate()             Returns the current record's "hire_date" value
 * @method date                getFireDate()             Returns the current record's "fire_date" value
 * @method string              getEducation()            Returns the current record's "education" value
 * @method string              getIssues()               Returns the current record's "issues" value
 * @method string              getDescription()          Returns the current record's "description" value
 * @method integer             getUserId()               Returns the current record's "user_id" value
 * @method enum                getStuffclass()           Returns the current record's "stuffclass" value
 * @method companystructure    getCompanystructure()     Returns the current record's "Companystructure" value
 * @method sfGuardUser         getUsers()                Returns the current record's "Users" value
 * @method Doctrine_Collection getDepartments()          Returns the current record's "Departments" collection
 * @method Doctrine_Collection getStuffDepartments()     Returns the current record's "StuffDepartments" collection
 * @method Doctrine_Collection getCity()                 Returns the current record's "City" collection
 * @method Doctrine_Collection getClaimtype()            Returns the current record's "Claimtype" collection
 * @method Doctrine_Collection getDogovorStuff()         Returns the current record's "DogovorStuff" collection
 * @method Doctrine_Collection getStuffCity()            Returns the current record's "StuffCity" collection
 * @method stuff               setId()                   Sets the current record's "id" value
 * @method stuff               setCompanystructureId()   Sets the current record's "companystructure_id" value
 * @method stuff               setMobilephone()          Sets the current record's "mobilephone" value
 * @method stuff               setMobilephonePersonal()  Sets the current record's "mobilephone_personal" value
 * @method stuff               setPhoneInside()          Sets the current record's "phone_inside" value
 * @method stuff               setBirthPlace()           Sets the current record's "birth_place" value
 * @method stuff               setHireDate()             Sets the current record's "hire_date" value
 * @method stuff               setFireDate()             Sets the current record's "fire_date" value
 * @method stuff               setEducation()            Sets the current record's "education" value
 * @method stuff               setIssues()               Sets the current record's "issues" value
 * @method stuff               setDescription()          Sets the current record's "description" value
 * @method stuff               setUserId()               Sets the current record's "user_id" value
 * @method stuff               setStuffclass()           Sets the current record's "stuffclass" value
 * @method stuff               setCompanystructure()     Sets the current record's "Companystructure" value
 * @method stuff               setUsers()                Sets the current record's "Users" value
 * @method stuff               setDepartments()          Sets the current record's "Departments" collection
 * @method stuff               setStuffDepartments()     Sets the current record's "StuffDepartments" collection
 * @method stuff               setCity()                 Sets the current record's "City" collection
 * @method stuff               setClaimtype()            Sets the current record's "Claimtype" collection
 * @method stuff               setDogovorStuff()         Sets the current record's "DogovorStuff" collection
 * @method stuff               setStuffCity()            Sets the current record's "StuffCity" collection
 * 
 * @package    helpdesk
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Basestuff extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('stuff');
        $this->hasColumn('id', 'integer', null, array(
             'primary' => true,
             'type' => 'integer',
             'autoincrement' => true,
             ));
        $this->hasColumn('companystructure_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('mobilephone', 'string', 12, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 12,
             ));
        $this->hasColumn('mobilephone_personal', 'string', 128, array(
             'type' => 'string',
             'length' => 128,
             ));
        $this->hasColumn('phone_inside', 'string', 128, array(
             'type' => 'string',
             'length' => 128,
             ));
        $this->hasColumn('birth_place', 'string', 128, array(
             'type' => 'string',
             'length' => 128,
             ));
        $this->hasColumn('hire_date', 'date', null, array(
             'type' => 'date',
             ));
        $this->hasColumn('fire_date', 'date', null, array(
             'type' => 'date',
             ));
        $this->hasColumn('education', 'string', 128, array(
             'type' => 'string',
             'length' => 128,
             ));
        $this->hasColumn('issues', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('description', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('user_id', 'integer', null, array(
             'unique' => true,
             'notnull' => true,
             'type' => 'integer',
             ));
        $this->hasColumn('stuffclass', 'enum', null, array(
             'default' => 'stuff',
             'type' => 'enum',
             'values' => 
             array(
              0 => 'dispatcher',
              1 => 'stuff',
              2 => 'kurator',
              3 => 'smeta',
             ),
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('companystructure as Companystructure', array(
             'local' => 'companystructure_id',
             'foreign' => 'id'));

        $this->hasOne('sfGuardUser as Users', array(
             'local' => 'user_id',
             'foreign' => 'id'));

        $this->hasMany('departments as Departments', array(
             'refClass' => 'stuff_departments',
             'local' => 'stuff_id',
             'foreign' => 'departments_id'));

        $this->hasMany('stuff_departments as StuffDepartments', array(
             'local' => 'id',
             'foreign' => 'stuff_id'));

        $this->hasMany('city as City', array(
             'refClass' => 'sfuff_city',
             'local' => 'stuff_id',
             'foreign' => 'city_id'));

        $this->hasMany('claimtype as Claimtype', array(
             'refClass' => 'stuff_departments',
             'local' => 'stuff_id',
             'foreign' => 'claimtype_id'));

        $this->hasMany('Dogovor as DogovorStuff', array(
             'local' => 'id',
             'foreign' => 'stuff_id'));

        $this->hasMany('sfuff_city as StuffCity', array(
             'local' => 'id',
             'foreign' => 'stuff_id'));
    }
}