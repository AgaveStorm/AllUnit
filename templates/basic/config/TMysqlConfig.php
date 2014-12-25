<?php

require_once "vihv/interface/IMysqlConfig.php";

class TMysqliConfig implements IMysqlConfig {
	function GetDbName() { return "dbname";}
	function GetHost() {return "localhost"; }
	function GetUser() {return "dbuser"; }
	function GetPassword() {return "dbpassword"; }
	function GetCharset() {return "utf8";}
	}

