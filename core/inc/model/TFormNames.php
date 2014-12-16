<?php


class TFormNames {
	
	function clear($control) {
		$_SESSION[get_class()][get_class($control)]['names'] = [];
		$_SESSION[get_class()][get_class($control)]['hashBacks'] = [];
	}
	
	function create($control,$names) {
		self::clear($control);
		foreach($names as $name) {
			$rand = sha1($name.session_id().str_shuffle('qwertyiopasdfghjklzxcvbnm').time());
			$_SESSION[get_class()][get_class($control)]['names'][$name] = $rand;
			$_SESSION[get_class()][get_class($control)]['hashBacks'][$rand] = $name;
		}
		return $_SESSION[get_class()][get_class($control)]['names'];
	}
	
	function get($control,$hash) {
		return $_SESSION[get_class()][get_class($control)]['hashBacks'][$hash];
	}
	
	function decodeInput($control,$Input) {
		$Decoded = [];
		foreach($_SESSION[get_class()][get_class($control)]['names'] as $name=>$hash) {
			$Decoded[$name] = $Input[$hash];
		}
		//var_dump($Decoded);
		self::clear($control);
		return $Decoded;
	}
}
