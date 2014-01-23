<?php

/**
 * comments filter form.
 *
 * @package    helpdesk
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class commentsFormFilter extends BasecommentsFormFilter
{
  public function configure()
  {
      $this->setWidget('claim_id', new sfWidgetFormInput()); 
      $this->setValidator('claim_id', new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Claim'), 'column' => 'id')));
  }
}
