<?php

/**
 * Generator
 *
 * This is the base class for BaseGenerator and NamedGenerator.
 */
class Generator {

	var $source_dir 	= '';
	var $dest_dir		= '';
	var $params			= '';
	var $name			= '';
	var $m				= array();
	var $app			= '';
	var $obj_name		= '';
	var $CI				= '';

	/**
	 *	Constructor
	 */
	function Generator(&$CI, $options ='') 
	{
		// Store our params
		if (!empty($options))
		{
			$this->params = $options;
		}
		
		// Grab our CI instance
		$this->CI = $CI;
		
		// Create a shortcut for our application path.
		$this->app 			= APPPATH;
		// Remove trailing slashes
		$this->app = trim($this->app, ' /');
		
		$this->dest_dir 	= substr(dirname(__FILE__), 0, -22);
		$this->dest_dir		= str_replace($this->app, '', $this->dest_dir);
		
		$this->source_dir 	= BASEPATH . $this->CI->config->item('cit_generator_folder') . '/' . get_class($this) . '/';
		$this->source_dir	= str_replace('_generator', '', $this->source_dir);
		
		$this->name			= get_class($this);
		$this->name			= str_replace('_generator', '', $this->name);
		
		//echo "Source Dir = " . $this->source_dir;
		//echo "Dest Dir = " . $this->dest_dir . "\n";
		//echo "Name = " . $this->name . "\n";
	}

	//------------------------------------------------------------------------
	
	/**
	 * Source Path
	 * 
	 * Returns the full path for the passed short path, in the templates directory.
	 * ie. source_path('some/path.php') == '/source/some/path.php'
	 */
	 function source_path($partial_path='')
	 {
	 	//echo "Source Dir = " . $this->source_dir . 'templates/' . $partial_path;
	 	return $this->source_dir . 'templates/' . $partial_path;
	 } 
	
	//------------------------------------------------------------------------
	
	/**
	 * Destination Path
	 * 
	 * Returns the full path for the passed short path.
	 * ie. destination_path('some/path.php') == '/dest/some/path.php'
	 */
	 function destination_path($partial_path='')
	 {
	 	//echo "Destination Dir = " . $this->dest_dir . $partial_path;
	 	return $this->dest_dir . $partial_path;
	 } 
	 
	 //------------------------------------------------------------------------
	 
	 /**
	  * Usage
	  *
	  * Read USAGE from file in source path
	  */
	  function usage() 
	  {
	  	$file = $this->source_dir . 'USAGE.txt';
	  	if (is_readable($file)) {
	  		echo "\nUsage: \n";
	  		echo file_get_contents($file) . "\n\n";
	  	} else {
	  		echo "\n\terror\tNo USAGE file exists.\n\n";
	  	}
	  }
	
	//------------------------------------------------------------------------ 
	  
	// Displays the contents of the README file listed. 
	// Note: this file must reside in the generator's root directory.
	function readme($file='')
	{
		// Does a README file exist?
		if (!empty($file) && file_exists($this->source_dir . $file)) 
		{
			echo "\n" . file_get_contents($this->source_dir .$file);
		} else	// Try generic README.txt
		if (file_exists($this->source_dir. 'README.txt'))
		{
			echo "\n" . file_get_contents($this->source_dir . 'README.txt');
		} else	// Nothing found.
		{
			echo "\terror\tREADME file could not be found.\n";
			return false;
		}
		
		return true;
	}
	
	  
	  //------------------------------------------------------------------------ 
	  
	  /**
	   * Manifest
	   * 
	   * An empty function that must be overriden by the derived classes.
	   * This function describes the steps needed to generate the action.
	   *
	   * The manifest contains an array of actions to be performed, along
	   * with their parameters. An example for creating a new model named
	   * 'foo' would be:
	   * 	function manifest() {
	   *		$m[] = array("file", "foo", "path/to/src/file", "path/to/desination/file");
	   *	}
	   * Note that the exact format will vary depending on whether the 
	   * generator is based off of BaseGenerator or NamedGenerator.
	   */
	   function manifest() 
	   {
   			echo "\terror\tNo manifest for " . $this->name . " generator.\n\n";
	   }
	   
	   //------------------------------------------------------------------------
	   
	   function plural($name='')
	   {
	   		if (!empty($name))
	   		{
	   			$last = substr($name, strlen($name) -1);
	   			
	   			if ($last == 'y')
	   			{
	   				$name = substr($name, 0, strlen($name) - 1) . 'ies';
	   			} else
	   			{
	   				$name .= 's';
	   			}
	   		}
	   		
	   		return $name;
	   }
	   
	   //------------------------------------------------------------------------
	   
