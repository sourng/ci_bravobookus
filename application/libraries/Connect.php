<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Connect {

	/**
	 * Contains the Connect instance.
	 *
	 * @var Connect
	 */
	private static $instance;
	/**
	 * Initializes the Connect library.
	 * 
	 * Fetches the current user, if logged in or a remember me cookie exists.
	 * Also inits the internal objects.
	 *
	 */
	private static $CI ;
	function __construct($config = array())
	{
		self::$instance =& $this;
		// Get CodeIgniter instance and load necessary libraries and helpers
		$CI =& get_instance();

        $CI->load->model('m_ps', '', TRUE);
        $this->m_ps =& $CI->m_ps; 
	}
	
	
	/*
	Get setting
	*/
	function get_setting($id = false, $limit = 1)
	{	
		$wheres  = array('type_id' => $id);
	  	$results = $this->m_ps->get_by_sql('SELECT tbl_gallery.*, tbl_gallery_type.name AS type_name FROM  tbl_gallery
														INNER JOIN tbl_gallery_type  ON tbl_gallery.type_id = tbl_gallery_type.id
														where type_id = '. $id . ' LIMIT ' . $limit ,'' );	
		
		//$results = $this->m_ps->get_by_fields('tbl_gallery',$wheres,'id','');
			
		if( sizeof($results) > 0)
		{
			return $results;
		}
		else
			return false;
	}
	
	/*
	Get Main Category
	*/
	function get_main_category($id = false)
	{	
		$wheres  = array('status' => 1);
	  	$results = $this->m_ps->get_select_by_fields('tbl_main_category', $wheres, 'id,name,image','order_','');
			
		if(sizeof($results)>0)
		{
			return $results;
		}
		else
			return false;
	}
	
	/*
	Get Category
	*/
	function get_category($main_cat_id = false)
	{
			
		if($main_cat_id == false){
			$results = $this->m_ps->get_by_sql('SELECT * FROM tbl_category WHERE status = 1 ORDER BY RAND() LIMIT 5');
		}else{
			$wheres  = array( 'status' => 1, 'main_cat_id' => $main_cat_id );
			$results = $this->m_ps->get_select_by_fields('tbl_category', $wheres, 'id, name,image','id','');
		}
		
		if(sizeof($results) > 0 )
		{
			return $results;
		}
		else
			return array();
	}
	
	/*
	Get recommended items
	*/
	function get_recommended_items($cat_id = false)
	{
		$results = $this->m_ps->get_by_sql("SELECT * FROM tbl_product WHERE status = 1 AND rate >= 1  ORDER BY id ASC LIMIT 3",'');
		if(sizeof($results) > 0 )
		{
			return $results;
		}
		else
			return array();
	}
	function get_recommended_items_($cat_id = false)
	{
		$results = $this->m_ps->get_by_sql("SELECT * FROM tbl_product WHERE status = 1 AND rate >= 1  ORDER BY id ASC LIMIT 3 OFFSET 3",'');
		if(sizeof($results) > 0 )
		{
			return $results;
		}
		else
			return array();
	}
	
	/*
	Get recommended items
	*/
	function get_product_by_cat($cat_id = false)
	{
		$results = $this->m_ps->get_by_sql("SELECT * FROM tbl_product WHERE status = 1 AND cat_id = {$cat_id} ORDER BY RAND() LIMIT 4",'');
		if(sizeof($results) > 0 )
		{
			return $results;
		}
		else
			return array();
	}
	
	/*
	Get Ads Top
	*/
	function get_ads($type_id = false)
	{
		$results = $this->m_ps->get_by_sql("SELECT * FROM promotion WHERE  type_id = {$type_id} ORDER BY id DESC",'');
		if(sizeof($results) > 0 )
		{
			return $results;
		}
		else
			return array();
	}
	
	function has_permission($controller_name)
	{
		$CI =& get_instance();
		$uid = $CI->session->userdata('uid');
		$group_level = $CI->session->userdata('group_level');
		//check group of user level >= 5000
		if($group_level >= 5000)
			return true;
			
		//get controller id by name
		//get branch permission by User		
		$wheres  = array('name' => $controller_name);
	  	$results = $this->m_ps->get_select_by_fields('controllers', $wheres, 'id','id','');
			
		if(sizeof($results)>0)
		{
			// check permission
			$datas	= array(
						 'user_id'			=> $uid,
						 'controller_id'	=> $results[0]['id']
						);
						
			$result	= $this->m_ps->get_by_fields('controllers_permission', $datas, 'user_id');
			
			$wheres  = array('user_id' => $uid);
	  		$get_controllers_id = $this->m_ps->get_select_by_fields('controllers_permission', $wheres, 'controller_id','user_id','');
		
			if(sizeof($get_controllers_id)>0)
				return	(in_array($results[0]['id'], explode(",", $get_controllers_id[0]['controller_id'])))? true : false;
			else
				return false;
		}
		else
			return false;
	}
	
	
	/**
	 * getHTTPContent
	 */
	public function getHTTPContent($strLink)
	{
		$curl_handle = curl_init();
		curl_setopt($curl_handle,CURLOPT_URL,$strLink);
		curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,2);
		curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);
		$strContent = curl_exec($curl_handle);
		curl_close($curl_handle);
		
		return $strContent;
		//return 'ACK:1001,1:::';
		
	}
	
	/**
	 * Get message
	 */
	public function message($message = '', $type = 'success')
	{
		
		
		if($type == 'success')
		{
			$html = '<div class="alert alert-success" role="alert">
						<strong>Well done!</strong>'.$message.'</div>';
		}
		elseif($type == 'info')
		{
			$html = '<div class="alert alert-info" role="alert">
						<strong>Heads up!</strong>'.$message.'</div>';
		}
		elseif($type == 'warning')
		{
			$html = '<div class="alert alert-warning" role="alert">
						<strong>Warning!</strong>'.$message.'</div>';
		}
		else
		{
			$html = '<div class="alert alert-danger" role="alert">
						<strong>Something wrong!</strong>'.$message.'</div>';
		}
		
		/*$html .= '<script>						
					//$(document).ready(function(){
						setTimeout(hideNotificationMessage,3000);
						function hideNotificationMessage()
							$("#notification_message").trigger("click");
					//});
				</script>
					';*/
		return $html;
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
					$view .='<li><a  rel="'. $current_page .'">&lsaquo;&lsaquo; Previous</a></li>';
				}
				else
				{
					$previous=$current_page-1;
					$view .='<li><a  rel="'. $previous .'">&lsaquo;&lsaquo; Previous</a></li>';
				}
				
				//First = num 1	
				if($current_page>6)
					$view .= '<li><a  rel="1">1...</a></li>';
				
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
					$view .='<li><a class="current" rel="'. $i .'">'. $i .'</a></li>';
					else
					$view .='<li><a rel="'. $i .'">'. $i .'</a></li>';
				}
				
				//Last = num of last page	
				if($current_page<$pages-5)
					$view .= '<li><a  rel="'.$pages.'">...'.$pages.'</a></li>';
				
				//Next
				if($current_page == $pages)	
				{
					$view .='<li><a  rel="'. $pages .'">Next &rsaquo;&rsaquo;</a></li>';
				}
				else
				{
					$next=$current_page+1;
					$view .='<li><a  rel="'. $next .'">Next &rsaquo;&rsaquo;</a></li>';
				}
			}
		$view .='</ul>';
		
		return $view;
	}
}


/* End of file connect.php */
/* Location: ./application/libraries/connect.php */