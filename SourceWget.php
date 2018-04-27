<?php

/**
 * I don't believe in license
 * You can do want you want with this program
 * - gwen -
 */

class SourceWget
{
	const SOURCE_NAME = 'Wget';
	
	const OUTPUT_DIR = '/tmp';

	const T_IGNORE = ['ico','gif','jpg','jpeg','png','bmp','svg','avi','mpg','mpeg','mp3','woff','woff2','ttf','eot'];
	

	public static function run( $target, $tor, $dork, $https, $params, $verbose )
	{
		$t_urls = [];
		$domain = Utils::extractDomain( $target );
		$tmpfile = tempnam( '/tmp', 'ug_' );
		$cmd = 'wget --no-check-certificate --random-wait --user-agent="'.UrlGrabber::T_USER_AGENT[rand(0,UrlGrabber::N_USER_AGENT)].'" -r -l'.$params.' -D '.$domain.' http'.($https?'s':'').'://'.$target.'/ -o '.$tmpfile.' -R '.implode(self::T_IGNORE,',').' -P '.self::OUTPUT_DIR.' 2>/dev/null';
		if( $tor ) {
			$cmd = 'torsocks '.$cmd;
		}
		if( $verbose <= 0 ) {
			echo $cmd."\n";
		}
		exec( $cmd, $output );
		$output = file_get_contents( $tmpfile );
		//$output = file_get_contents( '/tmp/ug_gHyE31' );
		//var_dump( $output );
		
		$r = '#.*(http[s]?://'.$target.'[^\s]+)#i';
		
		$m = preg_match_all( $r, $output, $tmp );
		//var_dump( $tmp );
		//exit();
		if( $m ) {
			$t_urls = array_merge( $t_urls, $tmp[1] );
		}
		
		/*if( $dork ) {
			foreach( $t_urls as $k=>$u ) {
				if( !strstr($u,'&') ) {
					unset( $t_urls[$k] );
				}
			}
		}*/
		
		$t_urls = array_unique( $t_urls );
		//var_dump( $t_urls );
		//@unlink( $tmpfile );

		return $t_urls;
	}
}