	   function _set_names($source)
		{
			$source = str_replace('{name}', ucfirst($this->obj_name), $source);
			$source = str_replace('{lower_name}', strtolower($this->obj_name), $source);
			$source = str_replace('{plural_name}', $this->plural(ucfirst($this->obj_name)), $source);
			
			$source = str_replace('{application}', $this->app, $source);
			
			return $source;
		}
		
		//------------------------------------------------------------------------	
}


/**
 * BaseGenerator
 *
 * This is a simple generator class that provides basic functionality
 * for copying files such as stylesheets, images, or javascripts. 
 * 
 * For more advanced functionality, extend the NamedGenerator class.
 */
class BaseGenerator extends Generator {

	/**
	 *	Constructor
	 */
	function BaseGenerator(&$CI, $options) 
	{
		parent::Generator(&$CI, $options);
	}
	
	//------------------------------------------------------------------------

	/**
	 * File
	 * 
	 * Copies a file from the generator's template directory
	 * to the application directory.
	 *
	 * The options paramater takes an array of options. The valid settings are:
	 * 		collision 	: tells the script how to handle collisions. Valid options are:
	 * 			skip, overwrite, ask
	 *		chmod 		: specifies the file attributes that should be set.
	 */ 
	function file($original='', $new='', $options = array())
	{
		// Check the source file
		if (!file_exists($this->source_path($original)))
		{
			echo "Checked for file: " .$this->source_path($original); 
			echo "\terror\tFile cannot be found: $original\n";
			return false;
		}
		
		// Default to the same path under '/application' if no name given.
		if (empty($new)) { $new = $this->app . '/' . $original; }
		
		// Fix our path names
		$new = $this->_set_names($new);
		
		// Does the file exist? 
		if (file_exists($this->destination_path($new))) 
		{
			// Has a collision option been set? 
			if (in_array('collision', $options)) 
			{
				switch($options['collision'])
				{
					case 'skip':
						return true;
						break;
					case 'overwrite':
						if (copy($this->source_path($original), $this->destination_path($new)))
						{
							echo "\tcreate\tfile: $new\n";
						} else	// Copy failed
						{
							echo "\terror\tFile could not be created: $new\n";
						}
						break;
					case 'ask':
						// Ask the user what to do
						fwrite(STDOUT, "File exists: $new.\nOverwite or skip? [o,s]");
						$action = trim(fgets(STDIN));
						$action = strtolower(substr($action, 0, 1));
						
						switch ($action)
						{
							case 'o':
								if (copy($this->source_path($original), $this->destination_path($new)))
								{
									echo "\tcreate\tfile: $new\n";
								} else	// Copy failed
								{
									echo "\terror\tFile could not be created: $new\n";
								}
								break;
							default: 
								return true;
						}
						break;
				}
			} else	// No collision options set
			{
				// Skip the file
				echo "\texists\tfile\t$new\n";
				return true;
			}
		} else	// File doesn't exist
		{
			if (copy($this->source_path($original), $this->destination_path($new)))
			{
				echo "\tcreate\tfile\t$new\n";
				return true;
			} else	// Copy failed
			{
				echo "\terror\tfile\tFile could not be created: $new\n";
				return false;
			}
		}
		return false;
	}
	
	//------------------------------------------------------------------------
	
	// Creates a new directory in the application folder.
	function directory($name='')
	{
		// Has a name been passed? 
		if (!empty($name))
		{
			// Parse our variables
			$name = $this->_set_names($name);
			
			// Check if the directory exists
			if (!is_dir($this->destination_path($name)))
			{
				if (mkdir($this->destination_path($name)))
				{
					echo "\tcreate\tdir\t/$name\n";
					return true;
				} else	// Couldn't create the directory
				{
					echo "\terror\tDirectory could not be created: $name\n";
					return false;
				}
			} else	// Directory exists.
			{
				echo "\texists\tdir\t/$name\n";
			}
		}
		return false;
	}
	
	//------------------------------------------------------------------------
	
	/**
	 * Create
	 *
	 * Runs through each of the items in the manifest, from top to bottom,
	 * atttempting to make each one happen.
	 */
	function create()
	{
		// Generate our manifest.
		if ($this->manifest())
		{
			
			foreach ($this->m as $m => $v)
			{
				if (is_array($v)) 
				{
					if (isset($v['file']))
					{	// File
						$this->file($v['file'][0], $v['file'][1]);
					} else	// Directory
					if (isset($v['directory']))
					{
						$this->directory($v['directory'][0]);
					} else	// Readme
					if (isset($v['readme']))
					{
						if (isset($v['readme'][0]))
							$this->readme($v['readme'][0]);
						else
							$this->readme();
					}
				}
			}
			return true;
		}
		
		return false;
	}
	
	//------------------------------------------------------------------------
	
