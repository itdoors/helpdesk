<?php

/**
 * Idea form.
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class IdeaForm extends BaseIdeaForm
{
  public function configure()
  {
    $this->setWidget('description' ,
      new isicsWidgetFormTinyMCE(
        array(
          'tiny_options' => sfConfig::get('app_tiny_mce_my_settings', array()),

        )
        ,
        array('class'=>'handling_message')
      ));

    $this->setWidget('result' ,
      new isicsWidgetFormTinyMCE(
        array(
          'tiny_options' => sfConfig::get('app_tiny_mce_my_settings', array()),

        )
        ,
        array('class'=>'handling_message')
      ));

    $this->setValidator('description', new sfValidatorString(array('required' => true)));
    $this->setValidator('result', new sfValidatorString(array('required' => true)));

    $goals = Doctrine::getTable('IdeaGoal')
      ->createQuery('g')
      ->orderBy('g.id ASC')
      ->execute();

    $choices = sizeof($goals) ? $goals->toKeyValueArray('id', 'name') : array();
    $choicesValidator = sizeof($choices) ? array_keys($choices) : array();

    $this->setWidget('goals_list', new sfWidgetFormSelectCheckbox(array('choices' => $choices)));
    $this->setValidator('goals_list', new sfValidatorChoice(array('choices' => $choicesValidator, 'multiple' => 'multiple')));

    $this->useFields(array(
      'name',
      'description',
      'result',
      'goals_list',
      //'testcheck'
    ));
  }

  public function updateObject($values = null)
  {
    if (null === $values)
    {
      $values = $this->values;
    }

    if ($this->isNew())
    {
      $values['user_id'] = GlobalFunctions::getUserId();
      $values['createdatetime'] = GlobalFunctions::getCreatedatetime();
    }

    return parent::updateObject($values);
  }

  public function save($con = null)
  {
    $isNew = $this->isNew();

    $object = parent::save();

    if ($isNew)
    {
      //send email to $userId
      $i18n = sfContext::getInstance()->getI18N();
      sfContext::getInstance()->getConfiguration()->loadHelpers('Url');

      //send message to user
      $user = Doctrine::getTable('sfGuardUser')->find($object->getUserId());

      $subjectUser = SDtexts::getIdeaCreateSubjectUser($user->getFullName());
      $subjectText = SDtexts::getIdeaCreateTextUser($user->getFullName());
      MailFunctions::sendMessageToUserById($user->getId(), $subjectUser, $subjectText, true);
      //eof send message to user

      //send message to admins
      $url = url_for2('ideas_show', array('id' => $object->getId()), true);

      $params = array(
        '%url%' => $url,
      );

      $subject = SDtexts::getIdeaCreateSubjectAdmin($object);
      $text = SDtexts::getIdeaCreateTextAdmin($object, $url, $user->getFullName());

      $email1 = 'k.paereli@griffin.ua';
      $email2 = 'v.opasyik@griffin.ua';

      MailFunctions::sendMessageToUser($email1, $subject, $text, true);
      MailFunctions::sendMessageToUser($email2, $subject, $text, true);
      //eof send message to admins
    }

    return $object;
  }
}
