<?php

/** 
 * Delcare DS Plugin Example Class
 */
if ( ! class_exists( 'DS_Example_Plugin', FALSE ) ) {
	class DS_Example_Plugin
	{
		private $_log_file = NULL;
		private $_log = FALSE;
		
		/**
		 * Performs logging for debugging purposes
		 * @param string $msg The message to write to the log file
		 */
		function debug( $msg )
		{
			//if ( defined( 'WP_DEBUG' ) ) {
				// identify type
				if (! is_string($msg) ){
					$msg = "(" . gettype($msg) . ") " . var_export($msg, true);
				}else{
					$msg = "(" . gettype($msg) . ") " . $msg;
				}
				if ( NULL === $this->_log_file ) {
					$this->_log_file = dirname( dirname( __FILE__ ) ) . '/~ds-example-plugin-log.txt';
					$this->_log = @fopen( $this->_log_file, 'a+' );
				}

				if ( FALSE !== $this->_log ) {
					if ( NULL === $msg )
						fwrite( $this->_log, date( 'Y-m-d H:i:s' ) );
					else
						fwrite( $this->_log, date( 'Y-m-d H:i:s - ' ) . $msg . "\r\n" );
					fflush( $this->_log );
				}
			//}
		}
		
		/**
		 * Check for the last_ui_event and invoke the associated method
		 * with corresponding parameters.
		 */
		function __construct()
		{
			global $ds_runtime;
			if (FALSE === $ds_runtime->last_ui_event) return;
			
			// Invoke the method associated with the last_ui_event
			switch ($ds_runtime->last_ui_event->action) {
				case "site_preimport":
					$this->site_preimport( $ds_runtime->last_ui_event->info );
					break;
				default:
					break;
			}
		}
		
		/**
		 * site_preimport - occurs after a site is selected for import and is unzipped.
		 */
		function site_preimport( $info )
		{
			$this->debug( $info );
		}
	}
	global $ds_example_plugin;
	$ds_example_plugin = new DS_Example_Plugin();
}
		

// EOF