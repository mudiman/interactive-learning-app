<?php 

class scaffold extends NamedGenerator {
	
	function manifest() 
	{
		$this->m[] = array("file" => array("models/model.php", "application/models/{name}_model.php"));
	
		$this->m[] = array("file" => array("controllers/controller.php", "application/controllers/{plural_name}.php"));
		
		$this->m[] = array("directory" => array("application/views/{lower_name}"));
		
		$this->m[] = array("file" => array("views/view.php", "application/views/{lower_name}/view.php"));
		$this->m[] = array("file" => array("views/edit.php", "application/views/{lower_name}/edit.php"));
		$this->m[] = array("file" => array("views/delete.php", "application/views/{lower_name}/delete.php"));
		$this->m[] = array("file" => array("views/new.php", "application/views/{lower_name}/new.php"));
		$this->m[] = array("file" => array("views/head.php", "application/views/{lower_name}/head.php"));
		$this->m[] = array("file" => array("views/foot.php", "application/views/{lower_name}/foot.php"));
		
		return $this->m;
	}
	
	//------------------------------------------------------------------------
	

}

/* End of file scaffold.php */
/* Location: ./generators/scaffold/scaffold.php */