<?php

/**
 * I don't believe in license
 * You can do want you want with this program
 * - gwen -
 */

class SourceInurlbr
{
	const SOURCE_NAME = 'INURLBR';


	public static function run( $target, $tor, $malicious )
	{
		$tmpfile = '../../../../../../../../../../'.tempnam( '/tmp', 'ug_' );
		$dorkfile = '../../../../../../../../../../'.tempnam( '/tmp', 'ug_' );
		echo $dorkfile."\n";
		
		if( $malicious ) {
			file_put_contents( $dorkfile, 'site:'.$target.' inurl:"&"' );
		} else {
			file_put_contents( $dorkfile, 'site:'.$target );
		}

		$t_urls = [];
		$cmd = 'inurlbr '.($tor?'--tor-random':'').' --user-agent "'.UrlGrabber::T_USER_AGENT[rand(0,UrlGrabber::N_USER_AGENT)].'" --no-banner --dork-file '.$dorkfile.' --sall '.$tmpfile.' -q 1,6';
		echo $cmd."\n";
		//exit();
		exec( $cmd, $output );
		//var_dump( $output );
		
		$t_urls = file( $tmpfile, FILE_IGNORE_NEW_LINES |  FILE_SKIP_EMPTY_LINES );
		$t_urls = array_unique( $t_urls );
		//var_dump( $t_urls );
		@unlink( $tmpfile );
		@unlink( $dorkfile );
		
		return $t_urls;
	}
}
