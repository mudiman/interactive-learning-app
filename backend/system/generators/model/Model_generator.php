<?php 

class Model_generator extends NamedGenerator {
	
	function manifest() 
	{
		$this->m[] = array("file" => array("models/model.php", "{application}/models/{name}.php"));
		
		return $this->m;
	}
	
	//------------------------------------------------------------------------
	
	function _content_hook($source)
	{
		return str_replace('{content}', '', $source);
	}
}

/* End of file model.php */
/* Location: /generators/model/model.php */