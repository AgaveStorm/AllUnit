<?php


class TAu {
	const MANAGE = 'au-manage';
	const RELAY = 'au-relay';
	
	/**
	 * @return url that will be redirected to ullunit path inside /usr/share/php/allunit so we can include CSS and JS from core
	 * @param string $path
	 */
	static function urlRelay($path) {
		return self::RELAY."/".$path;
	}
	
	static function getRequestScheme() {
		if(isset($_SERVER['REQUEST_SCHEME'])) {
			return $_SERVER['REQUEST_SCHEME'];
		}
		if(isset($_SERVER['HTTPS'])) {
			if($_SERVER['HTTPS'] != 'off') {
				return 'https';
			}
		}
		return 'http';
	}
	
	static function getSiteUrl() {
		return self::getRequestScheme()."://".$_SERVER['SERVER_NAME'].str_replace("/index.php","",$_SERVER['PHP_SELF']);
	}
	
	static function isAjax() {
		return ( isset($_SERVER['HTTP_X_REQUESTED_WITH'])
			&& $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest');
	}
}
