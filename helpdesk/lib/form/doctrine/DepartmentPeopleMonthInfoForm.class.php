<?php

/**
 * DepartmentPeopleMonthInfo form.
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class DepartmentPeopleMonthInfoForm extends BaseDepartmentPeopleMonthInfoForm
{
  public function configure()
  {
    $this->i18n = sfContext::getInstance()->getI18N();

    $isNew = $this->isNew();

    if (!$isNew)
    {
      $this->setWidget('department_people_name', new sfWidgetFormInput(array(), array(
        'disabled' => 'disabled'
      )));

      $object = $this->getObject();

      /** @var DepartmentPeople $departmentPeople */
      $departmentPeople = Doctrine::getTable('DepartmentPeople')->find($object->getDepartmentPeopleId());

      $this->getWidget('department_people_name')->setDefault($departmentPeople->getFullName());
      $this->getWidget('department_people_name')->setLabel('FIO');

      $personId = $this->getObject()->getDepartmentPeopleId();

      /** @var DepartmentPeople $person*/
      $person = Doctrine::getTable('DepartmentPeople')->find($personId);

      $departmentId = $person->getDepartmentId();
    }
    else
    {
      $departmentId = $this->getOption('departmentId');
      $year = $this->getOption('year');
      $month = $this->getOption('month');

      if ($departmentId && $year && $month)// form load but not submitted
      {
        $peopleIds = GrafikTable::getPeopleIds($departmentId, $year, $month);

        $query = Doctrine::getTable('DepartmentPeople')
          ->createQuery('dp')
          ->where('dp.department_id = ?', $departmentId)
          // ->andWhereNotIn('dp.id', $peopleIds)
          ->andWhere('dp.parent_id is null')
          ->orderBy('dp.name ASC');

        $this->setWidget('department_people_id', new sfWidgetFormDoctrineChoice(array(
          'model' => 'DepartmentPeople',
          'query' => $query
        )));

        $this->setValidator('department_people_id', new sfValidatorDoctrineChoice(array(
          'model' => 'DepartmentPeople',
          'query' => $query
        )));
      }
    }

    $this->setWidget('is_substitution', new sfWidgetFormInputCheckbox());
    $this->setValidator('is_substitution', new sfValidatorBoolean(array('required' => false)));

    $this->setWidget('mpk_id', new sfWidgetFormDoctrineJQueryAutocompleter(array(
      'model'=>'Mpk',
      'url'=>url_for('ajaxdata/auto_mpk'),
      'js_callback' => 'auto_mpk',
    ), array(
      'data-department_id' => $departmentId
    )));

    if ($departmentId) {
      /** @var Mpk $mpk */
      $mpk = Doctrine::getTable('Mpk')->findOneBy('department_id', $departmentId);

      if ($mpk) {
        $this->getWidget('mpk_id')->setDefault($mpk->getId());
      }
    }

    $this->setWidget('department_people_replacement_id', new sfWidgetFormDoctrineJQueryAutocompleter(array(
      'model'=>'DepartmentPeople',
      'url'=>url_for('ajaxdata/auto_department_people'),
    )));

    /*$queryReplacement = Doctrine::getTable('DepartmentPeople')
      ->createQuery('dp')
      ->where('dp.department_id = ?', $departmentId)
      ->andWhere('dp.parent_id is null')
      ->orderBy('dp.name ASC');

    $this->setWidget('department_people_replacement_id', new sfWidgetFormDoctrineChoice(array(
        'model' => 'DepartmentPeople',
        'query' => $queryReplacement,
        'add_empty' => true
      )
    ));*/

    /*$this->setValidator('department_people_replacement_id', new sfValidatorDoctrineChoice(array(
      'model' => 'DepartmentPeople',
      'query' => $queryReplacement,
      'required' => false
    )));*/

    $this->setWidget('type_id', new sfWidgetFormDoctrineChoice(
      array(
        'model' => 'lookup',
        'table_method' => 'getDepartmentPeople',
        'add_empty' => false
      ),
      array(
        'data-permanentTypeId' => lookup::getIdByLukey(lookup::DEPARTMENT_PEOPLE_TYPE_PERMANENT),
        'data-replacementTypeId' => lookup::getIdByLukey(lookup::DEPARTMENT_PEOPLE_TYPE_REPLACEMENT)
      )
    ));

    $this->setWidget('employment_type_id' , new sfWidgetFormDoctrineChoice(
      array(
        'model' => 'lookup',
        'table_method' => 'getOnlyEmploymentType',
        'add_empty' => true
      ),
      array(
        'data-aTypeId' => lookup::getIdByLukey(lookup::EMPLOYMENT_TYPE_A),
        'data-cTypeId' => lookup::getIdByLukey(lookup::EMPLOYMENT_TYPE_C),
        'data-bTypeId' => lookup::getIdByLukey(lookup::EMPLOYMENT_TYPE_B)
      )
    ));

    $this->setWidget('surcharge_type_id' , new sfWidgetFormDoctrineChoice(
      array(
        'model' => 'lookup',
        'table_method' => 'getOnlyEmploymentType',
        'add_empty' => true
      )
    ));

    $this->setWidget('bonus_type_id' , new sfWidgetFormDoctrineChoice(
      array(
        'model' => 'lookup',
        'table_method' => 'getOnlyEmploymentType',
        'add_empty' => true
      )
    ));

    $this->setWidget('fine_type_id' , new sfWidgetFormDoctrineChoice(
      array(
        'model' => 'lookup',
        'table_method' => 'getOnlyEmploymentType',
        'add_empty' => true
      )
    ));

    $department_people = Doctrine::getTable('lookup')->getDepartmentPeople();
    if (sizeof($department_people))
    {
      $this->setDefault('type_string', $department_people->getFirst()->getName());
    }

    unset($this['salary_type_id']);

    $charChoices = array(
      'k' => 'k',
      'd' => 'd',
      'r' => 'r'
    );

    $this->setWidget('surcharge_type_key', new sfWidgetFormChoice(array(
      'choices' => $charChoices,
    )));
    $this->setWidget('bonus_type_key', new sfWidgetFormChoice(array(
      'choices' => $charChoices,
    )));
    $this->setWidget('fine_type_key', new sfWidgetFormChoice(array(
      'choices' => $charChoices,
    )));

    $this->setValidator('surcharge_type_key', new sfValidatorChoice(array(
      'choices' => $charChoices,
      'required' => false
    )));
    $this->setValidator('bonus_type_key', new sfValidatorChoice(array(
      'choices' => $charChoices,
      'required' => false
    )));
    $this->setValidator('fine_type_key', new sfValidatorChoice(array(
      'choices' => $charChoices,
      'required' => false
    )));

    $this->setValidator('department_people_id', new sfValidatorString());
    $this->setValidator('department_people_replacement_id', new sfValidatorInteger(array(
      'required' => false
    )));
    $this->setValidator('year', new sfValidatorString());
    $this->setValidator('month', new sfValidatorString());

    $this->validatorSchema->setPostValidator(new sfValidatorAnd(
        array(
          new sfValidatorCallback(
            array(
              'callback' => array($this, 'checkReplacement'),
            )
          ),
          new sfValidatorCallback(
            array(
              'callback' => array($this, 'checkSurchargeBonusFine'),
            ))
          )
        )
     );

    $this->validatorSchema->setOption('allow_extra_fields', true);
    $this->validatorSchema->setOption('filter_extra_fields', false);

    $this->disableCSRFProtection();
  }

  /**
   * Binds the form with input values.
   *
   * It triggers the validator schema validation.
   *
   * @param array $taintedValues  An array of input values
   * @param array $taintedFiles   An array of uploaded files (in the $_FILES or $_GET format)
   */
  public function bind(array $taintedValues = null, array $taintedFiles = null)
  {
    $isNew = $this->isNew();

    if (!$isNew && $personId = $taintedValues['department_people_id'])
    {
      /** @var DepartmentPeople $person */
      $person = Doctrine::getTable('DepartmentPeople')->find($personId);

      if ($person)
      {
        $taintedValues['department_people_name'] = $person->getFullName();
      }
    }

    if (isset($taintedValues['department_people_replacement_id']))
    {
      if (!$taintedValues['department_people_replacement_id'])
      {
        $taintedValues['department_people_replacement_id'] = 0;
      }
    }

    parent::bind($taintedValues, $taintedFiles);
  }

  public function save($con = null)
  {
    /** @var DepartmentPeopleMonthInfo $object */
    $object = parent::save($con);

    $aTypeId = lookup::getIdByLukey(lookup::EMPLOYMENT_TYPE_A);
    $cTypeId = lookup::getIdByLukey(lookup::EMPLOYMENT_TYPE_C);
    $bTypeId = lookup::getIdByLukey(lookup::EMPLOYMENT_TYPE_B);

    $replacementTypeId = lookup::getIdByLukey(lookup::DEPARTMENT_PEOPLE_TYPE_REPLACEMENT);

    if ($object->getEmploymentTypeId() != $cTypeId && $object->getEmploymentTypeId() != $bTypeId && $object->getEmploymentTypeId() != $aTypeId)
    {
      $object->setIsCleanSalary(false);
      $object->setNormaDays(null);
      $object->save();
    }

    if ($object->getTypeId() != $replacementTypeId)
    {
      $object->setDepartmentPeopleReplacementId(0);
      $object->setIsSubstitution(false);
      $object->save();
    }

    // Process person
    /*$values = $this->values;
    if (isset($values['department_people_parent_id']))
    {
      $personId = $object->getDepartmentPeopleId();

      $person = Doctrine::getTable('DepartmentPeople')->find($personId);

      $person->setParentId($values['department_people_parent_id']);
      $person->save();

      DepartmentPeople::processParent($person, null, false);
    }*/

    return $object;
  }

  public function checkReplacement($validator, $values, $arguments)
  {
    $replacementTypeId = lookup::getIdByLukey(lookup::DEPARTMENT_PEOPLE_TYPE_REPLACEMENT);

    if (isset($values['type_id']))
    {
      if ($values['type_id'] == $replacementTypeId)
      {
        if (!isset($values['department_people_replacement_id']) || !$values['department_people_replacement_id'])
        {
          $error = $this->i18n->__('Choose some one to replacement');
          $this->setOption('replacementError', $error);
          throw new sfValidatorError($validator, $error);
        }
        else
        {
          if (isset($values['department_people_id']) && isset($values['department_people_replacement_id']))
          {
            if ($values['department_people_id'] == $values['department_people_replacement_id'])
            {
              $error = $this->i18n->__('You can\'t replace person by himself');
              $this->setOption('replacementError', $error);
              throw new sfValidatorError($validator, $error);
            }
          }
        }
      }
    }

    return $values;
  }

  public function checkSurchargeBonusFine($validator, $values, $arguments)
  {
    if ( (isset($values['surcharge']) && $values['surcharge']) xor
         (isset($values['surcharge_type_id']) && $values['surcharge_type_id']))
    {
      $error = $this->i18n->__('Surcharge Surcharge Type required');
      if (is_array($this->getOptions()))
      {
        $this->setOption('surchargeError', $error);
      }
      throw new sfValidatorError($validator, $error);
    }

    if ( (isset($values['bonus']) && $values['bonus']) xor
      (isset($values['bonus_type_id']) && $values['bonus_type_id']))
    {
      $error = $this->i18n->__('Bonus Bonus Type required');
      if (is_array($this->getOptions()))
      {
        $this->setOption('bonusError', $error);
      }
      throw new sfValidatorError($validator, $error);
    }

    if ( (isset($values['fine']) && $values['fine']) xor
      (isset($values['fine_type_id']) && $values['fine_type_id']))
    {
      $error = $this->i18n->__('Fine Fine Type required');
      if (is_array($this->getOptions()))
      {
        $this->setOption('fineError', $error);
      }
      throw new sfValidatorError($validator, $error);
    }
    return $values;
  }
}
