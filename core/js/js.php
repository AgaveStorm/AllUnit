<?php
/**
 * use css rule
 * \@import('css.php?FilenameWithoutExtension'); in main css to get css rules from library
 */
$Keys = array_keys($_GET);
$Name = htmlspecialchars($Keys[0]);
Header('Content-Type: text/javascript');
echo file_get_contents("vihv/js/".$Name.".js",true);