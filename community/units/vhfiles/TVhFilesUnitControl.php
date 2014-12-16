<?php

class TVhFilesUnitControl extends TAuUnitContainer {

	function OnCreateEvent($Sender) {
		TJs::add(TAu::urlRelay('vihv/project/vhfiles/vhajax.js'),'vhajax');
		TJs::add(TAu::urlRelay('vihv/project/vhfiles/vhfiles.js'),'vhfiles',['vhajax']);
		TCss::add(TAu::urlRelay('vihv/project/vhfiles/vhfiles.css'));
		$this->location = new TLocation($this, 'vhfiles');
	}
	
	function OnGetEvent($Sender, $Input) {
		if(!$Sender->IsEnabled()) {
			return;
		}
		
		require_once "vhfiles.php";
	}

}
