<?php
/**
Sample Component Demo
*/
ini_set("include_path",ini_get("include_path").":".__DIR__);
require_once "vihv/includeAll.php";
require_once "core/inc/control/TAllUnitControl.php";
require_once "vihv/control/TExceptionControl.php";
require_once "vihv/acl/TNoAcl.php";
require_once "core/inc/model/TAuTheme.php";
require_once "vihv/config/TXmlModelConfig.php";
session_start();
TConfigManager::SetTheme(new TAuTheme());
TConfigManager::SetModelConfig(new TXmlModelConfig('config/Model.xml'));
//TEventManager::SetAcl(new TXmlAcl("config/Acl.xml"));
TEventManager::SetAcl(new TNoAcl());

$siteurl = $_SERVER['REQUEST_SCHEME']."://".$_SERVER['SERVER_NAME'].str_replace("/index.php","",$_SERVER['PHP_SELF']);
try {
	//TEventManager::SetAcl(new TXmlAcl());
	$Control = new TAllUnitControl();
	$Control->Data['siteurl'] = $siteurl;
	
	TEventManager::DoEvents();
	//echo "<pre>".htmlspecialchars($Control->GetXml())."</pre>";
	header("HTTP/1.0 200 Ok");
	echo "<!DOCTYPE html>";
	echo $Control->GetHtml();
	}
catch(Exception $e) {
	$Control = new TExceptionControl();
	$Control->Data['siteurl'] = $siteurl;
	$Control->SetException($e);
	echo $Control->GetHtml();
	} 