<?php

require_once 'allunit/core/inc/model/TUnits.php';

class TAuUnitsContainer extends TContainer {

	function OnCreateEvent($Sender) {
		$Sender->Enable();
		$list = TUnits::getInstance();
		$units = $list->getActiveUnits();
		foreach($units as $control) {
//			if($control->getLevel() != TUnits::LEVEL_CORE) {
				$control->create();
//				var_dump(get_class($control));
				if(TLocations::controlEnabled($control)
					&& !$control->IsEnabled() ) {
//						var_dump($control);
						$control->enableDependencies($units);
						$control->Enable();
//						var_dump(get_class($control));

				}
				$Sender->AddChild($control);
//			}
		}
		//var_dump($Sender->Children[3]);
	}

	public function GetTemplate() {
		return 'allunit/core/design/TAuUnitsContainer.xsl';
	}

}
