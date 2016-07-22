<?php

class {name}_model extends Model {

	var $db_table = '';

	function {name}_model() {
		parent::Model();
		
		$this->db_table = '{plural_name}';
	}

	//------------------------------------------------------------------------
	
	/**
	 * find()
	 *
	 * A flexible method for finding records. It can work in 3 different ways.
	 *   1) Find Single Record by ID
	 *      $result = find('34');
	 *   2) Find All records in a table (find_all() is an easier method)
	 *      $result = find('', '', 0, 0, true);
	 */
	function find($id='', $conditions='', $limit=0, $offset=0, $all=false)
	{
		// Is the user setting conditions?
		if (!empty($conditions) && is_array($conditions))
		{
			$this->db->where($conditions);
			return $this->db->get($this->db_table);
		}
	
		// Are we showing all records? 
		if ($all)
		{	
			return $this->db->get($this->db_table);
		} else	// Make sure we have valid data
		if (!empty($id) && is_numeric($id))
		{	
			return $this->db->get_where($this->db_table, array('id' => $id));
		}
		
		return false;
	}
	
	//------------------------------------------------------------------------
	/**
	 *	find_all()
	 *
	 *  An alias for for the find function.
	 */
	function find_all($conditions='', $limit=0, $offset=0)
	{
		return $this->find('', $conditions, $limit, $offset, true);
	}

	//------------------------------------------------------------------------
	
	function find_by($by='', $search='', $limit=0, $offset=0)
	{
		// Make sure we have valid data
		if (!empty($search) && !empty($by))
		{
			$conditions = array($by => $search);
			return $this->find('', $conditions, $limit, $offset );
		}
		
		return false;
	}
	
	//------------------------------------------------------------------------
	
	function find_related($id='', $table='', $attribute='')
	{
		// Check to see if an attribute has been provided. 
		// If not, default to this model name + '_id'.
		if (empty($attribute))
		{
			$attribute = $this->db_name . '_id';
		}
		
		if (!empty($id) && is_numeric($id) && !empty($table) && $this->db->table_exists($table))
		{
			$this->db->where($attribute, $id);
			return $this->db->get($table);
		}
		
		return false;
	}
	
	//------------------------------------------------------------------------
	
	function find_related_by($by='', $search='', $table='')
	{
		if (!empty($by) && !empty($search) && !empty($table))
		{
			$this->db->where($by, $search);
			return $this->db->get($table);
		}
		
		return false;
	}
	
	//------------------------------------------------------------------------
	
	/**
	 *	new()
	 *
	 * Creates a new record. If the db table has a 'created_on' field,
	 * this command will automatically insert a timestamp into that field.
	 * 
	 * @param array An array of key/value pairs representing table data.
	 */
	function add($data='')
	{
		if (!empty($data) && is_array($data))
		{
			// Check for a 'created_on' field in the data
			if (!in_array('created_on'))
			{
				// Check for 'created_on' in table
				if ($this->db->field_exists('created_on', $db_table))
				{
					// Add the created on date to the data array
					$data[] = array('created_on' => time());
				}
			}
			
			// Insert the data
			if ($this->db->insert($this->db_table, $data))
			{
				// Clear the CI database cache
				$this->db->cache_delete();
			
				// Return the record ID
				return $this->db->insert_id();
			}
		}
		return false;
	}
	
	//------------------------------------------------------------------------
	
	function update($id='', $data='')
	{
		if (!empty($id) && is_numeric($id) && !empty($data) && is_array($data))
		{
			// Check for an 'updated_on' field in the data
			if (!in_array('updated_on'))
			{
				// Check for 'updated_on' in table
				if ($this->db->field_exists('updated_on', $db_table))
				{
					// Add the created on date to the data array
					$data[] = array('updated_on' => time());
				}
			}
			
			// Update the data
			if ($this->db->where('id', $id)->update($this->db_table, $data))
			{
				// Clear the CI database cache
				$this->db->cache_delete();
				
				return true;
			}
		}
		
		return false;
	}
	
	//------------------------------------------------------------------------
	
	function delete($id='',$conditions='', $all=false)
	{
		// Are we deleting all?
		if ($all)
		{
			return $this->db->empty_table();
		}
		
		// Is the user setting conditions?
		if (!empty($conditions) && is_array($conditions))
		{
			$this->db->where($conditions);
			if ($this->db->delete($this->db_table))
			{
				// Clear the CI database cache
				$this->db->cache_delete();
				
				return true;
			}
		}
		
		if (!empty($id) && is_numeric($id))
		{
			
			if ($this->db->delete($this->db_table))
			{
				// Clear the CI database cache
				$this->db->cache_delete();
				
				return true;
			}
		}
		
		return false;
	}
	
	//------------------------------------------------------------------------
	
	function delete_all()
	{
		return $this->delete('', '', true);
	}
	
	//------------------------------------------------------------------------
	
	function delete_by($by='', $search='')
	{
		if (!empty($by) && !empty($search))
		{
			$conditions = array($by => $search);
			return $this->delete('', $conditions);
		}
	}
	
	//------------------------------------------------------------------------
	
	function count_all()
	{
		return $this->db->count_all($this->db_table);
	}
	
	//------------------------------------------------------------------------
	
	function fields()
	{
		return $this->db->list_fields($this->db_table);
	}
	
	//------------------------------------------------------------------------
	
}

/* End {name}.php */
/* File located at: /application/models/{name}.php */