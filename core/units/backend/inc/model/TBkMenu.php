<?php

require_once 'allunit/core/inc/model/TMenu.php';

class TBkMenu extends TMenu {
	
	function __construct() {
		parent::__construct('bkmenu','Backend Menu');
		
		$this->add(new TMenuItem(TAu::MANAGE.'/site', 'Site Options'));
		$this->add(new TMenuItem(TAu::MANAGE.'/menus', 'Menus'));
		$this->add(new TMenuItem(TAu::MANAGE.'/content', 'Content'));
		$this->add(new TMenuItem(TAu::MANAGE.'/logout', 'Logout'));
		
	}
	
}
