<?php
/**
Default behaviour
you can include this file in vhfiles.php in you document root (just use require_once "vihv/product/vhfiles/vhfiles.php")
or you can create you own vhfiles.php script based on this one.

You might need to change Theme, Model and Acl config and engines, see below. 
We dont recomend to make changes in this file, please create a copy and place it in document root of your server.
*/
//trigger_error("here1",E_NOTICE);

define("VHFILES_PATH","vihv/project/vhfiles");
require_once "vihv/includeAll.php";
require_once VHFILES_PATH."/control/TVhFilesControl.php";
//require_once "vihv/control/TExceptionControl.php";

/**
setting Acl implementation
*/
//require_once "vihv/acl/TXmlAcl.php";

/**
setting Theme implementation
*/
//require_once "vihv/theme/TXmlTheme.php";

/**
setting Model configurator implementation
*/
//require_once "vihv/config/TXmlModelConfig.php";
//session_start();
try {
/**
See ITheme. Here we create a Theme manager object, and pass path to configuration file to it.
\li If you want to chene visual desing of vhfiles, point to different configuration file
\li If you want to use another engine to determine what XSLT template use for each control, create object of a custom type (it should implement ITheme interface)
\li If you dont want to use XSLT go deeper, ignore SetTheme, but use $Control->GetData() (this return you a associative array, to be used in php-based template engines) or $Control->GetXml() (this will return all data in Xml Format)
*/
//TConfigManager::SetTheme(new TXmlTheme(VHFILES_PATH.'/config/Theme.xml'));

/**
See IModelConfig. Here we create a Model Configurator object, and pass config filename as a parameter.
Model Configurator is needed to determine which model to use for each interface. Also it sets cofiguration parameters for each model. 
By default, we use 2 models here, see vihv/product/vhfiles/config/Model.xml for details.
*/
//TConfigManager::SetModelConfig(new TXmlModelConfig('config/Model.xml'));

/**
See IAcl. Here we create Acl object, and pass config filename as a parameter.
\li in config you can set which of your users can perform any acions - viewing files, adding, changing or removing.
\li you might want to switch to different acl engine if you want to use vhfiles in non vihvlcc based project. Just implement IAcl then. Use TVhFilesControl as a resource, and OnAdd, OnRemove, OnChange as actions.
*/
//TEventManager::SetAcl(new TXmlAcl("config/Acl.xml"));
	}
catch(Exception $e) {
	echo $e;
	//trigger_error("here");
	}
try {
	define('SELF_URL',TAu::getSiteUrl()."/vhfiles");
	/**
	here we create a control which will do all the work
	*/
	$Control = new TVhFilesControl();
	//trigger_error("here1");
	/**
	running events (react on post and get requests)
	*/
	TEventManager::DoEvents();
	/**
	Create HTML page and display it
	\li change this to $Control->GetData() to get associative array to be used in non XSLT template engines. You shoud create you own templates in this case.
	\li change this to $Control->Getml() to get all data in Xml format.
	*/
	echo $Control->GetHtml();
	}
catch(Exception $e) {
	/**
	If an exception occurs we should show it to the user.
	*/
	//trigger_error("here1");
	try {
	$Control = new TExceptionControl();
	$Control->SetException($e);
	echo $Control->GetHtml();
		}
	catch(Exception $e) {
		echo "Exception in TExceptionControl ".$e;
		//trigger_error("here2");
		}
	} 
exit;