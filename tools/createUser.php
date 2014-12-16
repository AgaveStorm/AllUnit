#!/usr/bin/php
<?php
//error_reporting(E_ERROR);
ini_set("include_path",ini_get("include_path").":".__DIR__);
require_once "vihv/includeAll.php";
require_once "allunit/core/inc/control/TAllUnitControl.php";
require_once "vihv/control/TExceptionControl.php";
require_once "vihv/acl/TNoAcl.php";
require_once "allunit/core/inc/model/TAuTheme.php";
require_once "vihv/config/TXmlModelConfig.php";
session_start();
TConfigManager::SetTheme(new TAuTheme());
TConfigManager::SetModelConfig(new TXmlModelConfig('config/Model.xml'));
//TEventManager::SetAcl(new TXmlAcl("config/Acl.xml"));
TEventManager::SetAcl(new TNoAcl());

if(empty($_SERVER['argv'])) {
	die('no direct access');
}

if($_SERVER['argc'] < 4) {
	echo "
Usage:
	(cd to your project root first)
	createAuUser <login> <password> <group>
Example:
	createAuUser admin secret root
";
	exit;
}
$rbconf = TConfigManager::GetModel('IRbConfig');
$rbconf->InitRb();
$creator = TConfigManager::GetModel('IUserCreator');

$creator->setLogin($_SERVER['argv'][1]);
$creator->setPassword($_SERVER['argv'][2]);
$creator->setGroup($_SERVER['argv'][3]);

$creator->createUser();