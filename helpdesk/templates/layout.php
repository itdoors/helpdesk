<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="icon" type="image/x-icon" href="/img/favicon.ico" />
    <link rel="shortcut icon" type="image/x-icon" href="/img/favicon.ico" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
  </head>
<body>
<script type="text/javascript">
  $( document ).tooltip();
</script>
<?php  
$app = $sf_context->getConfiguration()->getApplication();
$access = ($app != 'kurator') ? $app : 'stuff';
if ($app == 'oper')
{
  $access = 'stuff';
}
if ($sf_user->isAuthenticated()&&$sf_user->hasCredential($access)) {?>
    <div id="wrapper">
        <div id="header">
            <?php echo include_partial("application_template/header")?>
        </div><!--header-->
        <div id="menu">
            <ul class="mainmenu">
                <li class="active"><a href="#" title="" class="dropdown">Helpdesk</a></li>
                <?php if ($app == 'kurator'):?>
                 <li ><a href="<?php echo url_for('goto_stuff')?>" title="" class="dropdown"><?php echo __('Change to stuff')?></a></li>
                <?php endif;?>
                <?php if ($app == 'stuff'):?>
                 <li ><a href="<?php echo url_for('goto_kurator')?>" title="" class="dropdown"><?php echo __('Change to kurator')?></a></li>
                <?php endif;?>
                <?php echo get_component('claim','getclaimById')?>
            </ul>
            <ul class="submenu">
                <?php include_partial("application_template/".ucfirst($app)."_menu")?>
            </ul>
            
        </div><!--menu-->
        <div class="delimiter"></div>
        
        <table width="100%" class="clear">
            <tbody>
                <tr>
                   <td width="100%" valign="top">
                        <div id="sf_admin_container">   
                            <?php include_partial('common/flashes') ?> 
                        </div>
                   
                         <?php  echo $sf_content?>                  
                    </td>
                </tr>
            </tbody>
        </table>
        
        
  
  
    <div id="footer">
        <?php include_partial("application_template/footer")?>
    </div>
    </div>
<?php  } else echo $sf_content?>    
    <!--wrapper-->

</body>
</html>
