<?php

/**
 * I don't believe in license
 * You can do want you want with this program
 * - gwen -
 */

class UrlGrabber
{
	private $target = '';
	
	private $n_child = 0;
	private $max_child = 3;
	private $sleep = 100000;
	private $t_process = [];
	private $t_signal_queue = [];

	private $t_urls = [];

	private $t_run = [];
	private $t_sources = [];
	
	
	public function getTarget() {
		return $this->target;
	}
	public function setTarget( $v ) {
		return $this->target = trim( $v );
	}

	
	private function testSource( $s ) {
		/*if( !is_subclass_of($s,'ThirdParty') ) {
			return false;
		}*/
		if( !method_exists($s,'run') ) {
			return false;
		}
		if( property_exists($s,'SOURCE_NAME') ) {
			return false;
		}
		return true;
	}
	public function registerSource( $index, $v ) {
		$v = trim( $v );
		$file = dirname(__FILE__).'/'.$v.'.php';
		if( !is_file($file) || !class_exists($v) ) {
			Utils::help( $v.' class not found' );
		}
		if( !$this->testSource($v) ) {
			Utils::help( $v.' class wrongly configured' );
		}
		$this->t_sources[ $index ] = $v;
		//ksort( $this->t_sources );
		$this->t_run[] = $v;
		return true;;
	}
	public function setSource( $v ) {
		$tmp = explode( ',', $v );
		$this->t_run = [];
		foreach( $tmp as $s ) {
			if( !isset($this->t_sources[$s]) ) {
				Utils::help( $s.' source not found' );
			}
			$this->t_run[] = $this->t_sources[ $s ];
		}
	}
	
	// http://stackoverflow.com/questions/16238510/pcntl-fork-results-in-defunct-parent-process
	// Thousand Thanks!
	public function signal_handler( $signal, $pid=null, $status=null )
	{
		// If no pid is provided, Let's wait to figure out which child process ended
		if( !$pid ){
			$pid = pcntl_waitpid( -1, $status, WNOHANG );
		}
		
		// Get all exited children
		while( $pid > 0 )
		{
			if( $pid && isset($this->t_process[$pid]) ) {
				// I don't care about exit status right now.
				//  $exitCode = pcntl_wexitstatus($status);
				//  if($exitCode != 0){
				//      echo "$pid exited with status ".$exitCode."\n";
				//  }
				// Process is finished, so remove it from the list.
				$this->n_child--;
				unset( $this->t_process[$pid] );
			}
			elseif( $pid ) {
				// Job finished before the parent process could record it as launched.
				// Store it to handle when the parent process is ready
				$this->t_signal_queue[$pid] = $status;
			}
			
			$pid = pcntl_waitpid( -1, $status, WNOHANG );
		}
		
		return true;
	}
	
	
	public function run()
	{
		foreach( $this->t_run as $s ) {
			$class = $s;
			echo "Testing ".$class::SOURCE_NAME."...\n";
			$t_urls = $class::run( $this->target );
			$this->t_urls = array_merge( $this->t_urls, $t_urls );
			echo count( $t_urls )." urls found.\n";
			echo "\n";
		}
		
		$this->t_urls = array_unique( $this->t_urls );
	}
	
	
	public function printUrls()
	{
		echo implode( "\n", $this->t_urls )."\n";
	}
}
