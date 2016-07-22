<?php 

class Ocular_generator extends BaseGenerator {
	
	function manifest() 
	{
		$this->m[] = array("file" => array("config/ocular.php", "{application}/config/ocular.php"));
		
		$this->m[] = array("file" => array("controllers/assets.php", "{application}/controllers/assets.php"));
		$this->m[] = array("file" => array("controllers/welcome.php", "{application}/controllers/welcome.php"));
		
		$this->m[] = array("file" => array("helpers/ocular_helper.php", "{application}/helpers/ocular_helper.php"));
		
		$this->m[] = array("file" => array("libraries/Ocular.php", "{application}/libraries/Ocular.php"));
		
		$this->m[] = array("directory" => array("public"));
		$this->m[] = array("directory" => array("public/images"));
		$this->m[] = array("directory" => array("public/javascripts"));
		$this->m[] = array("directory" => array("public/stylesheets"));
		
		$this->m[] = array("file" => array("public/stylesheets/application.css", "public/stylesheets/application.css"));
		
		$this->m[] = array("directory" => array("{application}/views/templates"));
		$this->m[] = array("directory" => array("{application}/views/welcome"));
		
		$this->m[] = array("file" => array("views/templates/application.php", "{application}/views/templates/application.php"));
		$this->m[] = array("file" => array("views/welcome/index.php", "{application}/views/welcome/index.php"));
		
		$this->m[] = array("readme" => "README.txt");
		
		return $this->m;
	}
}

/* End of file ocular.php */
/* Location: /generators/ocular/ocular.php */