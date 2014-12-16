<?php
require_once 'allunit/core/interface/IUsers.php';
require_once 'allunit/core/inc/model/TList.php';
require_once 'TUser.php';

class TUsers extends TList implements IUsers {
	public function getSingleModelName() {
		return 'TUser';
	}

	public function getCurrentUser() {
		$id = TAuthorizationManager::GetUniqueId();
		return $this->getOne($id);
	}
	
	public function setCurrentUser(IUser $user) {
		TAuthorizationManager::SetUniqueId($user->getId());
	}

	public function hasBackendAccess() {
		return false;
	}
	

	public function getUserByLoginAndPassword($login, $password) {
		$bean = R::findOne($this->getBeanType(), " login='".$login."' AND password=sha1('".$password."')");
		if(empty($bean)) {
			return NULL;
		}
		return new TUser($bean);
	}

}
