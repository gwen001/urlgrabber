<?php

/**
 * I don't believe in license
 * You can do want you want with this program
 * - gwen -
 */

class SourceCommonCrawl
{
	const SOURCE_NAME = 'CommonCrawl';


	public static function run( $target, $tor, $dork, $https, $params, $verbose )
	{
		$cmd = 'curl -sX GET "http://index.commoncrawl.org/CC-MAIN-2018-22-index?url=*.'.$target.'&output=json" | jq -r .url | sort -u';
		if( $tor ) {
			$cmd = 'torsocks '.$cmd;
		}
		if( $verbose <= 0 ) {
			echo $cmd."\n";
		}

		exec( $cmd, $output );
		//var_dump( $output );
		
		if( count($output) == 1 && $output[0] == 'null' ) {
			return [];
		}
		
		return $output;
	}
}
