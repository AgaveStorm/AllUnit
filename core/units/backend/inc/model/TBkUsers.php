<?php

require_once 'TBkUser.php';

require_once 'allunit/core/interface/IUsers.php';

class TBkUsers extends TList implements IUsers{
	
	public function getCurrentUser() {
		$id = TAuthorizationManager::GetUniqueId();
		return $this->getOne($id);
	}

	public function hasBackendAccess() {
		
	}

	public function getSingleModelName() {
		return 'TBkUser';
	}
	
	public function getUserByLoginAndPassword($login, $password) {
		$bean = R::findOne($this->getBeanType(), "login='".$login."' AND password=sha1('".$password."')");
		if(empty($bean)) {
			return NULL;
		}
		return $bean->getId();
	}

}
