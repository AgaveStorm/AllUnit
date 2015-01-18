<?php

class TTinyMceControl extends TAuUnitContainer {

	function OnCreateEvent($Sender) {
		TJs::add(TAu::urlRelay($this->getUnitUrl().'/js/init.js'),'init-tinymce',['tinymce']);
		TJs::add(TAu::urlRelay($this->getUnitUrl().'/tinymce/tinymce.min.js'),'tinymce');		
	}


	function allowBackend() {
		return true;
	}
	
	
}
