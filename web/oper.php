<?php

ini_set('memory_limit', '2047M');
require_once(dirname(__FILE__).'/../helpdesk/config/ProjectConfiguration.class.php');

//$configuration = ProjectConfiguration::getApplicationConfiguration('oper', 'dev', false);
$configuration = ProjectConfiguration::getApplicationConfiguration('oper', 'dev', true);
sfContext::createInstance($configuration)->dispatch();

