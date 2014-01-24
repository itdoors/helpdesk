<?php
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
      'file_src'    => 'uploads/userprofiles/'.$this->getObject()->getId(),
      'edit_mode'   => !$this->isNew(),
      'is_image'    => true,
      'with_delete' => false,
      'template' => '%input%'
    )),array('class'=>'required'));


    $this->setValidator('photo', new sfValidatorFile(array(
      'mime_types' => 'web_images',
      'path' => sfConfig::get('sf_upload_dir').'/userprofiles/'.$this->getObject()->getId(),
      'validated_file_class' => 'sfActorPhotoValidatedFile',
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

    $userId = !$this->isNew() ? $this->getObject()->getId() : '';

    if ($old_photo && $old_photo != $new_photo)
    {
      $file =  sfConfig::get('sf_upload_dir').'/userprofiles/' . $userId . DIRECTORY_SEPARATOR . $old_photo;
      if (file_exists($file))
      {
        unlink($file);
      }

      $imagesSize = sfConfig::get('app_profile_images');

      foreach ($imagesSize as $imagePrefix => $imageSize)
      {
        $file =  sfConfig::get('sf_upload_dir').'/userprofiles/' . $userId . DIRECTORY_SEPARATOR . $imagePrefix . '_'.$old_photo;
        if (file_exists($file))
        {
          unlink($file);
        }
      }
    }
  }
}