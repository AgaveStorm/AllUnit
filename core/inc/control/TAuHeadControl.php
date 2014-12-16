<?php

require_once 'allunit/core/inc/model/TCss.php';
require_once 'allunit/core/inc/model/TJs.php';
require_once 'allunit/core/inc/model/TMeta.php';

class TAuHeadControl extends TControl {

	function OnCreateEvent($Sender) {
		$Sender->Enable();
	}
	
	function OnBeforeDisplayEvent($Sender) {
		$Sender->Data['css'] = TCss::getAll();
		$Sender->Data['js'] = TJs::getAll();
		$Sender->Data['meta'] = TMeta::getAll();
		$list = new TAuOptions();
		$options = $list->getAll();
		foreach($options as $option) {
			$Sender->Data['option'][$option->get('name')] = $option->get('value'); 
		}
	}

	function GetTemplate() {
		return 'allunit/core/design/TAuHeadControl.xsl';
	}

}
