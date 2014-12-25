<?php


ini_set("include_path",ini_get("include_path").":".__DIR__);

class TSampleUnitContainer extends TAuUnitContainer {
	
	static $instance;
	
	function OnCreateEvent($Sender) {
		
		self::$instance = $this;		
		/*
		 * use $Sender->AddChild( control or container object );
		 * to add child controls here
		 */
		
		$Sender->Enable();
	}
	
	function OnEnableEvent($Sender) {
		/*
		 * add some css, js and meta with
		 * TCss::add(path, slug);
		 * TJs::add(path, slug, array(dependencies));
		 * TMeta::add(name, value); like TMeta('keywords', 'allunit, framework');
		 * 
		 * you can also add more css,js and meta in child controls or anywhare else
		 */
	}
	
	/**
	 * we need this function for child controls to have access to unit path
	 */
	static function getUnitUrlStatic() {
		return self::$instance->getUnitUrl(); 
	}
}
