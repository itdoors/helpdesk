<form action="<?php echo url_for('change_language') ?>" class="language">
<table  width="410" style="margin:0 auto">
 <tr>
   <th><?php echo $form['language']->renderLabel() ?></th> 
   <td width="220" valign="top"><?php echo $form['language'] ?><?php echo $form->renderHiddenFields(); ?></td>
   <td width="30" ><input type="submit" value="ok" /></td>  
</tr>   
</table>  
</form>