                <li ><a href="<?php echo url_for('claimopened')?>"><?php echo __('Open claims') ?> </a></li>
                <li><a href="<?php echo url_for('claimclosed')?>"><?php echo __('Close claims') ?></a></li>
                <?php if ($sf_user->hasCredential('superkurator')):?>
                  <li><a href="<?php echo url_for('claimopened/new')?>"><?php echo __('Create claim')?></a></li>
                  <li><a href="<?php echo url_for('claimopened/newonce')?>" class="page_loader_link"><?php echo __('Create once claim')?></a></li>
                <?php endif;?>    
                <li><a href="<?php echo url_for('changepass')?>"><?php echo __('Change password') ?></a></li>
                <li><a href="<?php echo url_for('reports/index')?>"><?php echo __('Reports') ?></a></li>
                <li><a href="http://intranet.griffin.ua"><?php echo __('Intranet') ?></a></li>