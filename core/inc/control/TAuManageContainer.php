<?php

require_once 'allunit/core/inc/model/TUnits.php';


class TAuManageContainer extends TContainer {

	function OnCreateEvent($Sender){
		$Sender->myLocation = new TLocation($Sender,TAu::MANAGE,TLocation::INCLUDE_CHILDREN);
		if($Sender->myLocation->current()) {
			$Sender->Enable();
		}
	}
	
	function OnEnableEvent($Sender){
		$list = TUnits::getInstance();
		$allUnits = $list->getAll();
		$units = $list->getActiveUnits();
		foreach($units as $control) {
			if($control->getLevel() == TUnits::LEVEL_CORE
				|| $control->allowBackend()
				) {
				$control->create();
				if(TLocations::controlEnabled($control)
					&& !$control->IsEnabled() ) {
						$control->enableDependencies($allUnits);
						$control->Enable();
				}
				
				$Sender->AddChild($control);
			}
		}
	}

	public function GetTemplate() {
		return 'allunit/core/design/TAuManageContainer.xsl';
	}

}
