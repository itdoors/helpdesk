<?php use_helper('I18N') ?>
<form action="<?php echo url_for('@sf_guard_signin') ?>" method="post" style="margin:30px auto;">
  <table align="center" width="460px" style="margin:0px auto;background-color:#FFF; border:5px solid #EAECEE;padding:20px;"  class="login">
    <tbody>
        <tr><td></td></tr>
        <tr><td colspan="2" style="padding:10px;text-align:center;"><img src="/img/logo_big.jpg" alt="Логотип Импел Гриффин" /></td></tr>
        <tr><td colspan="2"><p class="loginMessage">
        <?php echo __('Enter your username and password. Data is key sensitive')?> 
        </p></td></tr>
      <tr>
      
  <td> 
<?php  echo $form  ?>                      
</td>
</tr>

    </tbody>
    <tfoot>
      <tr>
        <td colspan="2"> <input type="submit" value="<?php echo __('Signin') ?>" />
                  <?php $routes = $sf_context->getRouting()->getRoutes() ?>
          <?php if (isset($routes['sf_guard_forgot_password'])): ?>
            <a href="<?php echo url_for('@sf_guard_forgot_password') ?>"><?php echo __('Forgot your password?') ?></a>
          <?php endif; ?>

          <?php if (isset($routes['sf_guard_register'])): ?>
            &nbsp; <a href="<?php echo url_for('@sf_guard_register') ?>"><?php echo __('Want to register?') ?></a>
          <?php endif; ?>
          </td>
      </tr>
    </tfoot>
  </table>


</form>
<?php include_component('language', 'language') ?>  
  <div id="copyright1">
&copy; 1995-2010 <?php echo __('All rights reserved OOO.')?>  &laquo;<a href="http://www.griffin.ua" title="<?php echo __('Go to corporate website')?>"><?php echo __('Impel Griffin Group')?></a>&raquo;
</div>