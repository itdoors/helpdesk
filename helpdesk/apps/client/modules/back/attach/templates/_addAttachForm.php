<tr id="attach_<?php echo $num ?>">
  <td><?php //echo $field->renderLabel('Attach '.$num) ?></td>
  <td>
  
     <?php echo $field['filename']->renderError() ?>
     <?php echo $field['filename']->renderLabel() ?>
     <?php echo $field['filename'] ?><br />
     <?php echo $field['filepath']->renderError() ?>
     <?php echo $field['filepath'] ?>
     
  </td>
  <?php echo $field['id'] ?>
    <?php if ($sf_request->isXmlHttpRequest()): ?>
    <td>
        <a href="#" onclick="delAttach(<?php echo $num ?>);return false;" class="file_delete"><?php echo __("Delete")?></a>
    </td>
    <?php endif; ?>
</tr>