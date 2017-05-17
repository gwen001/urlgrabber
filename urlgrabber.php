#!/usr/bin/php
<?php

/**
 * I don't believe in license
 * You can do want you want with this program
 * - gwen -
 */

function __autoload( $c ) {
	include( $c.'.php' );
}


// parse command line
{
	$grabber = new UrlGrabber();
	$grabber->registerSource( 1, 'SourceLynx' );
	$grabber->registerSource( 2, 'SourceInurlbr' );
	$grabber->registerSource( 3, 'SourceWget' );
	$grabber->registerSource( 9, 'SourceLoop' );

	$argc = $_SERVER['argc'] - 1;

	for ($i = 1; $i <= $argc; $i++) {
		switch ($_SERVER['argv'][$i]) {
			case '-h':
			case '--help':
				Utils::help();
				break;

			case '--https':
				$grabber->enableHttps();
				break;

			case '--malicious':
				$grabber->enableMaliciousSearch();
				break;

			case '--no-assets':
				$grabber->excludeAssets();
				break;

			case '--source':
				$grabber->setSource($_SERVER['argv'][$i + 1]);
				$i++;
				break;

			case '--target':
				$grabber->setTarget($_SERVER['argv'][$i + 1]);
				$i++;
				break;

			case '--tor':
				$grabber->enableTor();
				break;

			default:
				Utils::help('Unknown option: '.$_SERVER['argv'][$i]);
		}
	}

	if( !$grabber->getTarget() ) {
		Utils::help( 'Target not found' );
	}
}
// ---


// main loop
{
	$grabber->run();
	//$grabber->printResult();
}
// ---


exit();
