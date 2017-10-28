<?php
class M_Impact extends CI_Model {
	
	public function __construct()
	{
		$this->load->database();
	}	
	
	/**
	 * Get guide
	 *
	 */
	function get_guides($wheres = FALSE, $orderby = FALSE, $options = FALSE, $limit = FALSE)
	{
		$this->db->select("
							tbl_guides.*,
							tbl_guidepackages.rate,
							tbl_guidepackages.discount
						");
		$this->db->join('tbl_guidepackages', 'tbl_guides.gui_id	= tbl_guidepackages.gui_id','LEFT');
		
		if($wheres != FALSE)
			$this->db->where($wheres);
			
		if($orderby == FALSE)
			$this->db->order_by('gui_id',$options);
		else
			$this->db->order_by($orderby,$options);
			
		$query = $this->db->get('tbl_guides', $limit);
		//trace($this->db->queries);
		if(!empty($query))
		{	
			$data = array();
			if ( $query->num_rows() > 0 )
				$data = $query->result_array();
			return $data;
		}	
	}
	
	/**
	 * Returns the list by Select fields's Name (SELECT & ORDER BY,  with Condition)
	 * 
	 * Ex: SELECT distinct(substr(text(FILD_NAME), 0, 5)) AS NAME', ORDER BY substr(text(FILD_NAME), 0, 5) DESC
	 */
	function get_select($table, $selects, $orderby = FALSE, $options = FALSE)
	{	
		$this->db->select_one($selects);
		
		if($orderby == FALSE)
			$this->db->order_by_one($this->pk_name,$options);
		else
			$this->db->order_by_one($orderby,$options);
		
		$query = $this->db->get($table);
//trace($this->db->queries);		
		if(!empty($query))
		{				
			if ( $query->num_rows() > 0 )
			{
				$datas = $query->result_array();
				return $datas;			
			}			
		}
	}
	
	function get_select_fields($table, $wheres, $selects, $orderby = FALSE, $options = FALSE)
	{	
		$this->db->select_one($selects);
		
		foreach($wheres as $key	=> $data)
		{
			if(is_array($data))
				$this->db->where_in($key, $data);
			else
				$this->db->where($key, $data);
		}

		if($orderby != FALSE)		
			$this->db->order_by($orderby, ($options != 'trace') ? $options : FALSE);
		
		$query = $this->db->get($table);
		
		if($options == 'trace')
			print_r($this->db->queries);
			
		if(!empty($query))
		{				
			if ( $query->num_rows() > 0 )
			{
				$datas = $query->result_array();
				return $datas;			
			}			
		}
	}
	
	/**
	 * Returns the record by one field
	 *
	 */
	function get_by_sql($sql, $option=false)
	{
		$query	= $this->db->query($sql);
		
		if($option == 'trace')
			print_r($this->db->queries);		
			
		if(!empty($query))
		{
			$results = array();
			if ( $query->num_rows() > 0 )
				$results = $query->result_array();
			return $results;	
		}
	}
	
	function count_by_sql($sql, $options = FALSE)
	{
		$query	= $this->db->query($sql);

        if($options == 'trace')
            print_r($this->db->queries);

		if(!empty($query))
		{
			$count = $query->num_rows();
			return $count;	
		}
		
	}
	
	/**
	 * Returns the record by one field
	 *
	 */
	function get_by_field($table, $field, $value, $orderby = FALSE, $options = FALSE)
	{	
		$this->db->where($field, $value);
		
		if($orderby == FALSE)
			$this->db->order_by($this->pk_name,$options);
		else
			$this->db->order_by($orderby,$options);
		
		$query = $this->db->get($table);
		//trace($this->db->queries);
		if(!empty($query))
		{	
			$data = array();
			if ( $query->num_rows() > 0 )
				$data = $query->result_array();
			return $data;
		}
	}
	
	/**
	 * Returns Select fields's Name by one field 
	 *
	 */
	function get_select_by_fields($table, $datas, $selects, $orderby = FALSE, $options = FALSE, $groupby= FALSE, $limit = FALSE, $offset = FALSE)
	{	
		$this->db->select($selects);
		
		if(is_array($datas))
		{
			foreach($datas as $key	=> $data)
			{
				if(is_array($data))
					$this->db->where_in($key, $data);
				else
					$this->db->where($key, $data);
			}
		}
		
		if($groupby != FALSE)
			$this->db->group_by($groupby);
		
		if($orderby == FALSE)
		{
			$this->db->order_by($this->pk_name, $options);
		}
		else
			$this->db->order_by($orderby, ($options != 'trace') ? $options : FALSE);
		
		if( $limit == FALSE && $offset == FALSE)
			$query = $this->db->get($table);
		else
			$query = $this->db->get($table,$limit,$offset);

		if($options == 'trace')
			print_r($this->db->queries);
			
		if(!empty($query))
		{				
			if ( $query->num_rows() > 0 )
			{
				$datas = $query->result_array();
				return $datas;			
			}			
		}
	}
	
	/**
	 * Returns the record by fields
	 *
	 */
	function get_by_fields($table, $datas, $orderby = FALSE, $options = FALSE)
	{	
		foreach($datas as $key	=> $data)
		{
			if(is_array($data))
				$this->db->where_in($key, $data);
			else
				$this->db->where($key, $data);
		}		
		
		if($orderby == FALSE)
		{
			$this->db->order_by($this->pk_name, $options);
		}
		else
			$this->db->order_by($orderby, ($options != 'trace') ? $options : FALSE);
		
		$query = $this->db->get($table);
		
		if($options == 'trace')
			print_r($this->db->queries);

		if(!empty($query))
		{	
			$data = array();
			if ( $query->num_rows() > 0 )
				$data = $query->result_array();
			return $data;
		}	
	}
	
	//------------------------------------------------------------------------------------------
		// check filed_name, datatype on table
	
	/**
	 * Count row in table
	 *
	 */
	function count_rows($table, $posts = FALSE, $date = FALSE,$orderby = FALSE, $options = FALSE, $limit = FALSE, $offset = FALSE)
	{	
	
		if($posts != FALSE)
		{
			if(is_array($posts))
			{
				$datas = array();
				
				// Get Fields Name & Data Type of Fields
				$fields	= $this->get_datatype(array('table_name' => $table));
				
				foreach($fields as $field)
				{
					if(!empty($posts[$field['column_name']]))
					{	
						if(is_array($posts[$field['column_name']]))
						{
							$this->db->where_in($field['column_name'], $posts[$field['column_name']]);
						}
						else
						{
							$datas[$field['column_name']] = $posts[$field['column_name']];
							
							if($field['data_type'] == 'integer')
								$this->db->where($field['column_name'], $posts[$field['column_name']]);
							else
								$this->db->like('lower('.$field['column_name'].')',strtolower($posts[$field['column_name']]));
						}
					}
				}
			}
			else
				$this->db->where($posts);
		}
			
		if($date != FALSE)
			$this->db->where($date);
		
		if($orderby == FALSE)
			$this->db->order_by($this->pk_name,$options);
		else
			$this->db->order_by($orderby,$options);
		
		if( $limit == FALSE && $offset == FALSE)
			$query = $this->db->get($table);
		else
			$query = $this->db->get($table,$limit,$offset);
			
//trace($this->db->queries);
		if(!empty($query))
		{	
			$count = $query->num_rows();
			return $count;
		}
	}	
	
	/**
	 * Count row1 in table
	 *
	 */
	function count_rows1($table, $posts = FALSE, $date = FALSE,$orderby = FALSE, $options = FALSE, $limit = FALSE, $offset = FALSE)
	{	
		if($posts != FALSE)
		{
			$this->db->where($posts);
		}
			
		if($date != FALSE)
			$this->db->where($date);
		
		if($orderby == FALSE)
			$this->db->order_by($this->pk_name,$options);
		else
			$this->db->order_by($orderby,$options);
		
		if( $limit == FALSE && $offset == FALSE)
			$query = $this->db->get($table);
		else
			$query = $this->db->get($table,$limit,$offset);
			
		//trace($this->db->queries);
		if(!empty($query))
		{	
			$count = $query->num_rows();
			return $count;
		}
	}
	
	/**
	 * Get by filter
	 *
	 */
	function get_by_filter($table, $posts = FALSE, $orderby = FALSE, $options = FALSE, $limit = FALSE, $offset = FALSE)
	{	
		if($posts != FALSE)
		{
			$datas = array();
			// Get Fields Name & Data Type of Fields
			$fields	= $this->get_datatype(array('table_name' => $table));
			
			foreach($fields as $field)
			{
				if(!empty($posts[$field['column_name']]))
				{	
					if(is_array($posts[$field['column_name']]))
					{
						$this->db->where_in($field['column_name'], $posts[$field['column_name']]);
					}
					else
					{
						$datas[$field['column_name']] = $posts[$field['column_name']];
						
						if($field['data_type'] == 'integer')
							$this->db->where($field['column_name'], $posts[$field['column_name']]);
						else
							$this->db->like('lower('.$field['column_name'].')',strtolower($posts[$field['column_name']]));
					}
				}
			}
		}
		
		if($orderby == FALSE)
			$this->db->order_by($this->pk_name,$options);
		else
			$this->db->order_by($orderby,$options);
		
		if( $limit == FALSE && $offset == FALSE)
			$query = $this->db->get($table);
		else
			$query = $this->db->get($table,$limit,$offset);
//trace($this->db->queries);
		if(!empty($query))
		{	
			$data = array();
			if ( $query->num_rows() > 0 )
				$data = $query->result_array();
			return $data;
		}	
	}	
	
	//------------------------------------------------------------------------------------------
		// for no need check filed_name, datatype  on table
	
	/**
	 * Count row in table
	 *
	 */
	function count_rows_join_by_filter($table, $selects, $joins, $wheres, $likes = FALSE, $between = FALSE, $groupby = FALSE, $options = FALSE)
	{			
		$this->db->select($selects);	
		
		if(is_array($joins)) :	
			foreach($joins as	$key => $join)	
				$this->db->join($key, $join[0], $join[1]);
		endif;
	
		if($wheres != FALSE)
		{
			foreach($wheres as $key => $value)
			{
				if(is_array($value))
					$this->db->where_in($key, $value);
				else
					$this->db->where($key, $value);
			}
		}
		
		if($likes != FALSE)
			$this->db->like($likes);
		
		if($between != FALSE)
			$this->db->where($between);
		
		if($groupby != FALSE)
			$this->db->group_by($groupby);
		
		$query = $this->db->get($table);

        if($options == 'trace')
            print_r($this->db->queries);

		if(!empty($query))
		{	
			$count = $query->num_rows();
			return $count;
		}
	}	
	function count_rows_join_by_filter2($table, $selects, $joins, $wheres, $likes = FALSE, $between = FALSE, $groupby = FALSE)
	{			
		$this->db->select_one($selects);	
		
		foreach($joins as	$key => $join)	
			$this->db->join($key, $join[0], $join[1]);
	
		if($wheres != FALSE)
		{
			foreach($wheres as $key => $value)
			{
				if(is_array($value))
					$this->db->where_in($key, $value);
				else
					$this->db->where($key, $value);
			}
		}
		
		if($likes != FALSE)
			$this->db->like($likes);
		
		if($between != FALSE)
			$this->db->where($between);
		
		if($groupby != FALSE)
			$this->db->group_by($groupby);
		
		$query = $this->db->get($table);
//trace($this->db->queries);
		if(!empty($query))
		{	
			$count = $query->num_rows();
			return $count;
		}
	}
	
	/**
	 * Count row in table have or_like
	 *
	 */
	function count_rows_join_by_filter3($table, $selects, $joins, $wheres, $or_where = FALSE, $likes = FALSE, $or_likes = FALSE, $between = FALSE, $groupby = FALSE)
	{			
		$this->db->select($selects);	
		
		if(is_array($joins)) :	
			foreach($joins as	$key => $join)	
				$this->db->join($key, $join[0], $join[1]);
		endif;
	
		if($wheres != FALSE)
		{
			foreach($wheres as $key => $value)
			{
				if(is_array($value))
					$this->db->where_in($key, $value);
				else
					$this->db->where($key, $value);
			}
		}
		
		if($or_where != FALSE)
			$this->db->where($or_where);
			
		if($likes != FALSE)
			$this->db->like($likes);
			
		if($or_likes != FALSE)
			$this->db->or_like($or_likes);
		
		if($between != FALSE)
			$this->db->where($between);
		
		if($groupby != FALSE)
			$this->db->group_by($groupby);
		
		$query = $this->db->get($table);
//trace($this->db->queries);
		if(!empty($query))
		{	
			$count = $query->num_rows();
			return $count;
		}
	}
			
	/**
	 * 	Join by filter	
	 *
	 */
	function join_by_filter($table, $selects, $joins, $wheres = FALSE, $likes = FALSE, $between = FALSE, $orderby = FALSE, $options = FALSE, $groupby = FALSE, $limit = FALSE, $offset = FALSE)
	{	
		$this->db->select($selects);		
		
		if(is_array($joins)) :
			foreach($joins as	$key => $join)	
				$this->db->join($key, $join[0], $join[1]);
		endif;
	
		if($wheres != FALSE)
		{
			foreach($wheres as $key => $value)
			{
				if(is_array($value))
					$this->db->where_in($key, $value);
				else
					$this->db->where($key, $value);
			}
		}
		
		if($likes != FALSE)
			$this->db->like($likes);		
			
		if($between != FALSE)
			$this->db->where($between);	
		
		if($orderby == FALSE)
			$this->db->order_by($this->pk_name, $options);
		else
			$this->db->order_by($orderby, ($options != 'trace') ? $options : FALSE);
			
		if($groupby != FALSE)
			$this->db->group_by($groupby);
		
		if( $limit == FALSE && $offset == FALSE)
			$query = $this->db->get($table);
		else
			$query = $this->db->get($table,$limit,$offset);

		if($options == 'trace')
			print_r($this->db->queries);			
			
		if(!empty($query))
		{	
			$data = array();
			if ( $query->num_rows() > 0 )
				$data = $query->result_array();
			return $data;
		}	
	}
	
	function join_by_filter2($table, $selects, $joins, $wheres, $likes = FALSE, $between = FALSE, $orderby = FALSE, $options = FALSE, $groupby = FALSE, $limit = FALSE, $offset = FALSE)
	{	
		$this->db->select_one($selects);		
		
		foreach($joins as	$key => $join)	
			$this->db->join($key, $join[0], $join[1]);
	
		if($wheres != FALSE)
		{
			foreach($wheres as $key => $value)
			{
				if(is_array($value))
					$this->db->where_in($key, $value);
				else
					$this->db->where($key, $value);
			}
		}
		
		if($likes != FALSE)
			$this->db->like($likes);		
			
		if($between != FALSE)
			$this->db->where($between);	
		
		if($orderby == FALSE)
		{
			$this->db->order_by($this->pk_name, $options);
		}
		else
			$this->db->order_by($orderby, ($options != 'trace') ? $options : FALSE);
			
		if($groupby != FALSE)
			$this->db->group_by($groupby);
		
		if( $limit == FALSE && $offset == FALSE)
			$query = $this->db->get($table);
		else
			$query = $this->db->get($table,$limit,$offset);
		
		if($options == 'trace')
			print_r($this->db->queries);
		//trace($this->db->queries);
		if(!empty($query))
		{	
			$data = array();
			if ( $query->num_rows() > 0 )
				$data = $query->result_array();
			return $data;
		}	
	}
	
	/**
	 * 	Join by filter or like	
	 *
	 */
	function join_by_filter3($table, $selects, $joins, $wheres, $or_where = FALSE, $likes = FALSE, $or_likes = FALSE, $between = FALSE, $orderby = FALSE, $options = FALSE, $groupby = FALSE, $limit = FALSE, $offset = FALSE)
	{	
		$this->db->select($selects);		
		
		if(is_array($joins)) :
			foreach($joins as	$key => $join)	
				$this->db->join($key, $join[0], $join[1]);
		endif;
	
		if($wheres != FALSE)
		{
			foreach($wheres as $key => $value)
			{
				if(is_array($value))
					$this->db->where_in($key, $value);
				else
					$this->db->where($key, $value);
			}
		}
		
		if($or_where != FALSE)
			$this->db->where($or_where);
			
		if($likes != FALSE)
			$this->db->like($likes);		
		
		if($or_likes != FALSE)
			$this->db->or_like($or_likes);
				
		if($between != FALSE)
			$this->db->where($between);	
		
		if($orderby == FALSE)
		{
			$this->db->order_by($this->pk_name, $options);
		}
		else
			$this->db->order_by($orderby, ($options != 'trace') ? $options : FALSE);
			
		if($groupby != FALSE)
			$this->db->group_by($groupby);
		
		if( $limit == FALSE && $offset == FALSE)
			$query = $this->db->get($table);
		else
			$query = $this->db->get($table,$limit,$offset);

		if($options == 'trace')
			print_r($this->db->queries);
			
			
		if(!empty($query))
		{	
			$data = array();
			if ( $query->num_rows() > 0 )
				$data = $query->result_array();
			return $data;
		}	
	}
	
	//------------------------------------------------------------------------------------------
		
	
	/**
	 * Get Join by filter
	 *
	 */
	function get_join_by_filter($table, $joins, $selects, $posts, $orderby = FALSE, $options = FALSE, $groupby = FALSE, $limit = FALSE, $offset = FALSE)
	{	
		$datas = array();
		// Get Fields Name & Data Type of Fields
		$fields	= $this->get_datatype(array('table_name' => $table));
		
		foreach($fields as $field)
		{			
			if(!empty($posts[$table.'.'.$field['column_name']]))
			{	
				if(is_array($posts[$table.'.'.$field['column_name']]))
				{
					$this->db->where_in($field['column_name'], $posts[$table.'.'.$field['column_name']]);
				}
				else
				{
					$datas[$field['column_name']] = $posts[$table.'.'.$field['column_name']];
					
					if($field['data_type'] == 'integer')
						$this->db->where($table.'.'.$field['column_name'], $posts[$table.'.'.$field['column_name']]);
					else
						$this->db->like('lower('.$table.'.'.$field['column_name'].')',strtolower($posts[$table.'.'.$field['column_name']]));
				}
			}
		}

		$this->db->select($selects);		
		
		foreach($joins as	$key => $join)	
			$this->db->join($key, $join[0], $join[1]);
	
		if($orderby == FALSE)
			$this->db->order_by($this->pk_name,$options);
		else
			$this->db->order_by($orderby,$options);
			
		if($groupby != FALSE)
			$this->db->group_by($groupby);
		
		if( $limit == FALSE && $offset == FALSE)
			$query = $this->db->get($table);
		else
			$query = $this->db->get($table,$limit,$offset);
//trace( $this->db->queries);
		if(!empty($query))
		{	
			$data = array();
			if ( $query->num_rows() > 0 )
				$data = $query->result_array();
			return $data;
		}	
	}
	
	//------------------------------------------------------------------------------------------
		// Check field_name, datatype of table by Select field_name
	
	/**
	 * Count row in table
	 *
	 */
	function count_rows2($table, $joins, $selects, $posts, $orderby = FALSE, $options = FALSE, $groupby = FALSE)
	{		
		$datas = array();
		// Get Fields Name & Data Type of Fields
		$fields	= $this->get_datatype(array('table_name' => $table));
		
		foreach($fields as $field)
		{			
			if(!empty($posts[$table.'.'.$field['column_name']]))
			{	
				if(is_array($posts[$table.'.'.$field['column_name']]))
				{
					$this->db->where_in($field['column_name'], $posts[$table.'.'.$field['column_name']]);
				}
				else
				{
					$datas[$field['column_name']] = $posts[$table.'.'.$field['column_name']];
					
					if($field['data_type'] == 'integer')
						$this->db->where($table.'.'.$field['column_name'], $posts[$table.'.'.$field['column_name']]);
					else
						$this->db->like('lower('.$table.'.'.$field['column_name'].')',strtolower($posts[$table.'.'.$field['column_name']]));
				}
			}
		}

		$this->db->select_one($selects);		
		
		foreach($joins as	$key => $join)	
			$this->db->join($key, $join[0], $join[1]);
	
		if($orderby == FALSE)
			$this->db->order_by($this->pk_name,$options);
		else
			$this->db->order_by($orderby,$options);
			
		if($groupby != FALSE)
			$this->db->group_by($groupby);

		$query = $this->db->get($table);

		if(!empty($query))
		{	
			$count = $query->num_rows();
			return $count;
		}
	}
	
	/**
	 * Get Join by filter2 
	 *
	 */
	function get_join_by_filter2($table, $joins, $selects, $posts, $orderby = FALSE, $options = FALSE, $groupby = FALSE, $limit = FALSE, $offset = FALSE)
	{	
		$datas = array();
		// Get Fields Name & Data Type of Fields
		$fields	= $this->get_datatype(array('table_name' => $table));
		
		foreach($fields as $field)
		{			
			if(!empty($posts[$table.'.'.$field['column_name']]))
			{	
				if(is_array($posts[$table.'.'.$field['column_name']]))
				{
					$this->db->where_in($field['column_name'], $posts[$table.'.'.$field['column_name']]);
				}
				else
				{
					$datas[$field['column_name']] = $posts[$table.'.'.$field['column_name']];
					
					if($field['data_type'] == 'integer')
						$this->db->where($table.'.'.$field['column_name'], $posts[$table.'.'.$field['column_name']]);
					else
						$this->db->like('lower('.$table.'.'.$field['column_name'].')',strtolower($posts[$table.'.'.$field['column_name']]));
				}
			}
		}

		$this->db->select_one($selects);		
		
		foreach($joins as	$key => $join)	
			$this->db->join($key, $join[0], $join[1]);
	
		if($orderby == FALSE)
			$this->db->order_by($this->pk_name,$options);
		else
			$this->db->order_by($orderby,$options);
			
		if($groupby != FALSE)
			$this->db->group_by($groupby);
		
		if( $limit == FALSE && $offset == FALSE)
			$query = $this->db->get($table);
		else
			$query = $this->db->get($table,$limit,$offset);
//trace( $this->db->queries);
		if(!empty($query))
		{	
			$data = array();
			if ( $query->num_rows() > 0 )
				$data = $query->result_array();
			return $data;
		}	
	}
	
	/**
	 * get max by fields
	 *
	 */	
	function get_max_by_fields($table, $posts = FALSE, $select)
	{	
		if($posts != FALSE)
		{
			$fields	= $this->get_datatype(array('table_name' => $table));
		
			foreach($fields as $field)
			{
				if(!empty($posts[$field['column_name']]))
				{
					if(is_array($posts[$field['column_name']]))
					{
						$this->db->where_in($field['column_name'], $posts[$field['column_name']]);
					}
					else
					{
						$datas[$field['column_name']] = $posts[$field['column_name']];
						
						if($field['data_type'] == 'integer')
							$this->db->where($field['column_name'], $posts[$field['column_name']]);
						else
							$this->db->like('lower('.$field['column_name'].')',strtolower($posts[$field['column_name']]));
					}
				}
			}
		}
		
		$this->db->select_max($select);		
		$query = $this->db->get($table);
		
		if(!empty($query))
		{	
			$data = array();
			if ( $query->num_rows() > 0 )
				$data = $query->row($select);
			return $data;
		}	
	}
	
	/**
	 * get min by fields
	 *
	 */	
	function get_min_by_fields($table, $field,$posts = FALSE)
	{	
		if($posts != FALSE)
		{
			$this->db->where($posts);
		}
		
		$this->db->select_min($field);		
		$query = $this->db->get($table);
		//trace($this->db->queries);
		if(!empty($query))
		{	
			$data = array();
			if ( $query->num_rows() > 0 )
				$data = $query->row($field);
			return $data;
		}	
	}
	
	/**
	 * get sum by fields
	 *
	 */	
	function get_sum_by_fields($table, $posts = FALSE, $select)
	{	
		if($posts != FALSE)
		{
			$fields	= $this->get_datatype(array('table_name' => $table));
		
			foreach($fields as $field)
			{
				if(!empty($posts[$field['column_name']]))
				{
					if(is_array($posts[$field['column_name']]))
					{
						$this->db->where_in($field['column_name'], $posts[$field['column_name']]);
					}
					else
					{
						$datas[$field['column_name']] = $posts[$field['column_name']];
						
						if($field['data_type'] == 'integer')
							$this->db->where($field['column_name'], $posts[$field['column_name']]);
						else
							$this->db->like('lower('.$field['column_name'].')',strtolower($posts[$field['column_name']]));
					}
				}
			}
		}
		
		$this->db->select_sum($select);		
		$query = $this->db->get($table);

		if(!empty($query))
		{	
			$data = array();
			if ( $query->num_rows() > 0 )
				$data = $query->row($select);
			return $data;
		}	
	}

	// ------------------------------------------------------------------------	
	
	/**
	 * Check Duplicate
	 *
	 */ 	 
	function duplicate($table, $wheres, $likes=false, $option=false)
	{	
		if($likes != false)
			$this->db->like($likes);
			
		$query = $this->db->get_where($table, $wheres);
		
		if($option == 'trace')
			print_r($this->db->queries);
			
		if(!empty($query)):
			if ( $query->num_rows() > 0 )
				return true;
			else
				return false;
		endif;
		
		return false;
	}
	
	// ------------------------------------------------------------------------	
	
	/**
	 * Get Data Type of Fileds
	 *
	 */ 	 
	function get_datatype($data)
	{	
		$this->db->select('column_name,data_type');		
		$query = $this->db->get_where('information_schema.columns', $data);
		
		if(!empty($query))
		{	
			$results = array();
			
			if ( $query->num_rows() > 0 )
				$results = $query->result_array();
			
			return $results;
		}
	}
	
	// ------------------------------------------------------------------------
	
	/**
	 * Insert
	 *
	 */	
	function insert($table, $data, $option = false)
	{
		$affected_rows	= $this->db->insert($table, $data);
		
		if($option == 'trace')
			print_r($this->db->queries);
			
		return $affected_rows;
	}
	
	function insert_by_sql($sql, $option = false)
	{   		
		$affected_rows	= $this->db->query($sql);
		
		if($option == 'trace')
			print_r($this->db->queries);
			
		return $affected_rows;
	}

	// ------------------------------------------------------------------------

	
	/**
	 * Update
	 *
	 */	
	function update($table, $data, $option = false)
	{
		$this->db->where($this->pk_name, $data[$this->pk_name]);
		$affected_rows	= $this->db->update($table, $data);		
		
		if($option == 'trace')
			print_r($this->db->queries);
		
		return $affected_rows;
	}	
	
	/**
	 * Update
	 *
	 */	
	function update_field($table, $data, $wheres, $option = false)
	{
        foreach($wheres as $key => $value)
        {
            if(is_array($value))
                $this->db->where_in($key, $value);
            else
                $this->db->where($key, $value);
        }

		$affected_rows	= $this->db->update($table,$data);
		
		if($option == 'trace')
			print_r($this->db->queries);
			
		return $affected_rows;
	}	
	// ------------------------------------------------------------------------

	
	/**
	 * Delete
	 *
	 */	
	function delete($table, $data, $option = false)
	{
		
		$affected_rows	= $this->db->delete($table, $data);
		
		if($option == 'trace')
			print_r($this->db->queries);
			
		return $affected_rows;
	}
	
	/**
	 * Delete
	 *
	 */	
	function delete_fields($table, $data, $option = false)
	{
		$affected_rows	= $this->db->delete($table, $data);
		
		if($option == 'trace')
			print_r($this->db->queries);
			
		return $affected_rows;
	}
	/**
	 * select max(field)
	 *
	 */	
	function select_max_field($table, $field_name, $posts = false, $option = false)
	{
		$this->db->select_max($field_name);
		if($posts != false){		
			foreach($posts as $key => $p){
				if(is_numeric($p))
					$this->db->where($key, $p);
				else
					$this->db->like('lower('.$key.')',strtolower($p));
			}
		}//end if 
		
		$query = $this->db->get($table);
		
		if($option == 'trace')
			print_r($this->db->queries);
	
		if(!empty($query))
		{	
			$data = array();
			if ( $query->num_rows() > 0 )
				$data = $query->result_array();
			return $data;
		}	
	}
	
	function get_max_by_field($table, $field_name, $wheres = false, $likes = false, $option = false)
	{
		$this->db->select_max($field_name);
		
		if($wheres != FALSE)
		{
			foreach($wheres as $key => $value)
			{
				if(is_array($value))
					$this->db->where_in($key, $value);
				else
					$this->db->where($key, $value);
			}
		}
		
		if($likes != FALSE)
			$this->db->like($likes);
		
		$query = $this->db->get($table);
				
		if($option == 'trace')
			print_r($this->db->queries);
		
		$data	= 0;
		if(!empty($query))
		{	
			$data = array();
			if ( $query->num_rows() > 0 )
				$data = $query->result_array();
							
			$data	= $data[0][$field_name];
		}	
		
		return $data;
	}
	
	/**
	 * select sum(field)
	 *
	 */	
	function select_sum_field($table, $field_name, $posts = false)
	{
		
		$this->db->select_sum($field_name);
		if($posts != false){		
			foreach($posts as $key => $p){
				if(is_numeric($p))
					$this->db->where($key, $p);
				else
					$this->db->like('lower('.$key.')',strtolower($p));
			}
		}//end if 
		
		$query = $this->db->get($table);
		//trace($this->db->queries);		
		if(!empty($query))
		{	
			$data = array();
			if ( $query->num_rows() > 0 )
				$data = $query->result_array();
			return $data;
		}	
	}
	/**
	 * Count All Results
	 *
	 */	
	function count_all_results($table, $wheres = false, $option = false)
	{
		if($wheres != FALSE)
		{
			foreach($wheres as $key => $value)
			{
				if(is_array($value))
					$this->db->where_in($key, $value);
				else
					$this->db->where($key, $value);
			}
		}
	
		$this->db->from($table);
			
		if($option == 'trace')
			print_r($this->db->queries);
			
		$data	= $this->db->count_all_results();
		
		return $data;
	}
	
	/**
	 * select sum(field)
	 *
	 */	
	function select_distinct_by_fields($table, $wheres = FALSE, $select)
	{
		$this->db->distinct();
		$this->db->select($select);
		
		if($wheres != FALSE)
		{
			foreach($wheres as $key => $value)
			{
				if(is_array($value))
					$this->db->where_in($key, $value);
				else
					$this->db->where($key, $value);
			}

		}
		
		$query = $this->db->get($table);
		
		if(!empty($query))
		{	
			$data = array();
			if ( $query->num_rows() > 0 )
				$data = $query->result_array();
			return $data;
		}	
	}
	
	/**
	 * Truncate Table
	 *
	 *
	 */
	function truncate($table)
	{		
		$this->db->truncate($table);
	}
	
	/**
	 * Encrypt Decrypt
	 *
	 *
	 */
	function encrypt_decrypt($status, $data = false)
	{
		//Encrypt
		if($status == 'encrypt' && $data != false)
		{
			$encrypt = rtrim(strtr(base64_encode($data), '+/', '-_'), '='); 
			return $encrypt;
		}
		elseif($status == 'decrypt' && $data != false)
		{
			 $decrypt = base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT)); 
			 return $decrypt;
		}
	}
	
	/*
	Alert Message
	*/
	function alert_message($sms, $type){
		if($type == 'success' ){
			$sms = '<div class="message_box">'. $sms .'</div>';
			$sms .= '	<script type="text/javascript">
			$(document).ready(function(){
			   setTimeout(function(){
			  $("div.message_box").fadeOut("slow", function () {
			  $("div.message_box").remove();
				  });
			
			}, 2000);
			 });</script>';

		}elseif($type == 'failed'){
			$sms = '<div class="message_box">'. $sms .'</div>';
			$sms .= '	<script type="text/javascript">
			$(document).ready(function(){
			   setTimeout(function(){
			  $("div.message_box").fadeOut("slow", function () {
			  $("div.message_box").remove();
				  });
			
			}, 20000);
			 });</script>';

		}elseif($type == 'error'){
			$sms = '<div class="message_box">'. $sms .'</div>';
			$sms .= '	<script type="text/javascript">
			$(document).ready(function(){
			   setTimeout(function(){
			  $("div.message_box").fadeOut("slow", function () {
			  $("div.message_box").remove();
				  });
			
			}, 20000);
			 });</script>' ;
		}
		
		return $sms;
	}
	/*
	 * Paginations
	*/
	public function paginations($pages, $current_page)
	{
		$view=NULL;
		$view .='<ul class="pagination" id="pagination">';
		
			if ($pages > 1)
			{
				//Previous
				if($current_page == 1)
				{
					$view .='<li><a  onclick="pagination();" rel="'. $current_page .'">&lsaquo;&lsaquo; Previous</a></li>';
				}
				else
				{
					$previous=$current_page-1;
					$view .='<li><a  onclick="pagination();" rel="'. $previous .'">&lsaquo;&lsaquo; Previous</a></li>';
				}
				
				//First = num 1	
				if($current_page>6)
					$view .= '<li><a  onclick="pagination();" rel="1">1...</a></li>';
				
				$num_links	= 5;
				$start = (($current_page - $num_links) > 0) ? $current_page - ($num_links - 1) : 1;
				$end   = (($current_page + $num_links) < $pages) ? $current_page + $num_links : $pages;
				if($start==1) 
					$start=$start; 
				else 
					$start=$start-1;
					
				//Loop pages
				for($i=$start; $i<=$end; $i++)
				{
					if($i == $current_page)
					$view .='<li><a href="" class="current" rel="'. $i .'">'. $i .'</a></li>';
					else
					$view .='<li><a href="" rel="'. $i .'">'. $i .'</a></li>';
				}
				
				//Last = num of last page	
				if($current_page<$pages-5)
					$view .= '<li><a  href="" rel="'.$pages.'">...'.$pages.'</a></li>';
				
				//Next
				if($current_page == $pages)	
				{
					$view .='<li><a  href="" rel="'. $pages .'">Next &rsaquo;&rsaquo;</a></li>';
				}
				else
				{
					$next=$current_page+1;
					$view .='<li><a  href="" rel="'. $next .'">Next &rsaquo;&rsaquo;</a></li>';
				}
			}
		$view .='</ul>';
		
		return $view;
	}
}

?>