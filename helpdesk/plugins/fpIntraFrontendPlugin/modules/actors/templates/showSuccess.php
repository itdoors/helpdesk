

<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php 
      echo "";
      echo $sf_guard_user->getId() ?></td>
    </tr>
    <tr>
      <?php 
      $file_path = sfConfig::get('sf_upload_dir').DIRECTORY_SEPARATOR.'userprofiles'.DIRECTORY_SEPARATOR.'small_'.$sf_guard_user->getPhoto();
      if (file_exists($file_path))
      {
          $path = sfConfig::get('sf_upload_userplofiles').'small_'.$sf_guard_user->getPhoto();
          $src = "<img src=\"$path\" />";
      } else $src = __('No photo');
      
      ?>
      
            <td colspan="2"><?php echo $src?></td>
    </tr>
    <tr>
      <th><?php echo __('First name')?>:</th>
      <td><?php echo $sf_guard_user->getFirstName() ?></td>
    </tr>
    <tr>
      <th><?php echo __('Last name')?>:</th>
      <td><?php echo $sf_guard_user->getLastName() ?></td>
    </tr>
    <tr>
      <th><?php echo __('Middle name')?>:</th>
      <td><?php echo $sf_guard_user->getMiddleName() ?></td>
    </tr>
    <tr>
      <th><?php echo __('Position')?>:</th>
      <td><?php echo $sf_guard_user->getPosition() ?></td>
    </tr>
    <tr>
      <th><?php echo __('Email address')?>:</th>
      <td><?php echo $sf_guard_user->getEmailAddress() ?></td>
    </tr>
 
    <tr>
      <th><?php echo __('Created at')?>:</th>
      <td><?php echo format_date($sf_guard_user->getCreatedAt(), "D") ?></td>
    </tr>
    <tr>
      <th><?php echo __('About')?>:</th>
      <td><?php echo $sf_guard_user->getAbout() ?></td>
    </tr>
    <tr>
      <th><?php echo __('Additional info')?>:</th>
      <td><?php
        foreach ($additionalinfos as $additionalinfo)
        {
            echo $additionalinfo->getContactinfo()->getName().": ".$additionalinfo->getValue()."<br />";
        }
      
       ?></td>
    </tr>

 

  </tbody>
</table>

<hr />

<a href="<?php echo url_for('actors/index') ?>"><?php echo __('Back to list')?></a>
<a href="<?php echo url_for('actors/edit').'/id/'.$sf_guard_user->getId() ?>"><?php echo __('Edit')?></a>
