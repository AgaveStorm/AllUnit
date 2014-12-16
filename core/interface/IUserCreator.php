<?php


interface IUserCreator {
	public function setLogin($login);
	public function setPassword($password);
	public function setGroup($group);
	
	public function createUser();
}
