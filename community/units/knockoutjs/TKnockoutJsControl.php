<?php

class TKnockoutJsControl extends TAuUnitContainer {

	function OnCreateEvent($Sender) {
		TJs::add(TAu::urlRelay($this->getUnitUrl().'/knockout-3.2.0.js'),'knockoutjs');
	}

}
