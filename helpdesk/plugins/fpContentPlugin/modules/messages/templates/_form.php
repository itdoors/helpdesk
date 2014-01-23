<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('messages/create'); ?>" method="post" enctype="multipart/form-data" class="page_loader_link">
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>

<?php $counter = 0 ?>
<?php $name = 'attach' ?>

  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <input type="submit" value="<?php echo __('Send')?>" class="page_loader_link"/>
        </td>
      </tr>
    </tfoot>
    <tbody>
       <?php 
         
         $form->setDefault('claim_id', $claim->getId());
         $form1  = clone $form;
         unset($form['attach']);
         echo $form;
       ?>
      <tr>
        <th><?php echo $form1['attach']->renderLabel() ?></th>
        <td>
          <table>
            <tbody id="attach_container">      
              <?php foreach($form1[$name] as $key=>$field): ?>
                  <?php echo include_partial('attach/addAttachForm', array('field' => $field, 'num' => ++$counter)) ?>
              <?php endforeach; ?>
            </tbody>
          </table>
        </td>
      </tr>
    </tbody>
    <tfoot>
      <tr>
        <td>&nbsp;</td>
        <td>
          <div class="loading_image" id="loader_attach"></div>
          <button id="add_attach" type="button"><?php echo __("Add Attach") ?></button>
        </td>
      </tr>
    </tfoot>
  </table>
</form>
<script type="text/javascript">
var cnt = <?php echo $counter ?>;
function addAttach(num)
{
  $('#loader_attach').show();
  var r = jQuery.ajax({
    type: 'GET',
    url: '<?php echo url_for('attach/addAttachForm')?>'+'<?php echo ($form->getObject()->isNew()?'':'?id='.$form->getObject()->getId()).($form->getObject()->isNew()?'?num=':'&num=')?>'+num,
    async: false,
    success: attachAdded
  }).responseText;
  return r;
};
function attachAdded()
{
    $('#loader_attach').hide();
}
function delAttach(num)
{
document.getElementById('attach_container').removeChild(document.getElementById('attach_'+num));
  cnt = cnt - 1;
};
jQuery().ready(function()
{
  jQuery('button#add_attach').click(function() {
    jQuery("#attach_container").append(addAttach(cnt));
    cnt = cnt + 1;
  });
});
</script>