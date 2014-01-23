<?php

class DogovorDepartmentCollectionForm extends DogovorDepartmentForm
{
  public function configure()
  {
    $organization_id = $this->getOption('organization_id');
    $dogovor_id = $this->getOption('dogovor_id');

    $query = Doctrine::getTable('departments')->getDepartmentsByOrganizationQuery($organization_id);

    $this->setWidget('departments_id',
      new sfWidgetFormDoctrineChoice(
        array(
          'model' => $this->getRelatedModelName('Department'),
          'add_empty' => false,
          'query' => $query,
          'multiple' => true
        )
      )
    );

    $query_dop_dogovor = Doctrine::getTable('DopDogovor')->getDopDogovorsByDogovorIdQuery($dogovor_id);

    $this->setWidget('dop_dogovor_id',
      new sfWidgetFormDoctrineChoice(
        array(
          'model' => $this->getRelatedModelName('DopDogovor'),
          'add_empty' => true,
          'query' => $query_dop_dogovor,
        )
      )
    );

    unset($this['department_id'], $this['user_id'], $this['createdatetime']);

    $this->setWidget('organization_id', new sfWidgetFormInputHidden());
    $this->setValidator('organization_id', new sfValidatorString());
    $this->setValidator('departments_id', new sfValidatorString());

    $this->widgetSchema->moveField('departments_id', 'after', 'dop_dogovor_id');
  }

  function save($con = null)
  {
    $taintedValues = $this->taintedValues;
    $taintedFiles = $this->taintedFiles;
    $departmentIds = $taintedValues['departments_id'];
    unset($taintedValues['_csrf_token']);
    unset($taintedValues['departments_id']);

    foreach($departmentIds as $department_id)
    {
      $taintedValues['department_id'] = $department_id;
      $form_class = 'DogovorDepartmentForm';
      $temp_form = new $form_class();
      $temp_form->disableCSRFProtection();
      $temp_form->bind($taintedValues, $taintedFiles);
      $object = $temp_form->save();
      $user_id = GlobalFunctions::getUserId();
      $object->setUserId($user_id);
      $object->setCreatedatetime(date("Y-m-d H:i:s"));
      $object->save();
    }
    return $object;
  }
}


