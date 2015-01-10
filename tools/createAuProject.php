#!/usr/bin/php
<?php


if(empty($_SERVER['argv'])) {
	die('no direct access');
}


require_once "vihv/misc/TFile.php";

try {
	$templatepath = TFile::SearchIncludePath('allunit/templates/basic');
	$thispath = ".";
	
	TFile::CopyFolder($templatepath, $thispath);
} catch(Exception $e) {
	echo "\nError: ".$e->getMessage()."\n\n";
}

