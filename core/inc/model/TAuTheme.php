<?php

require_once "vihv/interface/ITheme.php";

class TAuTheme implements ITheme {
	public function GetTemplate($ControlClassName) {
		$units = TUnits::getInstance();
		$theme = $units->getTheme();
		//var_dump($ControlClassName);
		foreach($theme as $item) {
			if(!empty($item['theme']->$ControlClassName)) {
				$filename = TFile::SearchIncludePath($item['theme']->$ControlClassName);
				if(empty($filename)) {
					$filename = $item['path'].'/'.$item['theme']->$ControlClassName;
				}
				if(!file_exists($filename)) {
					throw new EAuTheme('Template file '.$filename.' not found');
				}
				return $filename;
			}
		}
		throw new EAuTheme('Template for '.$ControlClassName.' not found, check info.json');
	}
}

class EAuTheme extends Exception {}