	/**
	 * Destroy
	 * 
	 * Attempts to run backwards through the manifest, destroying all of 
	 * files that the create function created.
	 */
	 function destroy()
	 {
	 	// Generate our manifest
	 	if ($this->manifest())
	 	{
	 		// Reverse the manifest order
	 		$this->m = array_reverse($this->m);
	 		
	 		foreach ($this->m as $m => $v)
	 		{
	 			if (is_array($v))
	 			{
	 				if (isset($v['file']))
	 				{	// File
	 					$v['file'] = $this->_set_names($v['file']);
	 					if (file_exists($this->destination_path($v['file'][1])))
	 					{
	 						// Try to delete the "new" file
	 						if (unlink($this->destination_path($v['file'][1])))
	 						{
	 							echo "\tdelete\tfile\t" . $this->destination_path($v['file'][1]) . "\n";
	 						} else	// Error deleting file
	 						{
	 							echo "\terror\tfile\tCould not delete: " . $this->destination_path($v['file'][1]) . "\n";
	 						}
	 						
	 					} else	// File not found
	 					{
	 						echo "\tmissing\tfile\t" . $this->destination_path($v['file'][1]) . "\n";
	 					}
	 				} else	// Directory
	 				if (isset($v['directory']))
	 				{
	 					$v['directory'] = $this->_set_names($v['directory']);
	 					if (is_dir($this->destination_path($v['directory'][0])))
	 					{
	 						// Is it empty? 
	 						$files = @scandir($dir);
	 						if (count($files) <= 2)
	 						{
	 							// Try to delete it
	 							if (rmdir($this->destination_path($v['directory'][0])))
	 							{
	 								echo "\tdelete\tdir\t" . $this->destination_path($v['directory'][0]) . "\n";
	 							} else	// Error Deleting directory
	 							{
	 								echo "\terror\tdir\tCannot delete: " . $this->destination_path($v['directory'][0]) . "\n";
	 							}
	 							
	 						} else	// Directory not empty
	 						{
	 							echo "\tnot empty\tdir\t" . $this->destination_path($v['directory'][0]) . "\n";
	 						}
	 					} else	// Directory doesn't exist.
	 					{
	 						echo "\tmissing\tdir\t" . $this->destination_path($v['directory'][0]) . "\n";
	 					}
	 				} 
	 			}
	 		}
	 		return true;
	 	}
	 	return false;
	 }
	
	//------------------------------------------------------------------------
	
}


class NamedGenerator extends Generator {

	var $name = ''; 	// The name to be used for our object.
	
	function NamedGenerator(&$CI, $options) 
	{	
		parent::Generator(&$CI, $options);
		
		$this->obj_name = $options[1];
	}
	
	//------------------------------------------------------------------------
	
	/**
	 * File
	 * 
	 * Copies a file from the generator's template directory
	 * to the application directory.
	 *
	 * The options paramater takes an array of options. The valid settings are:
	 * 		collision 	: tells the script how to handle collisions. Valid options are:
	 * 			skip, overwrite, ask
	 *		chmod 		: specifies the file attributes that should be set.
	 */ 
	function file($original='', $new='', $options = array())
	{
		// Check the source file
		if (!file_exists($this->source_path($original)))
		{
			echo "\terror\tFile cannot be found: $original\n";
			return false;
		}
		
		// Default to the same path under '/application' if no name given.
		if (empty($new)) { $new = $this->app . $original; }
		
		// Parse our name based on the object name.
		$new = $this->_set_names($new);
				
		// Does the file exist? 
		if (file_exists($this->destination_path($new))) 
		{
			// Has a collision option been set? 
			if (in_array('collision', $options)) 
			{
				switch($options['collision'])
				{
					case 'skip':
						return true;
						break;
					case 'overwrite':
						if ($this->_copy($this->source_path($original), $this->destination_path($new)))
						{
							echo "\tcreate\tfile: $new\n";
						} else	// Copy failed
						{
							echo "\terror\tFile could not be created: $new\n";
						}
						break;
					case 'ask':
						// Ask the user what to do
						fwrite(STDOUT, "File exists: $new.\nOverwite or skip? [o,s]");
						$action = trim(fgets(STDIN));
						$action = strtolower(substr($action, 0, 1));
						
						switch ($action)
						{
							case 'o':
								if ($this->_copy($this->source_path($original), $this->destination_path($new)))
								{
									echo "\tcreate\tfile: $new\n";
								} else	// Copy failed
								{
									echo "\terror\tFile could not be created: $new\n";
								}
								break;
							default: 
								return true;
						}
						break;
				}
			} else	// No collision options set
			{
				// Skip the file
				echo "\texists\tfile\t$new\n";
				return true;
			}
		} else	// File doesn't exist
		{
			if ($this->_copy($this->source_path($original), $this->destination_path($new)))
			{
				echo "\tcreate\tfile\t$new\n";
				return true;
			} else	// Copy failed
			{
				echo "\terror\tfile\tFile could not be created: $new\n";
				return false;
			}
		}
		return false;
	}
	
