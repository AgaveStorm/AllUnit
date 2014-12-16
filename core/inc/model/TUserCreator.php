<?php

require_once 'allunit/core/interface/IUserCreator.php';
require_once 'TUsers.php';

class TUserCreator implements IUserCreator {
	
	private $login;
	private $password;
	private $group;
	
	public function setLogin($login){
		$this->login = $login;
	}
	public function setPassword($password){
		$this->password = $password;
	}
	public function setGroup($group){
		$this->group = $group;
	}
	
	public function createUser(){
		$list = new TUsers();
		$user = $list->create([
			'login' => $this->login,
			'password' => sha1($this->password),
			'group' => $this->group
		]);
		$user->save();
	}
}
