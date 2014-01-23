<?php


require_once(dirname(__FILE__).'/../helpdesk/config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('smeta', 'prod', false);
sfContext::createInstance($configuration)->dispatch();
