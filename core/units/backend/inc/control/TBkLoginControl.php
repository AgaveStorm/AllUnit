<?php

class EBkLogin extends Exception {}

class TBkLoginControl extends TControl {

	function OnCreateEvent($Sender) {
		$Sender->SetEvent('OnLogout', array($this, 'OnLogoutEvent'));
		$Sender->SetEvent('OnLogin', array($this, 'OnLoginEvent'));
	}

	function OnGetEvent($Sender, $Input) {
		$logoutLocation = new TLocation($this, TAu::MANAGE."/logout");
		if($logoutLocation->current()) {
			$Sender->OnLogout();
		}
		if(!TAuthorizationManager::IsLogged()) {
			$list = TConfigManager::GetModel('IUsers', $this);
			$user = $list->getCurrentUser();
//			var_dump($user);
			if($user->hasBackendAccess()) {
				$Sender->Enable();
			}
		}
	}
	
	function OnEnableEvent($Sender) {
		$Sender->Data['name'] = TFormNames::create($this, ['login', 'password']);
	}

	function OnPostEvent($Sender, $Input) {
		if(!empty($Input['onBkLogin'])) {
			$Sender->OnLogin($Input);
		}
	}
	
	function OnLoginEvent($Sender, $Input) {
		$Input = TFormNames::decodeInput($this, $Input);
		$list = TConfigManager::GetModel('IUsers', $this);
//		var_dump($list);
		$user = $list->getUserByLoginAndPassword($Input['login'], $Input['password']);
		if(empty($user)) {
			throw new EBkLogin('Wrong login or password');
		}
		if(!$user->hasBackendAccess()) { 
			throw new EbkLogin('Not enough mana');
		}
		$list->setCurrentUser($user);
	}

	function OnLogoutEvent($Sender, $Input) {
		TAuthorizationManager::DropUniqueId();
		Header("Location: ".TAu::getSiteUrl()."/".TAu::MANAGE);
		exit;
	}
}
