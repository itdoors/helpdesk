<div id="depperson_list"><?php echo htmlspecialchars_decode($departments->getPersonsWithDel()) ?></div><br />
<a class="join_user button" href="<?php echo url_for('departments/addpersonform').'/departments_id/'.$departments->getId()?>"><?php echo __('Join user')?></a> 
<div id="result"></div>
<a id="refresh" href="<?php echo url_for('departments/deppersonlist').'/departments_id/'.$departments->getId()?>"></a>

 
