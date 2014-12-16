<?php
$Keys = array_keys($_GET);
$Name = htmlspecialchars($Keys[0]);
Header('Content-Type: text/css');
echo file_get_contents("vihv/css/".$Name.".css",true);