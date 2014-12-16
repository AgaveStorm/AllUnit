<?php

class TSite {
	
	static $instance;
	
	private $siteurl;
		
	function getInstance() {
		if(empty(self::$instance)) {
			self::$instance = new TSite();
		}
		return self::$instance;
	}

	function getSiteUrl() {
		return self::getInstance()->siteurl;
	}
	function setSiteUrl($url) {
		self::getInstance()->siteurl = $url;
	}
	
}