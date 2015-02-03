<?php



class TWelcomeContainer extends TAuUnitContainer {
	
	static $instance;

	function OnCreateEvent($Sender) {
		self::$instance = $this;
		$this->location = new TLocation($this,'',true);
	}
	
	function OnEnableEvent($Sender) {
		
		$list = new TActiveUnits();
		$activated = $list->getActiveSlugs();
		if(!empty($activated)) {
			$Sender->Disable();
			return;
		}
		ini_set("include_path",ini_get("include_path").PATH_SEPARATOR.__DIR__);
		require_once 'inc/control/TWlkCreateUser.php';
		require_once 'inc/control/TWlkNavigateAuManage.php';
		
		TCss::add(self::getUnitUrlStatic()."/css/main.css");
		TMeta::add('robots','none');
		
		$users = TConfigManager::GetModel('IUsers');
		$items = $users->getList([]);
//		var_dump($items);
		if($users->getTotal() == 0) {
			$Sender->AddChild(new TWlkCreateUser());
		}
		if($users->getTotal() > 0) {
			$Sender->AddChild(new TWlkNavigateAuManage());
		}
	}

	function OnGetEvent($Sender, $Input) {
		
	}

	function OnPostEvent($Sender, $Input) {
		
	}
	
	static function getUnitUrlStatic() {
		return TAu::urlRelay(self::$instance->getUnitUrl()); 
	}

}
