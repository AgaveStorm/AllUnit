<?php

require_once 'allunit/core/inc/model/TMenu.php';

class TBkMenu extends TMenu {
	
	function __construct() {
		parent::__construct('bkmenu','Backend Menu');
		
		$this->add(new TMenuItem(TAu::MANAGE.'/site', '<i class="fa fa-gears"></i> Site Options'));
		$this->add(new TMenuItem(TAu::MANAGE.'/menus', '<i class="fa fa-sitemap"></i> Menus'));
		$this->add(new TMenuItem(TAu::MANAGE.'/content', '<i class="fa fa-table"></i> Content'));
		$this->add(new TMenuItem('', '<i class="fa fa-level-up"></i> Frontend'));
		$this->add(new TMenuItem(TAu::MANAGE.'/logout', '<i class="fa fa-sign-out"></i> Logout'));
		
	}
	
}
