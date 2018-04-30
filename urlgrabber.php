#!/usr/bin/php
<?php

/**
 * I don't believe in license
 * You can do want you want with this program
 * - gwen -
 */

function __autoload( $c ) {
	include( __DIR__.'/'.$c.'.php' );
}


// parse command line
{
	$options = [
		'dork:',
		'https',
		'no-assets',
		'source:',
		'target:',
		'tor',
		'verbose:',
	];
	$t_options = getopt( '', $options );
	//var_dump( $t_options );

	$grabber = new UrlGrabber();
	$grabber->registerSource( 1, 'SourceLynx' );
	$grabber->registerSource( 2, 'SourceInurlbr' );
	$grabber->registerSource( 3, 'SourceWget' );
	$grabber->registerSource( 4, 'SourceWayback' );
	$grabber->registerSource( 9, 'SourceLoop' );

	foreach( $t_options as $k=>$v )
	{
		switch( $k )
		{
			case 'dork':
				$grabber->setDork( $v );
				break;

			case 'https':
				$grabber->enableHttps();
				break;

			case 'no-assets':
				$grabber->excludeAssets();
				break;

			case 'source':
				$grabber->setSource( $v );
				break;

			case 'target':
				$grabber->setTarget( $v );
				break;

			case 'tor':
				$grabber->enableTor();
				break;

			case 'verbose':
				$grabber->setVerbose( $v );
				break;

			default:
				Utils::help( 'Unknown option: '.$k );
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
