<?php


require_once(dirname(__FILE__).'/../helpdesk/config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('stuff', 'prod', false);
//$configuration = ProjectConfiguration::getApplicationConfiguration('stuff', 'dev', true);
sfContext::createInstance($configuration)->dispatch();
