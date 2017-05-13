<?php

/**
 * I don't believe in license
 * You can do want you want with this program
 * - gwen -
 */

class SourceWget
{
	const SOURCE_NAME = 'Wget';


	public static function run( $target )
	{
		$t_urls = [];
		$domain = Utils::extractDomain( $target );
		$tmpfile = tempnam( '/tmp', 'ug_' );
		$cmd = 'wget --no-check-certificate --random-wait -U "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:40.0) Gecko/20100101 Firefox/40.1" -r -l1 --spider -D '.$domain.' http://'.$target.'/ -o '.$tmpfile;
		echo $cmd."\n";
		//exit();
		exec( $cmd, $output );
		$output = file_get_contents( $tmpfile );
		//$output = file_get_contents( 'wget.txt' );
		//var_dump( $output );
		
		$r = '#.*(http[s]?://'.$target.'.*)#i';
		$m = preg_match_all( $r, $output, $tmp );
		//var_dump( $tmp );
		if( $m ) {
			$t_urls = array_merge( $t_urls, $tmp[1] );
		}
		
		$t_urls = array_unique( $t_urls );
		//var_dump( $t_urls );
		@unlink( $tmpfile );

		return $t_urls;
	}
}
