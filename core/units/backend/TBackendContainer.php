<?php
ini_set("include_path",ini_get("include_path").PATH_SEPARATOR.__DIR__);
require_once 'inc/control/TBkHeaderContainer.php';
require_once 'inc/control/TBkMainWrapperContainer.php';
require_once 'inc/control/TBkAjaxContainer.php';

class TBackendContainer extends TAuUnitContainer {
	
	static $instance;

	function OnCreateEvent($Sender) {
		self::$instance = $this;
//		$rbConf = TConfigManager::GetModel("IRbConfig", $this);
////		var_dump($rbConf->getMark());
//		$rbConf->InitRb();
		TCss::add(self::getUnitUrlStatic()."/css/main.css");
		TJs::add(TAu::urlRelay('allunit/thirdparty/jqueryui/js/jquery-1.10.2.js'),'jquery');
		TMeta::add('robots','none');
		$Sender->Enable();
		if(TAu::isAjax()) {
			$Sender->AddChild(new TBkAjaxContainer());
			return;
		} 
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
