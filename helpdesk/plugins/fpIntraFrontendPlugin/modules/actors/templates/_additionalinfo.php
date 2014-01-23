<div id="user_additionalinfo_form">
<?php echo get_component('actors', 'user_additionalinfo_form', array('additionalinfos'=>$additionalinfos))?>

</div> 
<?php
 echo get_component('Fmodel','form_add',
       array(
          'model' => 'UserContactinfo',
          'target'=>'addusercontactinfo',
          'button_text' => 'Add contactinfo',
          'default' => 
           array(
              'user_id'=>sfContext::getInstance()->getUser()->getAttribute('user_id', null, 'sfGuardSecurityUser'),
           ),
           'ref_functions'=>
           array(
               '#user_additionalinfo_form'=>url_for('actors/refresh_additionalimfo')
           )
         )
       );
?>
<div id="#addusercontactinfo"></div>