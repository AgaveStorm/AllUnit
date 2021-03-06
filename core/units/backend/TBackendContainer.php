<?php
ini_set("include_path",ini_get("include_path").PATH_SEPARATOR.__DIR__);

class TBackendContainer extends TAuUnitContainer {
	
	static $instance;

	function OnCreateEvent($Sender) {
		self::$instance = $this;
		$this->location = new TLocation($this, 'au-manage',true);
		
	}
	
	function OnEnableEvent($Sender) {
		
		require_once 'inc/control/TBkHeaderContainer.php';
		require_once 'inc/control/TBkMainWrapperContainer.php';
		require_once 'inc/control/TBkAjaxContainer.php';

		TCss::add(TAu::urlRelay('allunit/thirdparty/jqueryui/css/smoothness/jquery-ui-1.10.4.custom.min.css'));
		TCss::add(TAu::urlRelay('allunit/thirdparty/multiselect/jquery.multiselect.css'));
		TCss::add(TAu::urlRelay('allunit/thirdparty/datetimepicker/jquery.datetimepicker.css'));
		TCss::add(self::getUnitUrlStatic()."/css/main.css");
		
		TJs::add(TAu::urlRelay('allunit/thirdparty/jqueryui/js/jquery-1.10.2.js'),'jquery');
		TJs::add(TAu::urlRelay('allunit/thirdparty/jqueryui/js/jquery-ui-1.10.4.custom.min.js'),'jquery-ui',['jquery']);
		TJs::add(TAu::urlRelay('allunit/thirdparty/multiselect/src/jquery.multiselect.min.js'),'multiselect', ['jquery']);
		TJs::add(TAu::urlRelay('allunit/thirdparty/datetimepicker/jquery.datetimepicker.js'),'datetimepicker',['jquery']);
		
		TMeta::add('robots','none');
//		$Sender->Enable();
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
