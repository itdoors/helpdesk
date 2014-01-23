<?php


require_once(dirname(__FILE__).'/../helpdesk/config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('kurator', 'prod', false);
sfContext::createInstance($configuration)->dispatch();
