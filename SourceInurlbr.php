<?php

/**
 * I don't believe in license
 * You can do want you want with this program
 * - gwen -
 */

class SourceInurlbr
{
	const SOURCE_NAME = 'INURLBR';


	public static function run( $target, $tor, $malicious, $https, $params )
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
		//$cmd = 'inurlbr '.($tor?'--tor-random':'').' --user-agent "'.UrlGrabber::T_USER_AGENT[rand(0,UrlGrabber::N_USER_AGENT)].'" --no-banner --dork-file '.$dorkfile.' --sall '.$tmpfile.' -q 1,6 --mp 200';
		$cmd = 'inurlbr '.($tor?'--tor-random':'').' --user-agent "'.UrlGrabber::T_USER_AGENT[rand(0,UrlGrabber::N_USER_AGENT)].'" --no-banner --dork "site:'.$target.'" -s '.$tmpfile.' -q 1,6 --mp 200';
		echo $cmd."\n";
		//exit();
		//exec( $cmd, $output );
		$tmpfile = 'inurlbr.txt';
		//var_dump( $output );
		
		$t_urls = file( $tmpfile, FILE_IGNORE_NEW_LINES |  FILE_SKIP_EMPTY_LINES );
		$t_urls = array_unique( $t_urls );
		
		foreach( $t_urls as $k=>&$url )
		{
			if( trim($url) == '' ) {
				unset( $t_urls[$k] );
				continue;
			}
			
			if( $url[0] == '/' ) {
				if( strlen($url)>1 && $url[1] == '/' ) {
					if( $https ) {
						$url = 'https:'.$url;
					} else {
						$url = 'http:'.$url;
					}
				} else {
					if( $https ) {
						$url = 'https://'.$target.$url;
					} else {
						$url = 'http://'.$target.$url;
					}
				}
			} else {
				if( strstr($url,'://') ) {
					; // nada ?
				}
			}
			
			if( !stristr($url,$target) ) {
				unset( $t_urls[$k] );
			}
			
			if( $malicious && !strstr($url,"?") ) {
				unset( $t_urls[$k] );
			}
		}
		//var_dump( $t_urls );
		//exit();
		
		//@unlink( $tmpfile );
		@unlink( $dorkfile );

		return $t_urls;
	}
}
