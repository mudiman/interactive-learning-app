<?php

class Destroy extends Controller {
	
	var $manifest = null;
	
	//------------------------------------------------------------------------
	
	function _remap()
	{
		// Get our command line options so we can pass
		// them to the index function
		$segments = $this->uri->segment_array();
		
		// Get rid of the first 2, which are 'script' and 'destroy'
		$segments = array_slice($segments, 2, count($segments)-2);
		
		// Check to see if we're showing help
		if (in_array('-h', $segments) || in_array('--help', $segments)) 
		{ 
			$this->help();
			exit; 
		} else
		if (in_array('-v', $segments) || in_array('--version', $segments))
		{
			$this->version();
			exit;
		} else
		{
			// Send all calls to the index function.
			$this->index($segments);
		}
	}

	//------------------------------------------------------------------------	

	function Destroy() {
		parent::Controller();
		
		// Include our generator classes
		require_once('lib/generator.class.php');
		
		// Include our scripts configuration file.
		$this->config->load('citools');
	}
	
	//------------------------------------------------------------------------ 
	
	function index($segments)
	{
		// Grab the arguments passed to us.
		if (count($segments) >= 1) {
			$gen_name = $segments[0];
			$gen_name_long = $gen_name . '_generator';
			
			$gen_folder = BASEPATH . $this->config->item('cit_generator_folder') . '/' . $gen_name;
			
			// check to see if there's a valid generator directory and file.
			if (is_dir($gen_folder)) 
			{
				// Make sure it's a valid file.
				if (is_file($gen_folder. '/' . $gen_name_long . '.php'))
				{
					// File was found. Include it so that we can use it.
					include($gen_folder . '/' . $gen_name_long . '.php');
					
					// Create a class so that we can use it.
					$generator = new $gen_name_long(get_instance(), $segments);
					
					// Are they just wanting the usage? 
					if (in_array('usage', $segments))
					{
						//echo $generator->source_dir;
						die($generator->usage());
					}
					
					//
					// Process the manifest
					//
					if ($generator->destroy())
					{
						echo "\tDone\n";
					} else
					{
						die("\n\tCould not process the manifest.\n\n");
					}
				} else	// Generator file not found.
				{
					die("\n\terror\tNo generator found at $gen_folder/$gen_name_long.php.\n\n");
				}
			} else	// Not a valid generator directory.
			{
				die("\n\terror\tNo generator found at $gen_folder/$gen_name'.\n\n");
			}
		} else 	// Show the help 
		$this->help();
	}
	
	//------------------------------------------------------------------------
	
	function help() {
		$str = <<<EOD
Usage: script destroy generator [options]

CodeIgniter Info: 
	-v, --version		Show the CodeIgniter version number and quit.
	-h, --help		Show this help message and quit.
	
Installed Generators:
	{genlist}
			
EOD;
		// Get a list of installed generators...
		$this->load->helper('directory');
		$map = directory_map(BASEPATH . $this->config->item('cit_generator_folder') . '/', true);
		$dirs = '';
		foreach ($map as $dir)
		{
			$dirs .= "$dir\t";
		}
		$str = str_replace('{genlist}', $dirs, $str);
		
		$str .= "\n";
		echo $str;
	}
	
	//------------------------------------------------------------------------
	
	function version()
	{
		echo "Running CodeIgniter version " . CI_VERSION . "\n\n";
	}
	
}

/* End of file generate.php */
/* Location: ./application/controllers/script/destroy.php */