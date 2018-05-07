<?php

/**
 * I don't believe in license
 * You can do want you want with this program
 * - gwen -
 */

class SourceGoogleGrabber
{
	const SOURCE_NAME = 'GoogleGrabber';


	public static function run( $target, $tor, $dork, $https, $params, $verbose )
	{
		$t_urls = [];
		$cmd = './ggrab.py \''.urldecode($dork).'\' 2>/dev/null';
		if( $tor ) {
			$cmd = 'torsocks '.$cmd;
		}
		if( $verbose <= 0 ) {
			echo $cmd."\n";
		}
		exec( $cmd, $output );
		$output = implode( "\n", $output );
		//file_put_contents( 'lynx.txt', $output );
		//$output = file_get_contents( 'lynx.txt' );
		//var_dump( $output );
		
		$r = '#(http[s]?://'.$target.'.*)#i';
		$m = preg_match_all( $r, $output, $tmp );
		//var_dump( $tmp );
		if( $m ) {
			$t_urls = array_merge( $t_urls, $tmp[1] );
		}

		$t_urls = array_unique( $t_urls );
		//var_dump( $t_urls );
		
		return $t_urls;
	}
}
