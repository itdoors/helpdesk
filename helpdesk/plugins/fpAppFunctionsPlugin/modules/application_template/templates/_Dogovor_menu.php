                <li ><a href="<?php echo url_for('dogovor/index')?>">Договора </a></li>
                <li ><a href="<?php echo url_for('dogovor/prolongation')?>"><?php echo __('Prolongation dogovors')?></a></li>
                <?php if ($sf_user->hasCredential('dogovoradmin')) : ?>
                <li ><a href="<?php echo url_for('organization/index')?>">Организации </a></li>
                <?php endif;?>
                <li><a href="http://intranet.griffin.ua"><?php echo __('Intranet') ?></a></li>
