<?php
require_once "vihv/interface/IRbConfig.php";
require_once 'allunit/thirdparty/redbean/rb.php';
require_once 'TMysqlConfig.php';

class TRbConfig implements IRbConfig {
	
	function getMark() {
		return 'mark';
	}

	function InitRb() {
		$config = new TMysqliConfig();
		//R::setup('sqlite:'.__DIR__.'/../data/rb.db','rbuser','rbpassword');
		R::setup('mysql:host='.$config->GetHost().';dbname='.$config->GetDbName(), 
			$config->GetUser(), 
			$config->GetPassword());
		}
		
	
}


