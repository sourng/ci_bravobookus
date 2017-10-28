<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_User extends CI_Model {
    
    public function __construct()
	{
		$this->load->database();
	}	
	function login($email, $option = false)
    {
		$query	= $this->db->query('SELECT users.*, user_groups.level FROM users LEFT JOIN user_groups
											   ON users.gro_id = user_groups.id_group  WHERE users.status = 1 AND email = '."'".$email."'");
		
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
	function login_fb($fb_id, $option = false)
    {
		$query	= $this->db->query('SELECT users.*, user_groups.level FROM users LEFT JOIN user_groups
											   ON users.gro_id = user_groups.id_group  WHERE users.status = 1 AND  fb_id = '."'".$fb_id."'");
		
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
	public function check_user_exist($usr)
    {
		
        $this->db->where("email",$usr);
        $query=$this->db->get("users");
        if($query->num_rows()>0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
	/**
	 * Encrypting password
	 * @param password
	 * returns salt and encrypted password
	 */
	function hashSSHA($password) {
		$salt = sha1(rand());
		$salt = substr($salt, 0, 10);
		$encrypted = base64_encode(sha1($password . $salt, true) . $salt);
		$hash = array("salt" => $salt, "encrypted" => $encrypted);
		return $hash;
	}
	
	/**
	 * Decrypting password
	 * @param salt, password
	 * returns hash string
	 */
	function checkhashSSHA($salt, $password) {
		$hash = base64_encode(sha1($password . $salt, true) . $salt);
		return $hash;
	}
}
?>