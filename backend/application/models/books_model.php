<?php
class Books_model extends CI_Model
{

	function Books_model()
	{
		parent::__construct();
		$this->load->database();
	}

	function create($data)
	{
		$this->db->set('name', $data['name']);
		$this->db->set('author_name', $data['author_name']);
		//$this->db->set('json', $data['json']);
		$this->db->insert('books');

		return $this->db->affected_rows();
	}
    
    function readFirstbook()
    {
        $this->db->order_by("id"); 
        $this->db->limit(1);
        $query = $this->db->get('books');
        return $query->row();
    }

	function read($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('books');
		return $query->row();
	}
	
	function getbookId($name)
    {
        $this->db->where('name', $name);
        $query = $this->db->get('books');
        $temp=$query->row();
        return $temp->id;
    }

	function readAll()
	{
		$query = $this->db->get('books');
		return $query->result();
	}

	function update($id, $data)
	{
		$this->db->where('id', $id);
        if (isset($data['name']))
		$this->db->set('name', $data['name']);
        if (isset($data['author_name']))
		$this->db->set('author_name', $data['author_name']);
        if (isset($data['json']))
		$this->db->set('json', $data['json']);
		$this->db->update('books');

		return $this->db->affected_rows();
	}

	function delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('books');

		return $this->db->affected_rows();
	}

}