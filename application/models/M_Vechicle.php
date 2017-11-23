<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class M_Vechicle extends CI_Model {    
   
	var $table = 'tbl_vehicle';
	public function __construct(){
		parent::__construct();
		}

	// public function get_all_vechiles(){
	// 	$this->db->from('books');
	// 	$query=$this->db->get();
	// 	return $query->result();
	// }

	public function get_by_id($id){
		$this->db->from($this->table);
		$this->db->where('v_id',$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function vechile_add($data){
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function vechile_update($where, $data){
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id($id){
		$this->db->where('v_id', $id);
		$this->db->delete($this->table);
	} 
}

