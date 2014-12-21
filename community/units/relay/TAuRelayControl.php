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
		$pathinfo = pathinfo($fileName);
//		var_dump($pathinfo);
		$ext = TFile::GetExtension($fileName);
		if(!in_array($ext, $this->getAcceptableExtensions())) {
			throw new ERelay('Inacceptible!');
		}
		if($ext == 'min') {
			$files = explode(";",$_SERVER['QUERY_STRING']);
			$content = '';
			foreach($files as $file) {
				if(!in_array(TFile::GetExtension($file), $this->getAcceptableExtensions())) {
					throw new ERelay('Inacceptible!');
				}
				$fileWithPath = $pathinfo["dirname"]."/".$file;
				$path = TFile::SearchIncludePath($fileWithPath);
				$content .= "\n".file_get_contents($path);
			}
			$mime = 'text/'.$pathinfo['filename'];
			if($pathinfo['filename'] == 'js') {
				$mime = 'text/javascript';
			}
			Header('Content-Type: '.$mime);
			echo $content;
			exit;
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
		return ['css','js','png','jpg','ttf','eot','woff','svg','min'];
	}

}
