          <div id="logo">
                <a href="<?php  echo url_for('@default')?>" title=""><img src="/img/logo.jpg" alt="" /></a>
                <?php //todo 5: ?>
            </div>
            <div id="links">
               <a href="http://www.griffin.ua" target="_blank">www.griffin.ua</a> <br />
              Service-Desk: (067) 404-00-<span style="display:none">_</span>70 <br />
               <p><?php echo __('Support')?>: (093) 356-36-<span style="display:none">_</span>26</p>  
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
                    <a href="<?php echo url_for('logout')?>" title="" class="red"><?php echo __('Logout')?></a><br />
                    <?php //echo get_component('ui','session_timeout')?>
                </div>
    
            </div>