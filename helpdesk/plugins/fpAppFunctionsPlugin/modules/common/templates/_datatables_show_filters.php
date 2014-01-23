<?php
/** @var sfOutputEscaperArrayDecorator $filters_data*/
if (isset($filters_data))
{
  $filters_data = $filters_data->getRawValue();
}

foreach ($filters as $key => $value):?>
    <div class="filter_outer">
    <?php 
    echo __($value)?>: 
        <div class="<?php echo "filter$key"?>">
        <?php /*
        if (!empty($filters_data) && isset($filters_data[0][$value])):?>
          <?php
          $data = $filters_data[0][$value]?>
          <select>
            <option></option>
            <?php foreach (explode('-*;*-',$data) as $rec):?>
              <option value="<?php echo $rec?>"><?php echo $rec?></option>
            <?php endforeach;?>
          </select>
        <?php endif;*/?>
        </div>
    </div>
    
<?php endforeach;?> 
<?php if (count($filters)):?>
<div class="filter_outer"><br /><input type="button" value="<?php echo __('Clear filter')?>" id="clear_filter"></div>  
<?php endif;?>