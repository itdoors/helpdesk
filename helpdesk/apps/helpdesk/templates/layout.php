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
<?php  if ($sf_user->isAuthenticated()&&$sf_user->hasCredential('admin')) { 
        
         ?>
    <div id="wrapper">
        <div id="header">
            <div id="logo">
                <a href="" title=""><img src="/img/logo.jpg" alt="" /></a>
            </div>
            <div id="links">
            
            </div>
            <div id="search">&nbsp;
            </div>
            <div id="user">
                <div class="left">
                    <a href="#" title=""><?php //echo $sf_user?></a> <br />
                    <em><?php //echo $sf_user->getPositionUser()?></em>
                </div>
                <div class="right">
                    <a href="<?php echo url_for('logout')?>" title="" class="red">Выйти</a>
                </div>
    
            </div>
        </div><!--header-->
        <div id="menu">
            <ul class="mainmenu">
                <li class="active"><a href="#" title="" class="dropdown">Helpdesk</a></li>
                <li><a href="#">Калькуляция</a></li>
                <li><a href="#" class="dropdown">Калькуляция</a></li>
                <li><a href="#">Калькуляция</a></li>
            </ul>
            <ul class="submenu">
                      <li><a href="<?php echo url_for('userclient')?>">Клиенты</a></li>
                <li><a href="<?php echo url_for('userstuff')?>">Сотрудники</a></li>
                      <li><a href="<?php echo url_for("organization")?>">Организация</a></li>  
                      <li><a href="<?php echo url_for("contract")?>">Контракт</a></li>  
                      <li><a href="<?php echo url_for("importance")?>">Важность</a></li>  
                      <li><a href="<?php echo url_for("contract_importance")?>">Контракт-Важность</a></li>
                      <li><a href="<?php echo url_for("contract_works")?>">Контракт-Работы</a></li>  
                      <li><a href="<?php echo url_for("workstypes")?>">ТипыРаботы</a></li>  
                      <li><a href="<?php echo url_for("works")?>">Работы</a></li>  
                      <li><a href="<?php echo url_for("departments")?>">Отделения</a></li>  
                      <li><a href="<?php echo url_for("companystructure")?>">Структура</a></li>
                      <li><a href="<?php echo url_for('stuff_departments')?>">stuff_departments</a></li>   
                      <li><a href="<?php echo url_for("city")?>">Город</a></li>
                      <li><a href="<?php echo url_for('district')?>">Район</a></li>
                      <li><a href="<?php echo url_for("region")?>">Область</a></li>  
                      
            </ul><br /><br />          
            <ul class="submenu">
                      <li><a href="<?php echo url_for("claim")?>">Заявка</a></li>
                      <li><a href="<?php echo url_for("log_claim")?>">Log Заявка</a></li>
                      <!--<li><a href="<?php echo url_for("clienttemp")?>">Клиенты</a></li>-->
                      <!--<li><a href="<?php echo url_for("stufftemp")?>">Исполнители</a></li>-->
                      <li><a href="<?php echo url_for("lookup")?>">Lookup</a></li>
                      <li><a href="<?php echo url_for("comments")?>">Коментарии</a></li>
                      <li><a href="<?php echo url_for("claimusers")?>">Claimusers</a></li>
                      <li><a href="<?php echo url_for("log_claim")?>">Log Claim</a></li>
                      <li><a href="<?php echo url_for('status')?>">Статус</a></li>
                      <li><a href="<?php echo url_for('documents')?>">documents</a></li>
                      <li><a href="<?php echo url_for('documents_claim')?>">documents_claim</a></li>
                      <li><a href="<?php echo url_for('documentstype')?>">documentstype</a></li>
            </ul>
        </div><!--menu-->
        <div class="delimiter"></div>
        
        <table width="70%" class="clear">
            <tbody>
                <tr>
                    <td width="70%" valign="top">
         
          <?php  echo $sf_content?>                  
                        
                        
                        
                        
                    </td>
                </tr>
            </tbody>
        </table>
        
        
  
  
    <div id="footer">
        <p>&copy; 1995-2010 Все права защищены ООО &laquo;<a href="http://www.griffin.ua" title="Перейти на корпоративный сайт">Импел Гриффин Груп</a>&raquo;</p>
    </div>
    </div>
<?php } else echo $sf_content;?>    
</body>
</html> 