	//------------------------------------------------------------------------
	
	// Creates a new directory in the application folder.
	function directory($name='')
	{
		// Has a name been passed? 
		if (!empty($name))
		{
			// Replace our name in the directory
			$name = $this->_set_names($name);
			
			// Check if the directory exists
			if (!is_dir($this->destination_path($name)))
			{
				if (mkdir($this->destination_path($name)))
				{
					echo "\tcreate\tdir\t/$name\n";
					return true;
				} else	// Couldn't create the directory
				{
					echo "\terror\tDirectory could not be created: $name\n";
					return false;
				}
			} else	// Directory exists.
			{
				echo "\texists\tdir\t/$name\n";
			}
		}
		return false;
	}
	
	//------------------------------------------------------------------------
	
	/**
	 * Create
	 *
	 * Runs through each of the items in the manifest, from top to bottom,
	 * atttempting to make each one happen.
	 */
	function create()
	{
		// Generate our manifest.
		if ($this->manifest())
		{
			
			foreach ($this->m as $m => $v)
			{
				if (is_array($v) && $v['file'])
				{	// File
					$this->file($v['file'][0], $v['file'][1]);
				} else	// Directory
				if (is_array($v) && $v['directory'])
				{
					$this->directory($v['directory'][0]);
				} else	// Readme
				if (is_array($v) && $v['readme'])
				{
					if (isset($v['readme'][0]))
						$this->readme($v['readme'][0]);
					else
						$this->readme();
				}
			}
			return true;
		}
		
		return false;
	}
	
	//------------------------------------------------------------------------
	
	function _copy($source_file='', $dest_file='') 
	{
		//echo "Source File = $source_file\n";
		//echo "Destination Files = $dest_file\n";
		// Make sure we have destination and source files.
		if (!empty($source_file) && !empty($dest_file))
		{
			// Read the contents of our source file.
			$source = file_get_contents($source_file);
			
			$source = $this->_set_names($source);
			
			$source = $this->_content_hook($source);
			//echo "Source = $source\n";
			
			 // Try to write the file
			 $file = fopen($dest_file, 'w');
			 if ($file)
			 {
			 	fwrite($file, $source);
				fclose($file);
				return true;
			 }
		}
		return false;
	}
	
	//------------------------------------------------------------------------
	
	/**
	 * Destroy
	 * 
	 * Attempts to run backwards through the manifest, destroying all of 
	 * files that the create function created.
	 */
	 function destroy()
	 {
	 	// Generate our manifest
	 	if ($this->manifest())
	 	{
	 		// Reverse the manifest order
	 		$this->m = array_reverse($this->m);
	 		
	 		foreach ($this->m as $m => $v)
	 		{
	 			if (is_array($v))
	 			{
	 				if ($v['file'])
	 				{	// File
	 					$new = $v['file'][1];
	 					$new = $this->_set_names($new);
	 					
	 					if (file_exists($this->destination_path($new)))
	 					{
	 						// Try to delete the "new" file
	 						if (unlink($this->destination_path($new)))
	 						{
	 							echo "\tdelete\tfile\t" . $this->destination_path($new) . "\n";
	 						} else	// Error deleting file
	 						{
	 							echo "\terror\tfile\tCould not delete: " . $this->destination_path($new) . "\n";
	 						}
	 						
	 					} else	// File not found
	 					{
	 						echo "\tmissing\tfile\t" . $this->destination_path($new) . "\n";
	 					}
	 				} else	// Directory
	 				{
	 					$dir = $this->destination_path($v['directory'][0]);
	 					$dir = $this->_set_names($dir);

	 					if (is_dir($dir))
	 					{
	 						// Is it empty? 
	 						$files = @scandir($dir);
	 						if (count($files) <= 2)
	 						{
	 							// Try to delete it
	 							if (rmdir($dir))
	 							{
	 								echo "\tdelete\tdir\t" . $dir . "\n";
	 							} else	// Error Deleting directory
	 							{
	 								echo "\terror\tdir\tCannot delete: " . $dir . "\n";
	 							}
	 							
	 						} else	// Directory not empty
	 						{
	 							echo "\tnot empty\tdir\t" . $dir . "\n";
	 						}
	 					} else	// Directory doesn't exist.
	 					{
	 						echo "\tmissing\tdir\t" . $dir . "\n";
	 					}
	 				} 
	 			}
	 		}
	 		return true;
	 	}
	 	return false;
	 }
	
	//------------------------------------------------------------------------
	
	function _content_hook($source)
	{
		return $s;
	}
	
	//------------------------------------------------------------------------	
}

/* End of file generator.class.php */
/* Location: ./script/lib/generator.class.php */