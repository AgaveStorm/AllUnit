<?php

require_once 'inc/model/TBkMenu.php';

class TBkHeaderMenuControl extends TControl {

	function OnCreateEvent($Sender) {
		TCss::add(TBackendContainer::getUnitUrlStatic()."/css/bk-header-menu.css");
		$Sender->Enable();
		$menu = new TBkMenu();
		$Sender->Data['menu'] = $menu->getMenu(); 
	}

	

}
