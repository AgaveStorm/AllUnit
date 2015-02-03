<?php

require_once 'vihv/control/Core/TDebugControl.php';
require_once 'allunit/core/inc/model/TAu.php';
require_once 'TAuHeadControl.php';
require_once 'TAuFooterControl.php';
require_once 'TAuUnitsContainer.php';
require_once 'TAuUnitContainer.php';
require_once 'TAuManageContainer.php';
require_once 'allunit/core/inc/model/TLocations.php';
require_once 'allunit/core/inc/model/TFormNames.php';
require_once "allunit/core/inc/fields/TAuFields.php";


/**
 * initialize units
 */
class TAllUnitControl extends TContainer {

	public function OnCreateEvent($Sender) {
		$list = TUnits::getInstance();
		$list->initUnits();
		if(!TAu::isAjax()) {
			$Sender->AddChild(new TAuHeadControl());
		}
		$manageContainer = new TAuManageContainer();
		if($manageContainer->myLocation->current()) {
			$Sender->AddChild($manageContainer);
		} else {
			$Sender->AddChild(new TAuUnitsContainer());
		}
		$Sender->AddChild(new TAuFooterControl());
		
		/* this is for debugging purposes, this control can be disabled 
		 * in config/TDebugControlConfig.php
		 * 
		 * this is "Developer eye" in right bottom corner.
		 * Debug control will show information about all controls used
		 * in this application
		 */
		$Sender->AddChild(new TDebugControl(),'Debug');
	}
	
	public function GetTemplate() {
		return 'allunit/core/design/TAllUnitControl.xsl';
	}
	
	function OnRootTemplateLoadEvent($Sender, $DOM) {
		parent::OnRootTemplateLoadEvent($Sender, $DOM);
		foreach(TAuFields::getList() as $field) {
			$Sender->AppendChildTemplate($field, $DOM);
		}
	}
	

}
