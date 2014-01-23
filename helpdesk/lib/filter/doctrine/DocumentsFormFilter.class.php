<?php

/**
 * Documents filter form.
 *
 * @package    helpdesk
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class DocumentsFormFilter extends BaseDocumentsFormFilter
{
  public function configure()
  {
      $this->setWidget('claim_list', new sfWidgetFormInput());
      $this->setValidator('claim_list', new sfValidatorDoctrineChoice(array('model' => 'claim', 'required' => false)));
      
  }
}
