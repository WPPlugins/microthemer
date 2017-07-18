<?php
// Include scss script here as 'use' can't be used in function
$path = dirname(__FILE__);

// normalise windows paths to forward slashes //
function tvr_normalize_path( $path ) {
	$path = str_replace( '\\', '/', $path );
	$path = preg_replace( '|(?<=.)/+|', '/', $path );
	if ( ':' === substr( $path, 1, 1 ) ) {
		$path = ucfirst( $path );
	}
	return $path;
}

//include 'php5.4_plus/scss.inc.php'; // phpscss has it's own PHP version check
include 'scssphp-jan-2017/scss.inc.php'; // phpscss has it's own PHP version check
use Leafo\ScssPhp;
$scss = new Leafo\ScssPhp\Compiler();
$scss->setFormatter('Leafo\ScssPhp\Formatter\Expanded'); // http://leafo.github.io/scssphp/docs/

// set the default path start point as /wp-content/micro-themes/ so css/scss @imports work the same
//$path = tvr_normalize_path($path) ."../../../../../../";
$path = tvr_normalize_path($path) ."../../../../../micro-themes/";
$scss->setImportPaths($path);

