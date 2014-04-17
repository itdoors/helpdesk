<?php

/**
 * departments form.
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class departmentsForm extends BasedepartmentsForm
{
  public function configure()
  {
    parent::configure();
    
    unset($this['stuff_list'], $this['client_list'], $this['groupclaim_list']);
    
    sfContext::getInstance()->getConfiguration()->loadHelpers('Url');
    $user = sfContext::getInstance()->getUser();
    
    $this->setWidget('organization_id', new sfWidgetFormDoctrineJQueryAutocompleter(array(
      'model'=>'organization',
      'url'=>url_for('ajaxdata/auto_organization'),
      //'js_callback' => 'auto_organization'
      //'config' => '{ width: 350,max: 100,highlight:false ,multiple: false,multipleSeparator: ",",scroll: true,scrollHeight: 250}'
    )));
    
    $this->setValidator('organization_id', new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Organization'), 'required' => false))); 
    
    $this->setDefault('organization_id', 12);
    
    $this->setWidget('status_date', new sfWidgetFormJQueryDate(array(
          'config' => '{}',
          'culture' => 'ru',
          'date_widget' => new sfWidgetFormDate(array('format' => '%year%%month%%day%',), array('style'=>'min-width:70px;'))
     )));

    if ($user->hasCredential('admin')) {
      $this->setWidget('opermanager_id', new sfWidgetFormDoctrineJQueryAutocompleter(array(
        'model'=>'sfGuardUser',
        'url'=>url_for('ajaxdata/auto_stuff'),
      )));
    } else {
      unset($this['opermanager_id']);
    }
  }
}
