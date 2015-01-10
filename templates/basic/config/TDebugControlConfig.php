<?php

/**
 * Description of TDebugControlConfig
 *
 * @author Vigorous Hive
 */
class TDebugControlConfig {
	function IsEnabled() { 
		$options = new TAuOptions();
		$option = $options->getOption('developersEye');
		return $option == 1;
	}
}

