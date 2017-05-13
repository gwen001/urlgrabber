<?php

/**
 * I don't believe in license
 * You can do want you want with this program
 * - gwen -
 */

class SourceLynx
{
	const SOURCE_NAME = 'Lynx';


	public static function run( $target )
	{
		$t_urls = [];
		//$cmd = 'lynx -listonly -dump http://www.google.com/search?q=site%3A'.$target.'&start=0&num=1000';
		$cmd = 'lynx -listonly -dump "http://www.google.com/search?q=site%3A'.$target.'+inurl%3A%22%26%22&start=0&num=1000"';
		echo $cmd."\n";
		exec( $cmd, $output );
		$output = implode( "\n", $output );
		//file_put_contents( 'lynx.txt', implode("\n",$output) );
		//$output = file_get_contents( 'lynx.txt' );
		//var_dump( $output );
		
		//$r = '#http[s]?://'.$target.'(.*)#i';
		$r = '#/url\?q=(http[s]?://'.$target.'.*)&sa=.*#i';
		$m = preg_match_all( $r, $output, $tmp );
		//var_dump( $tmp );
		if( $m ) {
			$t_urls = array_merge( $t_urls, $tmp[1] );
		}
		
		$r = '#/search\?q=related:(http[s]?://'.$target.'.*)&hl=#i';
	    preg_match_all( $r, $output, $tmp );
		//var_dump( $tmp );
		if( $m ) {
			$t_urls = array_merge( $t_urls, $tmp[1] );
		}
		
		$r = '#/search\?q=cache:.*:(http[s]?://'.$target.'.*)\+site:#i';
	    preg_match_all( $r, $output, $tmp );
		//var_dump( $tmp );
		if( $m ) {
			$t_urls = array_merge( $t_urls, $tmp[1] );
		}

		$t_urls = array_unique( $t_urls );
		//var_dump( $t_urls );
		
		return $t_urls;
	}
}
