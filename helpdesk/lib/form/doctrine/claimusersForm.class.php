<?php

/**
 * claimusers form.
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class claimusersForm extends BaseclaimusersForm
{
  public function configure()
  {
  }
  
}

class JoinUserForm extends BaseclaimusersForm
{
  public function configure()
  {
      $this->setWidget('claim_id' , new  sfWidgetFormInputHidden());  
      $this->setWidget('userkey' , new  sfWidgetFormInputHidden());  
      $this->setWidget('user_id' , new  sfWidgetFormDoctrineChoice(array('model' => 'sfGuardUser', 'table_method' => 'getAllStuff', 'add_empty' => false,'multiple'=>true)));  
      $this->setValidator('user_id' , new sfValidatorDoctrineChoice(array('model' => 'sfGuardUser', 'required' => true)));  
      $this->useFields(
         array(
         'claim_id',
         'userkey',
         'user_id'
      ));  
  }
  
}
class claimusersAddUserForm extends BaseclaimusersForm
{
  public function configure()
  {
      $this->setWidget('claim_id' , new  sfWidgetFormInputHidden());  
      $this->setWidget('userkey' , new  sfWidgetFormInputHidden());  
      $this->setWidget('user_list' , new  sfWidgetFormDoctrineChoice(array('model' => 'sfGuardUser', 'table_method' => 'getAllStuff', 'add_empty' => false,'multiple'=>true), array('class'=>'claim_stuff_list')));  
      $this->setValidator('user_list' , new sfValidatorDoctrineChoice(array('model' => 'sfGuardUser', 'required' => true, 'multiple'=>true)));  
      $this->useFields(
         array(
         'claim_id',
         'userkey',
         'user_list'
      ));  
  }
  
  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['user_list']) && $this->getObject()->getClaimId() && $this->getObject()->getUserkey())
    {
        
        $this->setDefault('user_list', $this->getAdiitionalDefaults()->getPrimaryKeys());
    }


  }
  
  protected function getAdiitionalDefaults()
  {
      return Doctrine::getTable('sfGuardUser')
      ->createQuery('u')
      ->select('u.id')
      ->leftJoin('u.ClaimUsers cu')
      ->where('cu.claim_id ='.$this->getObject()->getClaimId())
      ->addWhere('userkey = \''.$this->getObject()->getUserkey().'\'')
      ->execute();
  }
  
  public function doSave($con = null)
  {
    $values = $this->values;
    $users = $values['user_list'];
    $this->delAllClaimusersByUserkey($values['claim_id'], $values['userkey']);
    foreach ($users as $user => $value)
    {
        $taintedValues = $this->taintedValues;
        $taintedValues['user_id'] = $value;
        //$taintedValues
        $form = new claimusersForm();
        $form->disableCSRFProtection();
        unset($taintedValues['_csrf_token'], $taintedValues['user_list'], $form['_csrf_token']);
        $form->bind($taintedValues);
        $form->save();
    }
    $field = $values['userkey'];
    $toString = "get".ucfirst($field);
    $result_to_string = Doctrine::getTable('claim')->find($values['claim_id'])->$toString();  
    log_claim::NewLogRecord($values['claim_id'], null, sfConfig::get('logcliam_new'.$field)." ".$result_to_string, '');  

  }
  
  protected function delAllClaimusersByUserkey($claim_id, $userkey)
  {
        $claimuser = Doctrine::getTable('claimusers')
        ->createQuery('s')
        ->where('claim_id = '.$claim_id)
        ->addWhere('userkey = \''.$userkey.'\'')
        ->delete()
        ->execute();
  }
  
}
