<?php

include_once('../plugins.php');
include_once('../modules.php');
include_once('../framework/Loader.php');
spl_autoload_register('\kjBot\Framework\Loader::autoload');


$Config = parse_ini_file('../config.ini');
