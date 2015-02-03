<?php

require_once 'allunit/core/inc/model/TCss.php';
require_once 'allunit/core/inc/model/TJs.php';
require_once 'allunit/core/inc/model/TMeta.php';
require_once 'allunit/core/inc/model/TAuOptions.php';

class TAuHeadControl extends TControl {

	function OnCreateEvent($Sender) {
		$Sender->Enable();
	}
	
	function OnBeforeDisplayEvent($Sender) {
		$list = new TAuOptions();
//		var_dump($list->getOption('minifyCss'));
		if($list->getOption('minifyCss')) {
			$Sender->Data['css'] = TCss::getMinified();
		} else {
			$Sender->Data['css'] = TCss::getAll();
		}
		if($list->getOption('minifyJs')) {
			$Sender->Data['js'] = TJs::getMinified();
		} else {
			$Sender->Data['js'] = TJs::getAll();
		}
		$Sender->Data['meta'] = TMeta::getAll();
		
		$options = $list->getAll();
		foreach($options as $option) {
			$Sender->Data['option'][$option->get('name')] = $option->get('value'); 
		}
	}

	function GetTemplate() {
		return 'allunit/core/design/TAuHeadControl.xsl';
	}

}
