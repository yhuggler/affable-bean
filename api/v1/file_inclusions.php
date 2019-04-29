<?php
	// To prevent repetitive programming, this function includes a whole folder at once.
	function loadDirectory($directory) {
		foreach (glob($directory . "/*.php") as $filename) {
			include_once $filename;
		}
	}

	$dirs = array_filter(glob('*'), 'is_dir');

	foreach ($dirs as $dir) {
		if(!($dir == "vendor" || $dir == "Libraries")) {
			loadDirectory($dir);
		}
	}
?>
