<?php

function renderPage() {
	$page = "index";
	if (isset($_GET['p'])) {
		$page = $_GET['p'];
	}
	
	$path = 'pages/' . $page . '.php';
	if (!file_exists($path)) {
		$path = 'pages/index.php';
	}
	
	executePage($path);
}


function executePage($path) {
	$result = tryCacheIfExists($path);
	if ($result === false) {
		$result = createAndExecuteCache($path);
	}
	
	return $result;
}

/** Create a path to a cache file based on the last time it was edited and the path of file. 
    It does not check if the file actually exists. */
function getCachePath($path) {
	$fileLastChanged = filemtime($path);
	$cachePath = 'page-cache/' . sha1($fileLastChanged . $path) . '.php';
	return $cachePath;
}

/** Executes the provided path and returns whatever results it got when executing it. */
function executeCache($cachePath) {
	ob_start();
	include $cachePath;
	return ob_get_flush();
}

/** Checks if a cache file exists for the provided path
    and executes it if it does. 
	Returns the results of the executed cache file if it exists, false otherwise. */
function tryCacheIfExists($path) {
	// Get the path to which the cache should point to.
	$cachePath = getCachePath($path);
	
	// Don't try to execute the file if it doesn't exist.
	if (!file_exists($cachePath)) {
		return false;
	}
	
	// Get the results of the cached file and return the results.
	return executeCache($cachePath);
}


/** Creates a cache file for the provided path and executes it. */
function createAndExecuteCache($path) {
	// Retrieve the contents of the php file.
	$content = file_get_contents($path);
	
	// Create a safe way to echo data
	$adjustedContent = preg_replace("/\{\{(.*?)\}\}/i", "<?= htmlentities($1) ?>", $content);
	
	// Get the path where we will write the results.
	$cachePath = getCachePath($path);
	
	// Put the results in a cache file.
	file_put_contents($cachePath, $adjustedContent);
	
	// ToDo: It's inefficient to write to the path and 
	// read immediately afterwards. Perhaps we can execute from memory?
	return executeCache($cachePath);
}