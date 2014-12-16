<?php

interface IUsers {
	/**
	 * @return IUser object that represent current user
	 */
	public function getCurrentUser();
	
	/**
	 * @return IUser object that represent user with specified login/password pair
	 */
	public function getUserByLoginAndPassword($login, $password);
	
	public function setCurrentUser(IUser $user);
}