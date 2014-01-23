<?php

class IdeaExpertForm extends BaseIdeaForm
{
  public function configure()
  {
    $this->setWidget('expert_description' ,
      new isicsWidgetFormTinyMCE(
        array(
          'tiny_options' => sfConfig::get('app_tiny_mce_my_settings', array()),

        )
        ,
        array('class'=>'handling_message')
      ));

    $this->setValidator('significance', new sfValidatorInteger(array('min' => 0, 'max' => 40)));
    $this->setValidator('financial', new sfValidatorInteger(array('min' => 0, 'max' => 20)));
    $this->setValidator('originality', new sfValidatorInteger(array('min' => 0, 'max' => 20)));
    $this->setValidator('readiness', new sfValidatorInteger(array('min' => 0, 'max' => 20)));

    /*$this->validatorSchema->setPostValidator(
      new sfValidatorCallback(
      array(
        'callback' => array($this, 'checkTotal'),
      )));*/
  }

  public function checkTotal($validator, $values, $arguments)
  {
    $object = Doctrine::getTable('Idea')->find($values['id']);

    $significance = isset($values['significance']) ? $values['significance'] : $object->getSignificance();

    $financial = isset($values['financial']) ? $values['financial'] : $object->getSignificance();

    $originality= isset($values['originality']) ? $values['originality'] : $object->getOriginality();

    $readiness = isset($values['readiness']) ? $values['readiness'] : $object->getReadiness();

    $total = $significance + $financial + $originality + $readiness;

    if ($total > 100)
    {
      $error = $this->i18n->__('Total cant be more than 100');
      throw new sfValidatorError($validator, $error);
    }

    return $values;
  }

  public function save($con = null)
  {
    $object = parent::save($con);

    $modified = $object->getLastModified();

    /*if (sizeof($modified))
    {
      //send message to user
      $user = Doctrine::getTable('sfGuardUser')->find($object->getUserId());

      $subjectUser = SDtexts::getIdeaChangeByExpertSubjectUser($user->getFullName());
      $subjectText = SDtexts::getIdeaChangeByExpertTextUser($object, $user->getFullName());
      MailFunctions::sendMessageToUserById($user->getId(), $subjectUser, $subjectText);

      //eof send message to user
    }*/
    return $object;
  }
}