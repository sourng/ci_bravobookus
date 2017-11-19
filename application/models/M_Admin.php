<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class M_Admin extends CI_Model {
    
    protected $table_name;
    protected $tbl_ticket;
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->tbl_ticket = 'tbl_ticket';
    }
    
    public function getAll() {
        return $this->db->from($this->table_name)->get()->result_array();
    }
    // Get All Ticket
     public function getAllTicket() {
        return $this->db->from($this->tbl_ticket)->get()->result_array();
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
 
}
 
/* End of file user_model.php */
/* Location: ./application/controllers/user_model.php */
