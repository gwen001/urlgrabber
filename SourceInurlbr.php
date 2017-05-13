<?php

/**
 * I don't believe in license
 * You can do want you want with this program
 * - gwen -
 */

class SourceInurlbr
{
	const SOURCE_NAME = 'INURLBR';


	public static function run( $target )
	{
		$tmpfile = '../../../../../../../../../../'.tempnam( '/tmp', 'ug_' );
		$t_urls = [];
		$cmd = "inurlbr --tor-random --no-banner --dork 'site:".$target."' --sall ".$tmpfile." -q 1,6";
		echo $cmd."\n";
		exec( $cmd, $output );
		//var_dump( $output );
		
		$t_urls = file( $tmpfile, FILE_IGNORE_NEW_LINES |  FILE_SKIP_EMPTY_LINES );
		$t_urls = array_unique( $t_urls );
		//var_dump( $t_urls );
		@unlink( $tmpfile );
		
		return $t_urls;
	}
}
