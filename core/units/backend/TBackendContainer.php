<?php
ini_set("include_path",ini_get("include_path").":".__DIR__);
require_once 'inc/control/TBkHeaderContainer.php';
require_once 'inc/control/TBkMainWrapperContainer.php';

class TBackendContainer extends TAuUnitContainer {
	
	static $instance;

	function OnCreateEvent($Sender) {
		self::$instance = $this;
//		$rbConf = TConfigManager::GetModel("IRbConfig", $this);
////		var_dump($rbConf->getMark());
//		$rbConf->InitRb();
		TCss::add(self::getUnitUrlStatic()."/css/main.css");
		TMeta::add('robots','none');
		$Sender->Enable();
		$Sender->AddChild(new TBkHeaderContainer());
		$Sender->AddChild(new TBkMainWrapperContainer());
	}

	function OnGetEvent($Sender, $Input) {
		
	}

	function OnPostEvent($Sender, $Input) {
		
	}
	
	static function getUnitUrlStatic() {
		return TAu::urlRelay(self::$instance->getUnitUrl()); 
	}

}
