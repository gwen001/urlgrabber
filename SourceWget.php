<?php

/**
 * I don't believe in license
 * You can do want you want with this program
 * - gwen -
 */

class SourceWget
{
	const SOURCE_NAME = 'Wget';


	public static function run( $target, $tor, $malicious, $https )
	{
		$t_urls = [];
		$domain = Utils::extractDomain( $target );
		$tmpfile = tempnam( '/tmp', 'ug_' );
		$cmd = 'wget --no-check-certificate --random-wait --user-agent="'.UrlGrabber::T_USER_AGENT[rand(0,UrlGrabber::N_USER_AGENT)].'" -r -l2 --spider -D '.$domain.' http'.($https?'s':'').'://'.$target.'/ -o '.$tmpfile;
		if( $tor ) {
			$cmd = 'torsocks '.$cmd;
		}
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
		
		if( $malicious ) {
			foreach( $t_urls as $k=>$u ) {
				if( !strstr($u,'&') ) {
					unset( $t_urls[$k] );
				}
			}
		}
		
		$t_urls = array_unique( $t_urls );
		//var_dump( $t_urls );
		@unlink( $tmpfile );

		return $t_urls;
	}
}
