<?php

require_once 'allunit/core/interface/IUser.php';
require_once 'allunit/core/inc/model/TSingle.php';

class TUser extends TSingle implements IUser{
	public function getBeanType() {
		return 'user';
	}

	public function getFields() {
		return [
		    ['name'=>'login'],
		    ['name'=>'password', 'type'=>'password'],
		    ['name'=>'group']
		];
	}

	public function hasBackendAccess() {
		return true;
	}

}
