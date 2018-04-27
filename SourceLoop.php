<?php

/**
 * I don't believe in license
 * You can do want you want with this program
 * - gwen -
 */

class SourceLoop
{
	const SOURCE_NAME = 'Loop';


	public static function run( $target, $tor, $dork, $https, $params, $t_urls )
	{
		foreach( $t_urls as $source )
		{
			$html = file_get_contents( $source );
			$reg = '#<.*(href|src|action)="+([^">]*)#i';
			$m = preg_match_all( $reg, $html, $matches );
			
			if( $m )
			{
			    if( $matches && is_array($matches) && isset($matches[2]) && is_array($matches[2]) && count($matches[2]) ) {
			        $t_news = $matches[2];
			    }
				
				foreach( $t_news as $k=>&$url )
				{
					if( trim($url) == '' ) {
						unset( $t_news[$k] );
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
						unset( $t_news[$k] );
					}
					
					/*if( $run && !strstr($url,"?") ) {
						unset( $t_news[$k] );
					}*/
				}
			}
		}
		var_dump( $matches );
		//exit();

		return $t_news;
	}
}
