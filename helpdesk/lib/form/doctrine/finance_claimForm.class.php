<?php

/**
 * finance_claim form.
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class finance_claimForm extends Basefinance_claimForm
{
  public function configure()
  {
    //получаем mpk через claim_id из сессии
    $mpk = $this->getMpkByClaimId();
    //составляем widget если $mpk
    if ($mpk)
    {
        $mpk_choices = array(
        
            $mpk."d" => $mpk."d", 
            $mpk."k" => $mpk."k", 
            $mpk."t" => $mpk."t" , 
            $mpk."r" => $mpk."r");
        $this->setWidget('mpk', new  sfWidgetFormChoice(array('choices'=>$mpk_choices)));
        
    } 
      
      //$this->setWidget('claim_id' , new  sfWidgetFormInputHidden());
      /*$this->setWidget('smeta_datetime', new sfWidgetFormJQueryDate(array(
          'config' => '{}',
      ))); */
/*      $this->setWidget('smeta_file', new sfWidgetFormInputFileEditable(array(
            'file_src'    => '/uploads/smetafiles/'.$this->getObject()->smeta_file,
            'edit_mode'   => !$this->isNew(),
            'is_image'    => true,
            'with_delete' => false,
            'template' => '%input%'
          )),array('class'=>'required'));
      $this->setValidator('smeta_file', new sfValidatorFile(array(
           'mime_types' => array('image/jpeg','image/x-ms-bmp','image/gif', 'application/msword','application/pdf','application/octet-stream', 'application/x-rar','application/x-zip'),
       
        'path' => sfConfig::get('sf_upload_dir').'/smetafiles',
        'validated_file_class' => 'sfPhotoValidatedFileSmeta',
      )));   */
       $this->setWidget('status_id', new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Status'),'table_method'=>'getAllNonSmetaStatuses', 'add_empty' => true)));
        
  }
  
  protected function getMpkByClaimId()
  {
      //$claim_id = sfContext::getInstance()->getUser()->getAttribute('claim_id');
      $claim_id = $this->getObject()->getClaimId();
      if (!$claim_id) return null;
      $q = Doctrine::getTable('claim')
      ->createQuery('c')
      //->select('c.id, d.mpk as mpk')
      ->select('c.id, c.mpk as mpk')
      ->where('c.id = '.$claim_id)
      ->leftJoin('c.Departments d')
      ->fetchOne();
      return $q['mpk'];
  }
}
/* class sfPhotoValidatedFileSmeta extends sfValidatedFile
    {
      public function save($file = null, $fileMode = 0666, $create = true, $dirMode = 0777)
      {
         $claim_id = sfContext::getInstance()->getUser()->getAttribute(sfConfig::get('claim_container'));
         $file_name = parent::save($claim_id."-".$this->generateFilename(), $fileMode, $create, $dirMode);
         $image = imagecreatefromjpeg($this->path.'/'.$file_name);
         return $file_name;
      }
    }  */
class finance_claimStartForm extends sfForm
{
  public function configure()
  {
      $choices_claimtype = array(
      'all'=>'Все',
      'open'=>'Открытыте',
      'close'=>'Закрытые',
      );
      $choices_claimfinance = array(
      'all'=>'Все',
      'close'=>'Утвержденные',
      'open'=>'Неутвержденные',
      ); 
      $choices_datetype = array(
      'open'=>'по дате открытия',
      'close'=>'по дате закрытия',
      ); 
      $this->setWidget('claimtype' , new  sfWidgetFormChoice(array('choices'=>$choices_claimtype)));
      $this->setWidget('claimfinance' , new  sfWidgetFormChoice(array('choices'=>$choices_claimfinance)));
      $this->setWidget('claim_datetype' , new  sfWidgetFormChoice(array('choices'=>$choices_datetype)));
      $this->setWidget('date_range' , new  sfWidgetFormDateRange(
      array(
      'from_date' => new sfWidgetFormJQueryDate(array(
          'config' => '{}',
          'culture' => 'ru',
          'date_widget' => new sfWidgetFormDate(array('format' => '%day%%month%%year%',), array('style'=>'min-width:70px;'))
      )),
      'to_date' => new sfWidgetFormJQueryDate(array(
          'config' => '{}',
          'culture' => 'ru',
          'date_widget' => new sfWidgetFormDate(array('format' => '%day%%month%%year%', 'can_be_empty'=>false), array('style'=>'min-width:70px;'))
      ))
      )
      ));
      $this->setDefault('date_range',
      array(
        'from' =>array('year' => date('Y'), 'month' => 1, 'day' =>1),
        'to' =>array('year' => date('Y'), 'month' => date('n'), 'day' => date('j'))
      )
      );
      $this->setValidator('claimtype', new sfValidatorString());
      $this->setValidator('claimfinance', new sfValidatorString());
      $this->setValidator('claim_datetype', new sfValidatorString());
      $this->setValidator('date_range',  new sfValidatorDateRange(
      array(
      'from_date' => new sfValidatorDate(array( 'max' => date("Y-m-d"), 'datetime_output'=>'Y-m-d')),
      'to_date' => new  sfValidatorDate(array( 'max' => date("Y-m-d"), 'datetime_output'=>'Y-m-d'))
      )
      )); 
      
       $this->widgetSchema->setNameFormat('finance_claimStart[%s]');

       $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

      

    
        
  }

}

class finance_claimNewForm extends Basefinance_claimForm
{
  public function configure()
  {
    //получаем mpk через claim_id из сессии
    $mpk = $this->getMpkByClaimId();
    //составляем widget если $mpk
    if ($mpk)
    {
        $mpk_choices = array(
        
            $mpk."d" => $mpk."d", 
            $mpk."k" => $mpk."k", 
            $mpk."t" => $mpk."t" , 
            $mpk."r" => $mpk."r");
        $this->setWidget('mpk', new  sfWidgetFormChoice(array('choices'=>$mpk_choices)));
        
    } 
    $this->setWidget('status_id', new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Status'),'table_method'=>'getAllNonSmetaStatuses', 'add_empty' => true)));
     
    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'mpk'          => new sfValidatorString(array('max_length' => 50, 'required' => true)),
      'claim_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('claim'))),
      'work'          => new sfValidatorString(array('max_length' => 255, 'required' => true)),
      'status_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Status'), 'required' => true)),
      'costs_n'       => new sfValidatorNumber(array('required' => false)),
      'costs_nds'     => new sfValidatorNumber(array('required' => false)),
      'costs_beznalnonnds'  => new sfValidatorNumber(array('required' => false)),
      'costs_nonnds'  => new sfValidatorNumber(array('required' => false)),
      'income_nds'    => new sfValidatorNumber(array('required' => false)),
      'nds'    => new sfValidatorNumber(array('required' => false)),
      'obnal'    => new sfValidatorNumber(array('required' => false)),
    )); 

       
    $this->useFields(
      array(
        'mpk',
        'claim_id', 
        'work',
        'income_nds',
        'costs_beznalnonnds',
        'costs_nds',
        'status_id',
        'nds',
        'obnal'
      )); 
  }
  
  protected function getMpkByClaimId()
  {
      //$claim_id = sfContext::getInstance()->getUser()->getAttribute('claim_id');
      $claim_id = $this->getObject()->getClaimId();
      if (!$claim_id) return null;
      $q = Doctrine::getTable('claim')
      ->createQuery('c')
      ->select('c.id, c.mpk as mpk')
      //->select('c.id, d.mpk as mpk')
      ->where('c.id = '.$claim_id)
      ->leftJoin('c.Departments d')
      ->fetchOne();
      return $q['mpk'];
  }
  
}
