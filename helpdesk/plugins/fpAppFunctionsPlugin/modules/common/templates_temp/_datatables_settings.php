            <?php 
            $date_sorting = isset($date_sorting) ? $date_sorting->getRawValue() : null;
            $app = sfContext::getInstance()->getConfiguration()->getApplication();
            $module = sfContext::getInstance()->getModuleName();
            ?>
            "aaSorting": [[ 1, 'desc' ]],
            "sDom": 'l<?php if ($app != 'client'):?>f<?php endif;?>r<"giveHeight"t>ip',
            "bPaginate": false,
            "bLengthChange": false,
            "bFilter": true,
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": false,
            "bStateSave": true
            <?php if ($date_sorting):?>
              ,"aoColumns": [
              <?php for ($i = 0; $i < $date_sorting['columns_count']; $i++):?>
                <?php if (in_array($i, $date_sorting['sort_columns'])):?>
                { "sType": "eu_date" }
                <?php else:?>
                null 
                <?php endif;?>
                <?php if ($i < $date_sorting['columns_count']-1) : ?>,<?php endif;?>
              <?php endfor;?>
              ]
            <?php endif; ?> 