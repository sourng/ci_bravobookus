<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Crud_model extends CI_Model
{
	
    function __construct(){
        // Call the Model constructor
        parent::__construct();        
    }   
    public function get_setting()
	{
		$query = $this->db->get('settings');
		return $query->result();
	}

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


	public function create_category_query($data)
	{
		$this->db->insert('categories',$data);
		return $insert_id = $this->db->insert_id();
	}

	public function get_category_query()
	{
		$query = $this->db->get('hotels');
		return $query->result();
	}

	public function search($search)
	{
		$limit = 10; $offset = 0;
		$search = str_replace(' ', '%20', trim($search));
		
		//$search = preg_replace(' ', '%20', $search);

	    // if (preg_match('/\s/', $search) > 0) {
	    //     $search = array_map('trim', array_filter(explode(' ', $search)));
	    //     foreach ($search as $key => $value) {
	    //         $this->db->or_like('h_name', $value);
	    //     }
	    // } else if ($search != ''){
	    //     $this->db->like('h_name', $search);
	    // }
	    // $query = $this->db->get('hotels', $limit, $offset);
	    // return $query->result();

		$query = $this->db->like('h_name', trim($search), 'both')->get('hotels');
		return $query->result();
	}

	public function delete_category_query($id)
	{
				$this->db->where('cate_id',$id);
		return  $this->db->delete('categories');
	}

	public function get_category_by_query($id)
	{
		$this->db->select('*');
		$this->db->from('categories');
		$this->db->where('cate_id',$id);
		$query = $this->db->get();
		return $query->result();
	}

	public function update_category_query($id,$data)
	{
				$this->db->where('cate_id',$id);
		return  $this->db->update('categories',$data);
	}

}