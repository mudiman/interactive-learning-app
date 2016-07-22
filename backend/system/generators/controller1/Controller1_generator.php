<?php 

class Controller1_generator extends NamedGenerator {
	
	function manifest() 
	{
		$this->m[] = array("file" => array("controllers/controller.php", "{application}/controllers/{name}.php"));
		
		return $this->m;
	}
	
	//------------------------------------------------------------------------
	
	function _content_hook($source)
	{
		// Make sure we have content
		if (!empty($source))
		{
			// Grab our parameters 
			$options = $this->params;
			
			// Get rid of the excess
			unset($options[0]);
			
			$t = "\n\t//------------------------------------------------------------------------\n\n";
			
			foreach ($options as $function)
			{
				$t .= "\t/**\n\t * $function()\n\t */\n";
				$t .= "\tfunction $function()\n";
				$t .= "\t{\n";
				$t .= $this->config['use_ocular'] === TRUE ? "\t\t" . '$this->ocular->render()' . "\n" : '';
				$t .= "\t}\n\n";
				$t .= "\t//------------------------------------------------------------------------\n\n";
			}
			
			return str_replace('{content}', $t, $source);
		}
		
		return $source;
	}
	
	//------------------------------------------------------------------------
}

/* End of file controller.php */
/* Location: /generators/controller/controller.php */