<?php

class TUnitManagementContainer extends TAuUnitContainer {

	function OnCreateEvent($Sender) {
		new TLocation($this, TAu::MANAGE.'/units');
		new TLocation($this, TAu::MANAGE.'/units/unitmanagement');
	}
	
	function OnEnableEvent($Sender) {
		ini_set("include_path",ini_get("include_path").PATH_SEPARATOR.__DIR__);
		require_once "inc/control/TUnitListControl.php";
		TCss::add(TAu::urlRelay($this->getUnitUrl()."/css/main.css"));
		TJs::add(TAu::urlRelay($this->getUnitUrl()."/js/unitmanagement.js"),'unitmanagement',['jquery']);
		$Sender->AddChild(new TUnitListControl());

	}

	function OnGetEvent($Sender, $Input) {
		
	}

	function OnPostEvent($Sender, $Input) {
		
	}

//	static function getUnitUrlStatic() {
//		return TAu::urlRelay(self::$instance->getUnitUrl()); 
//	}
}
