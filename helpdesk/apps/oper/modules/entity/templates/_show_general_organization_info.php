<?php if ($organization):?>
<div>
  p/c:<?php echo $organization->getRs()?><br />
  ЭДРПОУ:<?php echo $organization->getEdrpou()?><br />
  ИНН:<?php echo $organization->getInn()?><br />
  Свидетельство:<?php echo $organization->getCertificate()?><br />
  Адрес:<?php echo $organization->getAddress()?><br />
</div>
<?php endif;?>
