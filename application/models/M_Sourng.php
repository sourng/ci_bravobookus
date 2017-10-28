<?php
class M_Sourng extends CI_Model {
	public $tbl_hotels="hotels";
	
	public function __construct()
	{
		$this->load->database();
	}	
/*
public function index($limit,$offset){
//$sql='';
		$sql="SELECT hotels.*,destinations.destinations,hotel_rooms.* 
		FROM hotels INNER JOIN destinations ON destinations.dest_id=hotels.dest_id 
		INNER JOIN hotel_rooms ON hotels.hotel_id=hotel_rooms.hotel_id 
		WHERE hotels.hotel_blocked='N' GROUP BY hotels.hotel_id 
		ORDER BY hotel_rooms.hr_base_rate ASC
		LIMIT $limit,$offset";

		//$query	= $this->db->limit($limit,$offset);
		$query=$this->db->query($sql);
		// if($option == 'trace')
		// 	print_r($this->db->queries);		
			
		if(!empty($query))
		{
			$results = array();
			if ( $query->num_rows() > 0 )
				$results = $query->result_array();
			return $results;	
		}

}
*/
//fetch blogs
function get_hotels_page($limit, $offset) {
    	//$sql='';
    	//$table='hotels';

        if ($offset >0) {
            $offset = ($offset - 1) * $limit;   
            //$offset =  $limit;   
               
        } 
          $table="SELECT hotels.*,destinations.destinations,hotel_rooms.* 
			FROM hotels INNER JOIN destinations ON destinations.dest_id=hotels.dest_id 
			INNER JOIN hotel_rooms ON hotels.hotel_id=hotel_rooms.hotel_id 
			WHERE hotels.hotel_blocked='N' GROUP BY hotels.hotel_id 
			ORDER BY hotel_rooms.hr_base_rate ASC
			LIMIT $limit,$offset";  

        // $result['rows'] = $this->db->query($table, $limit, $offset);
        $result['rows'] = $this->db->query($table);
        $result['num_rows'] =$this->count($table);//
          //$result['num_rows']=$this->db->count_all_results($table);
        return $result;


    }


public function count($sql){
	// return $this->db->count_all_results($this->$tbl_hotels);
	//return $this->db->count_all_results($sql);
	$query	= $this->db->query($sql);
        // if($options == 'trace')
        //     print_r($this->db->queries);

		if(!empty($query))
		{
			$count = $query->num_rows();
			return $count;	
		}		
}

function get_top_hotels(){
			
			$this->db->select('h.hotel_id,h.h_name,h.h_feature_image,h.province,d.destinations,d.dest_landmark,d.country');
			$this->db->from('hotels h'); 
			$this->db->join('destinations d', 'h.dest_id=d.dest_id', 'left');
			// $this->db->join('board_points c', 'c.board_point=a.id', 'left');
			// $this->db->join('bus_type d', 'd.id=b.bus_type_id', 'left');
			// $this->db->join('bus_gallery e', 'e.bus_id=b.id', 'left');
			// $this->db->join('amenities f', 'FIND_IN_SET(f.id,b.amenities_id) > 0', 'left');
			// $this->db->join('drop_points g', 'g.drop_point=a.id', 'left');
			// $this->db->join('cancellation h', 'h.bus_id=b.id', 'left');
			// $this->db->join('rating i', 'i.bus_id=b.id', 'left');
			// $this->db->join('seat_layout j', 'j.bus_id=b.id', 'left');
			// $this->db->join('booking_details k', 'k.bus_id=b.id', 'left');
			// $this->db->where('a.board_point',$data->board_point );
			// $this->db->where('a.drop_point',$data->drop_point);
			//$this->db->where('b.bus_status','1');
			$this->db->limit(4);
			 
			//$this->db->group_by('b.id'); 
			
			
			       
			$query = $this->db->get(); 
			//$result = $query->result_array();
			$result = $query->result();
		 
			return $result;
		}



	// Get Top Hotels
		public function get_top_hotels2()
	{
		$query = $this->db->get('hotels');
		return $query->result();
	}

	/**
	 * Returns the record by one field
	 *
	 */
	function get_by_sql_json($sql, $option=false)
	{
		$query	= $this->db->query($sql);
		
		if($option == 'trace')
			print_r($this->db->queries);		
			
		if(!empty($query))
		{
			$results = array();
			if ( $query->num_rows() > 0 )
				$results = $query->result();
			return $results;	
		}
	}

	// Count By SQL
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
	 * Get Hotel
	 *
	 */
	function get_hotels($wheres = FALSE, $orderby = FALSE, $options = FALSE, $limit = FALSE)
	{
		$this->db->select("
							hotels.*,
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

	public function short_title($old_string,$limit_word){
	// strip tags to avoid breaking any html
	$string = strip_tags($old_string);

	if (strlen($string) > $limit_word) {

	    // truncate string
	    $stringCut = substr($string, 0, $limit_word);

	    // make sure it ends in a word so assassinate doesn't become ass...
	    $string = substr($stringCut, 0, strrpos($stringCut, ' ')).'...'; 
	}
	return($string);
}


}

	?>