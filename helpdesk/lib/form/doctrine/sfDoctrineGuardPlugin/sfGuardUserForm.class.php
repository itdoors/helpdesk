<?php

/**
 * sfGuardUser form.
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrinePluginFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sfGuardUserForm extends PluginsfGuardUserForm
{
  public function configure()
  {
  }
}

class sfGuardUserChangePass extends PluginsfGuardUserForm
{
  public function configure()
  {
    parent::setup();

    $this->useFields(array('password'));

    $this->widgetSchema['password'] = new sfWidgetFormInputPassword();
    $this->validatorSchema['password']->setOption('required', true);
    $this->widgetSchema['password_again'] = new sfWidgetFormInputPassword();
    $this->validatorSchema['password_again'] = clone $this->validatorSchema['password'];
    $this->validatorSchema['password_again']->setOption('required', true);

    $this->mergePostValidator(new sfValidatorSchemaCompare('password', sfValidatorSchemaCompare::EQUAL, 'password_again', array(), array('invalid' => 'The two passwords must be the same.')));
  
  }
  
}

class UserIntranetProfileForm extends PluginsfGuardUserForm
{
  public function configure()
  {
    parent::setup();

    $this->widgetSchema['password'] = new sfWidgetFormInputPassword();
    $this->validatorSchema['password']->setOption('required', false);
    $this->widgetSchema['password_again'] = new sfWidgetFormInputPassword();
    $this->validatorSchema['password_again'] = clone $this->validatorSchema['password'];
    $this->validatorSchema['password_again']->setOption('required', false);

    $this->mergePostValidator(new sfValidatorSchemaCompare('password', sfValidatorSchemaCompare::EQUAL, 'password_again', array(), array('invalid' => 'The two passwords must be the same.')));

    $years_range = range(date('Y') - 80, date('Y')-18);
    $years = array_combine($years_range, $years_range);

    $this->setWidget('birthday', new sfWidgetFormDate(array('years' => $years)));
  
  
    $this->setWidget('photo', new sfWidgetFormInputFileEditable(array(
            'file_src'    => '/uploads/userprofiles/',
            'edit_mode'   => !$this->isNew(),
            'is_image'    => true,
            'with_delete' => false,
            'template' => '%input%'
          )),array('class'=>'required'));
    $this->setValidator('photo', new sfValidatorFile(array(
        'mime_types' => 'web_images',
        'path' => sfConfig::get('sf_upload_dir').'/userprofiles/',
        //'mime_type_guessers' =>'guessFromFileBinary',
        'validated_file_class' => 'sfPhotoValidatedFile',
        'required' => false  
      )));
  
    $this->useFields(
    array(
          'first_name',
          'middle_name',
          'last_name',
          'birthday',
          'password',
          'password_again',
          'photo',
          'about'
        )
    );
  
  }
  
  public function doSave($con = null)
  {
    $old_photo = $this->getObject()->getPhoto();
    $values = $this->updateObject();
    
    $this->getObject()->save();
    $new_photo = $this->getObject()->getPhoto();
    
    if ($old_photo && $old_photo != $new_photo)
    {
       $file =  sfConfig::get('sf_upload_dir').'/userprofiles/small_'.$old_photo;
       if (file_exists($file)) 
       {
           unlink($file); 
       }
    }
    
    //$this->getObject()->save();
    //$this->saveEmbeddedForms();
      
   }
  
}

class sfPhotoValidatedFile extends sfValidatedFile
    {
      public function save($file = null, $fileMode = 0666, $create = true, $dirMode = 0777)
      {
         //$file_name = parent::save('small_'.$this->generateFilename(), $fileMode, $create, $dirMode);
         $file_name = $this->generateFilename();
         $img = new sfImage($this->tempName, 'image/jpg');
          
         $img->resize($this->getThubnailWidth($img),$this->getThubnailHeight($img));
         $img->setQuality(50);
         $img->saveAs($this->path.DIRECTORY_SEPARATOR.'small_'.$file_name);
         
         
         return $file_name;
      }
      
      protected function getThubnailWidth($img)
      {
         $width = $img->getWidth();
         $height = $img->getHeight(); 
         if ($width >= $height)
         {
           return sfConfig::get('thumbnail_size');
         }
         $width = round(sfConfig::get('thumbnail_size')/$height*$width);
         return $width;
      }
      
      protected function getThubnailHeight($img)
      {
         $width = $img->getWidth();
         $height = $img->getHeight(); 
         if ($height >= $width)
         {
           return sfConfig::get('thumbnail_size');
         }
         $height =  round(sfConfig::get('thumbnail_size')/$width*$height);
         return  $height;
      }
      
      
    }

    
class UserIntranetProfileAboutForm extends PluginsfGuardUserForm
{
  public function configure()
  {
    parent::setup();
   
    $this->useFields(
    array(
           'about'
        )
    );
  
  }
  
}

class IntranetContactInfoForm extends PluginsfGuardUserForm
{
  public function configure()
  {
    $user_contactinfo_forms = new sfForm();
    $contacts_exists = $this->getObject()->getUserContactinfo();
    foreach($contacts_exists as $key=>$value)
    {
       $UserContactinfoForm = new UserContactinfoForm($value);
       unset($UserContactinfoForm['user_id']);
       $user_contactinfo_forms->embedForm('user_contactinfo'.($key+1), $UserContactinfoForm);
    }             
    
     $this->embedForm('user_contactinfos', $user_contactinfo_forms); 

  }
  
}


  
  
