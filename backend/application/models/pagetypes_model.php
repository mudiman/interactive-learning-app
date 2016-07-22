<?php
class Pagetypes_model extends CI_Model
{

	function Pagetypes_model()
	{
		parent::__construct();
		$this->load->database();
	}

	function create($data)
	{
		$this->db->set('types', $data['types']);
		$this->db->insert('pagetypes');

		return $this->db->affected_rows();
	}

	function read($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('pagetypes');

		return $query->result();
	}

	function readAll()
	{
		$query = $this->db->get('pagetypes');

		return $query->result();
	}

	function update($id, $data)
	{
		$this->db->where('id', $data['id']);
		$this->db->set('types', $data['types']);
		$this->db->update('pagetypes');

		return $this->db->affected_rows();
	}

	function delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('pagetypes');

		return $this->db->affected_rows();
	}

}