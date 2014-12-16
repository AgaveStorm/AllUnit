<?php

class TCryptoJsControl extends TAuUnitContainer {

	function OnCreateEvent($Sender) {
		TJs::add(TAu::urlRelay('allunit'.$this->getUnitUrl().'/sha1.js'),'cryptojs');
	}

}
