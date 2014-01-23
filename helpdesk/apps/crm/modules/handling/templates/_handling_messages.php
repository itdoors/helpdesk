<?php foreach ($messages as $message): ?>
  <div class="groupbox grayblack">
    <?php echo $message->getUser() ?> -
    <?php
    if ($sf_user->hasCredential('crmadmin') && !$handling->getIsClosed())
    {
      include_component('Fmodel', 'ajax_field_change',
        array(
          'where' => array(
            'id' => $message->getId(),
          ),
          'model' => 'HandlingMessage',
          'field' => 'type_id',
          'toString' => 'getHandlingMessageTypeString',
          'shortEdit' => true,
          'default'  =>  $message->getHandlingMessageTypeString()
        )
      );
    }
    else
    {
      echo $message->getHandlingMessageType();
    }?>
    -
    <?php
    if ($sf_user->hasCredential('crmadmin') && !$handling->getIsClosed())
    {
      include_component('Fmodel', 'ajax_field_change',
        array(
          'where' => array(
            'id' => $message->getId(),
          ),
          'model' => 'HandlingMessage',
          'field' => 'createdate',
          'toString' => 'getCreatedateGood',
          'shortEdit' => true,
          'default'  =>  $message->getCreatedateGood()
        )
      );
    }
    else
    {
      echo $message->getHandlingMessageType();
    }?>
    <?php if ($sf_user->hasCredential('crmadmin') && $message->getCreatedatetime()) : ?>
      (<?php echo __('Created:')?> <?php echo $message->getCreatedatetimeGood();?>)
    <?php endif;?>
  </div>
  <div class="groupbox normal">

    <?php
    if ($sf_user->hasCredential('crmadmin') && !$handling->getIsClosed())
    {
      include_component('Fmodel', 'ajax_field_change',
        array(
          'where' => array(
            'id' => $message->getId(),
          ),
          'model' => 'HandlingMessage',
          'field' => 'description',
          'toString' => 'getDescriptionDecoded',
          'default'  =>  html_entity_decode($message->getDescription())
        )
      );
    }
    else
    {
      echo html_entity_decode($message->getDescription());
    }?>
  </div>
  <?php if ($message->getFilepath()) : ?>
  <div class="groupbox normal">
    <a href="/uploads/handling_message/<?php echo $message->getHandlingId() ?>/<?php echo $message->getFilepath() ?>" target="_blank">
      <?php echo $message->getFilename() ? $message->getFilename() : __('File')?>
    </a>
  </div>
  <?php endif;?>
<?php endforeach; ?>
<div class="delimiter"></div>