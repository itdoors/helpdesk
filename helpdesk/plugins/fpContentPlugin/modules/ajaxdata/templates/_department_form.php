<div style="padding: 20px;">
<?php echo __('Add department')?>
  <form action="<?php echo url_for('ajaxdata/department_form')?>" method="post" id="departments_new_form">
    <?php
      echo $form;
    ?>
    <input type="submit" value="<?php echo __('Save')?>">
  </form>
</div>

<script type="text/javascript">
$('#departments_new_form').submit(function(e)
{
  e.preventDefault();
  $(this).ajaxSubmit({
    success: function (returnVal)
    {
      var target = $('#departments_result');
      
      var data = JSON.parse(returnVal);
      if (data.error)
      {
        target.html(data.form);
      }
      else
      {
        $('#autocomplete_claim_departments_id').val(data.departments_address);
        $('#claim_departments_id').val(data.departments_id);
        target.html('<?php echo __('Department added successfully')?>');
      }
    }
  })
});
</script>
