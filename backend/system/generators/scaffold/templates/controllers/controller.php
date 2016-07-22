<?php

class {plural_name} extends Controller {

	var $base_uri	= '';
	var $base_url	= '';

	function {plural_name}() {
		parent::Controller();
		
		// Load the model with db access
		$this->load->model('{name}_model', '{name}', true);
		
		$this->load->library('uri');
		$this->base_uri = $this->uri->segment(1).$this->uri->slash_segment(2, 'leading');
		$this->base_url = $this->config->site_url().'/'.$this->uri->segment(1).$this->uri->slash_segment(2, 'both');
	}

	//------------------------------------------------------------------------
	
	function index($per_page='', $offset='')
	{
		$this->view($per_page, $offset);
	}
	
	//------------------------------------------------------------------------
	
	function view($per_page='', $offset='')
	{
		// Get our results
		$query = $this->{name}->find_all('', $per_page, $offset);
		
		// Get all of our fields
		$fields = $this->{name}->fields();
		
		// We assume that the column in the first position is the primary field.
		$primary = current($fields);
	
		// Setup our pagination
		$this->load->helper('url');
		$this->load->library('pagination');
		$this->pagination->initialize(
							array(
									'base_url'		 => $this->base_url.'/view',
									'total_rows'	 => $this->{name}->count_all(),
									'per_page'		 => $per_page,
									'uri_segment'	 => 4,
									'full_tag_open'	 => '<p>',
									'full_tag_close' => '</p>'
									)
								);
		
		$data = array(
						'title'	=>  'View Data',
						'query'		=> $query,
						'fields'	=> $fields,
						'primary'	=> $primary,
						'paginate'	=> $this->pagination->create_links(),
						'base_uri'	=> $this->base_uri . '/{lower_name}'
					);
						
		$this->load->view('{lower_name}/view', $data);	
	}
	
	//------------------------------------------------------------------------
	
	function add()
	{
		$data = array(
						'title'	=>  'Add Data',
						'fields' => $this->{name}->fields(),
						'action' => $this->base_uri.'/insert'
					);
	
		$this->CI->load->view('add', $data);
	}
	
	//------------------------------------------------------------------------
	
	function insert()
	{		
		if ($this->{name}->add($_POST) === FALSE)
		{
			$this->add();
		}
		else
		{
			redirect($this->base_uri.'/view/');
		}
	}
	
	//------------------------------------------------------------------------	
	
	function edit()
	{				
		// Run the query
		$query = $this->{name}->find($id);

		$data = array(
						'title'	=>  'Edit Data',
						'fields'	=> $query->field_data(),
						'query'		=> $query->row(),
						'action'	=> $this->base_uri.'/update/'.$this->CI->uri->segment(4)
					);
	
		$this->CI->load->view('{name}/edit', $data);
	}
	
	//------------------------------------------------------------------------
	
	function update($id)
	{				
		// Now do the query
		$this->{name}->update($id, $_POST);
		
		redirect($this->base_uri.'/view/');
	}
	
	//------------------------------------------------------------------------
	
	function delete()
	{
		$message = 'Are you sure you want to delete the following row: '.$this->CI->uri->segment(4);
	
		$data = array(
						'title'		=> 'Delete Data',
						'message'	=> $message,
						'no'		=> anchor(array($this->base_uri, 'view'), 'No'),
						'yes'		=> anchor(array($this->base_uri, 'do_delete'), $this->CI->uri->segment(4), 'Yes')
					);
	
		$this->CI->load->view('delete', $data);
	}
	
	//------------------------------------------------------------------------
	
	function do_delete($id)
	{						
		// Now do the query
		$this->{name}->delete($id);

		header("Refresh:0;url=".site_url(array($this->base_uri, 'view')));
		exit;
	}
	
	//------------------------------------------------------------------------ 
}

/* End {name}.php */
/* File located at: /application/controllers/{name}.php */