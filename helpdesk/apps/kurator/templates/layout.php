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
<?php  if ($sf_user->isAuthenticated()&&$sf_user->hasCredential('stuff')) { 
        
         ?>
    <div id="wrapper">
        <div id="header">
            <div id="logo">
                <a href="<?php echo url_for('claimopened')?>" title=""><img src="/img/logo.jpg" alt="" /></a>
            </div>
            <div id="links">
              <a href="http://www.griffin.ua" target="_blank">www.griffin.ua</a> <br />
              Service-Desk: (067) 404-00-<span style="display:none">_</span>70 <br />
              <p>Техническая поддержка: (093) 356-36-<span style="display:none">_</span>26</p>  
            </div>
            <div id="search">&nbsp;
            </div>
            <div id="user">
                <div class="left">
                    <a href="#" title=""><?php echo $sf_user?></a> <br />
                    <em><?php echo $sf_user->getPositionUser()?></em>
                    <?php //include_component('language', 'language') ?> 
                </div>
                <div class="right">
                    <a href="<?php echo url_for('logout')?>" title="" class="red">Выйти</a>
                </div>
    
            </div>
        </div><!--header-->
        <div id="menu">
            <ul class="mainmenu">
                <li class="active"><a href="#" title="" class="dropdown">Helpdesk</a></li>
                <li ><a href="<?php echo url_for('goto_stuff')?>" title="" class="dropdown">Зайти под исполнителем</a></li>
               
                       <?php echo get_component('claim','getclaimById')?>
                 
            </ul>
            <ul class="submenu">
                <li <?php //if ($sf_user->getModuleName() == 'claimopened') echo 'class="active"'?>><a href="<?php echo url_for('claimopened')?>"><?php echo __('Открытые заявки')?></a></li>
                <li><a href="<?php echo url_for('claimclosed')?>"><?php echo __('Закрытые заявки')?></a></li>
                <?php if ($sf_user->hasCredential('superkurator')):?>
                    <li><a href="<?php echo url_for('claimopened/new')?>"><?php echo __('Создать заявку')?></a></li>
                <?php endif;?>    
                <li><a href="<?php echo url_for('changepass')?>"><?php echo __('Изменить пароль') ?></a></li>
                <li><a href="<?php echo url_for('reports/index')?>"><?php echo __('Отчеты(закрытые заявки)')?></a></li>
                <li><a href="<?php echo url_for('reportsopen/index')?>"><?php echo __('Отчеты(открытые заявки)')?></a></li>
                
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
        <p>&copy; 1995-2010 Все права защищены ООО &laquo;<a href="http://www.griffin.ua" title="Перейти на корпоративный сайт">Импел Гриффин Груп</a>&raquo;</p>
    </div>
    </div>
<?php } else echo $sf_content?>    
    <!--wrapper-->

</body>
</html>
