<?php

class TQrCodeControl extends TAuUnitContainer {
	
	function getSlug() {
		return 'qrcode';
	}

	function OnCreateEvent($Sender) {
		$this->location = new TLocation($this, [$this->getSlug(),'*','*']);
	}

	function OnEnableEvent() {
		$vars = $this->location->getVars();
		$message = base64_decode(reset($vars));
		$filename = next($vars);
		require_once 'allunit/thirdparty/phpqrcode/phpqrcode.php';
		Header('Content-Disposition: attachment; filename='.$filename.'.png');
		QRcode::png($message, null, QR_ECLEVEL_L, 1, 1); //@todo magick
	}

}
