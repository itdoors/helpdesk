<div id="handling_messages">
  <?php include_component('handling', 'handling_messages', array('handlingId' => $handling->getId(), 'handling' => $handling))?>
</div>
<?php
echo
0 ? '' :
  get_component('Fmodel','form_add',
    array(
      'model' => 'HandlingMessage',
      'form_class' => 'HandlingMessage',
      'target'=>'handling_messages_list',
      'button_text' => __('Add message'),
      'default' =>
      array(
        'handling_id'=> $handling->getId()
      ),
      'ref_functions'=>
      array(
        '#handling_messages'=>url_for('handling/refresh_messages').'/handlingId/'.$handling->getId()
      )

    )
  )
?>