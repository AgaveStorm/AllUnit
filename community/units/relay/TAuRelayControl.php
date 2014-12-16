<?php

class ERelay extends Exception {}

class TAuRelayControl extends TAuUnitContainer {

	function OnCreateEvent($Sender) {
		$this->location = new TLocation($this, TAu::RELAY, true);
	}

	function OnEnableEvent($Sender) {
		$v = str_replace("/index.php",'',$_SERVER['PHP_SELF']);
		$fileName = substr($_SERVER['REQUEST_URI'], strlen($v."/".TAu::RELAY."/"));
		$exploded = explode('?',$fileName);
		if(!empty($exploded)) {
			$fileName = reset($exploded);
		}
		$ext = TFile::GetExtension($fileName);
		if(!in_array($ext, $this->getAcceptableExtensions())) {
			throw new ERelay('Inacceptible!');
		}
		
		$mime = 'text/'.$ext;
		if($ext == 'js') {
			$mime = 'text/javascript';
		}
		
		$path = TFile::SearchIncludePath($fileName);
		Header('Content-Type: '.$mime);
		//echo str_replace('@auUrl',TAu::getSiteUrl()."/".TAu::urlRelay('allunit/core'),file_get_contents($path));
		echo file_get_contents($path);
		exit;
	}
	
	function getAcceptableExtensions() {
		return ['css','js','png','jpg','ttf','eot','woff','svg'];
	}

}
