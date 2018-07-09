<?php

/**
 * I don't believe in license
 * You can do want you want with this program
 * - gwen -
 */

class SourceWayback
{
	const SOURCE_NAME = 'Wayback';


	public static function run( $target, $tor, $dork, $https, $params, $verbose )
	{
		$t_urls = [];
		$cmd = 'waybackurls '.$target.' true';
		if( $tor ) {
			$cmd = 'torsocks '.$cmd;
		}
		if( $verbose <= 0 ) {
			echo $cmd."\n";
		}
		exec( $cmd, $output );
		$output = implode( "\n", $output );
		$output = str_replace( "'", '"', $output );
		//file_put_contents( 'wayback.txt', $output );
		//$output = file_get_contents( 'wayback.txt' );
		//var_dump( $output );
		
		if( strstr($output,'[-] Found nothing') !== false ) {
			return $t_urls;
		}
		
		$output = str_replace( '],', "],\n", $output );
		//$output = json_encode( json_decode($output), JSON_PRETTY_PRINT );
		//var_dump($output);
		//exit();
				
		$r = '#"(http[s]?://'.$target.'[^"]+)#i';
		
		$m = preg_match_all( $r, $output, $tmp );
		//var_dump( $tmp );
		//exit();
		if( $m ) {
			$t_urls = array_merge( $t_urls, $tmp[1] );
		}

		$t_urls = array_unique( $t_urls );
		//var_dump( $t_urls );
		
		return $t_urls;
	}
}
