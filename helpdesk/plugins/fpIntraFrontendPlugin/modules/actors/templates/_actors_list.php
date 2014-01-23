<?php foreach ($actors as $actor) :?>
  <?php 
  $companystructure = $actor->getStuff()->getCompanystructure();
/*  $regions = $companystructure->getRegion();
  $region_string = '';
  foreach ($regions as $region)
  {
      $region_string .= $region->getName()." / ";
  }*/
  $toString = " ( ".$actor->getPosition()." ) - ".$companystructure;
  echo link_to($actor, 'actors/show?id='.$actor->getId())?> <span style="font-size: 9px;"><?php echo $toString?></span><br />
<?php endforeach;?>
<?php if (!count($actors)) echo __('No results');?> 