<?php
class Users_model extends CI_Model
{

	function Users_model()
	{
		parent::__construct();
	}

	function create($data)
	{
		$this->db->set('name', $data['name']);
		$this->db->set('userscol', $data['userscol']);
		$this->db->insert('users');

		return $this->db->affected_rows();
	}
    
    function login($username,$password)
    {
        $this->db->where('name', $username);
        $this->db->where('password', $password);
        $query = $this->db->get('users');
        return $query->result();
    }
    
	function read($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('users');

		return $query->result();
	}

	function readAll()
	{
		$query = $this->db->get('users');

		return $query->result();
	}

	function update($id, $data)
	{
		$this->db->where('id', $data['id']);
		$this->db->set('name', $data['name']);
		$this->db->set('userscol', $data['userscol']);
		$this->db->update('users');

		return $this->db->affected_rows();
	}

	function delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('users');

		return $this->db->affected_rows();
	}

}