<?php

// This is default autoload.php. It can be overwritten by Composer.

if (!is_file(__DIR__ . '/Nette/loader.php')) {
	echo("Nette Framework is expected in directory '" . __DIR__ . "/Nette' but not found. Check if the path is correct or edit file '" . __FILE__ . "'.");
	exit(1);
}

require __DIR__ . '/Nette/loader.php';
