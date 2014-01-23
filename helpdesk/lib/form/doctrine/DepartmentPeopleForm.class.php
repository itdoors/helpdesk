<?php

/**
 * DepartmentPeople form.
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class DepartmentPeopleForm extends BaseDepartmentPeopleForm
{
  public function configure()
  {
    $isNew = $this->isNew();

    $years = range(date('Y') - 75, date('Y')-14);

    $this->setWidget('birthday', new sfWidgetFormDate(
      array(
        'format' => '%day%%month%%year%',
        'years' =>  array_combine($years, $years)
      ),
      array('style'=>'min-width:70px;')));

    $this->getWidget('number')->setLabel('Personnel number');

    $yearsAddmition = range(date('Y') - 15, date('Y'));

    $this->setWidget('admission_date', new sfWidgetFormDate(
      array(
        'format' => '%day%%month%%year%',
        'years' =>  array_combine($yearsAddmition, $yearsAddmition)
      ),
      array('style'=>'min-width:70px;')));

    $this->setWidget('dismissal_date', new sfWidgetFormDate(
      array(
        'format' => '%day%%month%%year%',
        'years' =>  array_combine($yearsAddmition, $yearsAddmition)
      ),
      array('style'=>'min-width:70px;')));

    $this->setValidator('first_name', new sfValidatorString(array('max_length' => 128, 'required' => true)));
    $this->setValidator('middle_name', new sfValidatorString(array('max_length' => 128, 'required' => false)));
    $this->setValidator('last_name', new sfValidatorString(array('max_length' => 128, 'required' => true)));
    // $this->setValidator('number', new sfValidatorString(array('max_length' => 128, 'required' => true)));

    $useFields = array(
      'last_name',
      'first_name',
      'middle_name',
      'number',
      'drfo',
      'passport',
      'person_code',
      'birthday',
      'phone',
      'address',
      'department_id',
      'admission_date',
      'dismissal_date',
    );

    if (!$isNew)
    {
      $departmentId = $this->getObject()->getDepartmentId();

      $personId = $this->getObject()->getId();

      $query = Doctrine::getTable('DepartmentPeople')
        ->createQuery('dp')
        ->where('dp.department_id = ?', $departmentId)
        ->andWhere('dp.id <> ?', $personId)
        ->andWhere('dp.parent_id is null')
        ->orderBy('dp.name ASC');

      $this->setWidget('department_people_parent_id', new sfWidgetFormDoctrineChoice(array(
        'model' => 'DepartmentPeople',
        'query' => $query,
        'add_empty' => true
      )));

      $this->setValidator('department_people_parent_id', new sfValidatorDoctrineChoice(array(
        'model' => 'DepartmentPeople',
        'query' => $query,
        'required' => true,
      )));

      $useFields[] = 'department_people_parent_id';
    }

    $this->useFields($useFields);
  }

  public function save($con = null)
  {
    if ($this->isNew() && isset($this->values['last_name']) && isset($this->values['first_name']) && isset($this->values['middle_name']))
    {
      $this->values['name'] = $this->values['last_name'] . ' ' . $this->values['first_name'] . ' ' . $this->values['middle_name'];
    }

    $object = parent::save($con);

    // Process person
    $values = $this->values;
    if (isset($values['department_people_parent_id']) && $values['department_people_parent_id'])
    {
      /** @var DepartmentPeople $person*/
      $person = $object;

      $person->setParentId($values['department_people_parent_id']);
      $person->save();

      /** @var DepartmentPeople $parentPerson */
      $parentPerson = Doctrine::getTable('DepartmentPeople')->find($values['department_people_parent_id']);

      if ($parentPerson)
      {
        $changed = false;

        if (!$parentPerson->getBirthday() && $person->getBirthday())
        {
          $parentPerson->setBirthday($person->getBirthday());
          $changed = true;
        }

        if (!$parentPerson->getPhone() && $person->getPhone())
        {
          $parentPerson->setPhone($person->getPhone());
          $changed = true;
        }

        if (!$parentPerson->getNumber() && $person->getNumber())
        {
          $parentPerson->setNumber($person->getNumber());
          $changed = true;
        }

        if (!$parentPerson->getDrfo() && $person->getDrfo())
        {
          $parentPerson->setDrfo($person->getDrfo());
          $changed = true;
        }

        if ($changed)
        {
          $parentPerson->save();
        }
      }

      DepartmentPeople::processParent($person, null, false);
    }

    return $object;
  }
}
